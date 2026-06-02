<?php

namespace App\Services;

use App\Models\EmailAccount;
use App\Models\InboxAttachment;
use App\Models\InboxEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;

class ImapSyncService
{
    /**
     * Sincronizar la bandeja de entrada de una cuenta de correo via IMAP.
     * Devuelve el número de correos nuevos importados.
     */
    public function sync(EmailAccount $account, int $limit = 50): array
    {
        $result = ['imported' => 0, 'errors' => []];

        if (!$account->imap_host || !$account->imap_username || !$account->imap_password) {
            $result['errors'][] = 'Configuración IMAP incompleta para esta cuenta.';
            return $result;
        }

        try {
            $cm = new ClientManager();

            $client = $cm->make([
                'host'          => $account->imap_host,
                'port'          => $account->imap_port,
                'encryption'    => $account->imap_encryption === 'none' ? false : $account->imap_encryption,
                'validate_cert' => false,
                'username'      => $account->imap_username,
                'password'      => $account->imap_password,
                'protocol'      => 'imap',
            ]);

            $client->connect();

            $folder = $client->getFolder('INBOX');

            // Obtener los últimos N mensajes
            $messages = $folder->messages()->all()->setFetchOrder('desc')->limit($limit)->get();

            foreach ($messages as $message) {
                $uid = (string) $message->getUid();

                // Evitar duplicados
                $existing = InboxEmail::where('email_account_id', $account->id)
                    ->where('uid', $uid)
                    ->first();

                $from      = $message->getFrom();
                $fromEmail = '';
                $fromName  = '';
                if ($from) {
                    $fromAddr  = $from->first();
                    if ($fromAddr) {
                        $fromEmail = $fromAddr->mail ?? '';
                        $fromName  = $this->decodeHeader($fromAddr->personal ?? '');
                    }
                }

                $toField  = $message->getTo();
                $toEmail  = $account->email;
                if ($toField) {
                    $toAddr  = $toField->first();
                    if ($toAddr) {
                        $toEmail = $toAddr->mail ?: $account->email;
                    }
                }

                $subject  = $this->decodeHeader((string) $message->getSubject());
                $bodyText = $this->toUtf8((string) $message->getTextBody());
                $bodyHtml = $this->toUtf8((string) $message->getHtmlBody());

                $date = $message->getDate();
                $receivedAt = now()->toDateTimeString();
                if ($date) {
                    try {
                        $first = method_exists($date, 'first') ? $date->first() : $date;
                        if ($first) {
                            $receivedAt = \Carbon\Carbon::parse($first)->toDateTimeString();
                        }
                    } catch (\Throwable $e) {
                        // usar fecha actual si el parse falla
                    }
                }

                $messageId = (string) $message->getMessageId();

                if ($existing) {
                    $existing->update([
                        'subject'    => $subject ?: '(Sin asunto)',
                        'body_text'  => $bodyText ?: null,
                        'body_html'  => $bodyHtml ?: null,
                        'from_name'  => $fromName ?: null,
                        'from_email' => $fromEmail ?: $existing->from_email,
                    ]);
                    $emailRecord = $existing;
                } else {
                    $emailRecord = InboxEmail::create([
                        'email_account_id' => $account->id,
                        'message_id'       => $messageId ?: null,
                        'uid'              => $uid,
                        'from_email'       => $fromEmail,
                        'from_name'        => $fromName ?: null,
                        'to_email'         => $toEmail,
                        'subject'          => $subject ?: '(Sin asunto)',
                        'body_text'        => $bodyText ?: null,
                        'body_html'        => $bodyHtml ?: null,
                        'received_at'      => $receivedAt,
                        'is_read'          => false,
                        'has_attachments'  => $message->hasAttachments(),
                        'thread_id'        => $messageId ?: null,
                    ]);

                    $result['imported']++;
                }

                // Guardar adjuntos verificando cada uno individualmente
                if ($message->hasAttachments()) {
                    $updatedHtml = $this->saveAttachments($message, $emailRecord, $account, $emailRecord->body_html ?? '');
                    if ($updatedHtml !== ($emailRecord->body_html ?? '')) {
                        $emailRecord->update(['body_html' => $updatedHtml]);
                    }
                }

                // Descargar imágenes externas referenciadas en el HTML (http/https)
                $currentHtml = $emailRecord->fresh()->body_html ?? '';
                if ($currentHtml) {
                    $downloadedHtml = $this->downloadExternalImages($currentHtml, $account, $emailRecord);
                    if ($downloadedHtml !== $currentHtml) {
                        $emailRecord->update(['body_html' => $downloadedHtml]);
                    }
                }
            }

            $client->disconnect();
        } catch (ConnectionFailedException $e) {
            $result['errors'][] = 'No se pudo conectar al servidor IMAP: ' . $e->getMessage();
        } catch (\Exception $e) {
            $result['errors'][] = 'Error al sincronizar: ' . $e->getMessage();
        }

        return $result;
    }

    /**
     * Guarda los adjuntos de un mensaje IMAP en disco y reemplaza referencias cid: en el HTML.
     * Devuelve el HTML actualizado.
     */
    private function saveAttachments($message, InboxEmail $emailRecord, EmailAccount $account, string $bodyHtml): string
    {
        try {
            $attachments = $message->getAttachments();

            foreach ($attachments as $attachment) {
                try {
                    $content = $attachment->getContent();
                    if (empty($content)) {
                        continue;
                    }

                    $rawName   = $attachment->getName() ?: ($attachment->filename ?? 'attachment');
                    $origName  = $this->decodeHeader($rawName);
                    $mimeType  = $attachment->getContentType() ?: 'application/octet-stream';
                    $contentId = $attachment->getId();
                    $cleanCid  = $contentId ? trim($contentId, '<>') : null;
                    $disp      = strtolower($attachment->getDisposition() ?? '');
                    $isInline  = $disp === 'inline' || ($cleanCid !== null && $disp === '');
                    $size      = $attachment->getSize() ?: strlen($content);

                    // Si ya existe un registro para este adjunto con el archivo en disco, saltar
                    $existing = InboxAttachment::where('inbox_email_id', $emailRecord->id)
                        ->where('original_name', $origName)
                        ->first();
                    if ($existing && Storage::disk('public')->exists($existing->storage_path)) {
                        // El archivo ya está guardado; solo actualizar cid: en el HTML si aplica
                        if ($cleanCid && $bodyHtml) {
                            $url      = Storage::disk('public')->url($existing->storage_path);
                            $bodyHtml = str_replace('cid:' . $cleanCid, $url, $bodyHtml);
                        }
                        continue;
                    }

                    // Borrar registro huérfano si el archivo ya no existe en disco
                    if ($existing) {
                        $existing->delete();
                    }

                    $ext = pathinfo($origName, PATHINFO_EXTENSION);
                    if (!$ext) {
                        $ext = $this->mimeToExtension($mimeType);
                    }
                    $storedName  = Str::uuid() . ($ext ? '.' . strtolower($ext) : '');
                    $storagePath = 'inbox-attachments/' . $account->id . '/' . $storedName;

                    Storage::disk('public')->put($storagePath, $content);

                    InboxAttachment::create([
                        'inbox_email_id' => $emailRecord->id,
                        'original_name'  => $origName,
                        'stored_name'    => $storedName,
                        'mime_type'      => $mimeType,
                        'size'           => $size,
                        'content_id'     => $cleanCid,
                        'is_inline'      => $isInline,
                        'storage_path'   => $storagePath,
                    ]);

                    // Reemplazar cid: en el body HTML para que las imágenes incrustadas carguen
                    if ($cleanCid && $bodyHtml) {
                        $url       = Storage::disk('public')->url($storagePath);
                        $bodyHtml  = str_replace('cid:' . $cleanCid, $url, $bodyHtml);
                    }
                } catch (\Throwable $e) {
                    // Un adjunto inválido no debe detener todo
                    continue;
                }
            }
        } catch (\Throwable $e) {
            // Si getAttachments() falla, continuar sin adjuntos
        }

        return $bodyHtml;
    }

    /**
     * Descarga imágenes externas referenciadas en el HTML (src="http://...") y las guarda localmente.
     * Reemplaza las URLs en el HTML. Útil para imágenes de firma alojadas en servidores internos.
     */
    private function downloadExternalImages(string $bodyHtml, EmailAccount $account, InboxEmail $emailRecord): string
    {
        // Buscar todos los src="http://..." o src='http://...' en el HTML
        preg_match_all('/\bsrc=["\']((https?:\/\/[^"\'>\s]{4,}))["\']/i', $bodyHtml, $matches);

        $urls = array_unique($matches[1] ?? []);
        if (empty($urls)) {
            return $bodyHtml;
        }

        // Extensiones de imagen válidas
        $validExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];

        foreach ($urls as $imgUrl) {
            // Saltar URLs que ya apuntan a nuestro storage local
            if (str_contains($imgUrl, '/storage/inbox-attachments/')) {
                continue;
            }

            // Verificar si ya la descargamos antes (buscar por original_name = md5 de URL)
            $urlKey   = md5($imgUrl);
            $existing = InboxAttachment::where('inbox_email_id', $emailRecord->id)
                ->where('stored_name', 'like', $urlKey . '%')
                ->first();

            if ($existing && Storage::disk('public')->exists($existing->storage_path)) {
                $localUrl = Storage::disk('public')->url($existing->storage_path);
                $bodyHtml = str_replace($imgUrl, $localUrl, $bodyHtml);
                continue;
            }

            try {
                $ctx = stream_context_create([
                    'http'  => ['timeout' => 6, 'ignore_errors' => true, 'follow_location' => true, 'max_redirects' => 3],
                    'https' => ['timeout' => 6, 'ignore_errors' => true, 'follow_location' => true, 'max_redirects' => 3, 'verify_peer' => false],
                    'ssl'   => ['verify_peer' => false, 'verify_peer_name' => false],
                ]);

                $data = @file_get_contents($imgUrl, false, $ctx);

                // Saltar si falló, vacío, o muy pequeño (probablemente error 404 HTML)
                if (!$data || strlen($data) < 50) {
                    continue;
                }

                // Detectar extensión desde la URL o MIME type real
                $urlPath = parse_url($imgUrl, PHP_URL_PATH) ?? '';
                $ext     = strtolower(pathinfo($urlPath, PATHINFO_EXTENSION));
                if (!$ext || !in_array($ext, $validExts)) {
                    // Intentar detectar por magic bytes
                    $ext = $this->detectImageExtension($data);
                }
                if (!$ext) {
                    continue; // No es imagen reconocible
                }

                $storedName  = $urlKey . '.' . $ext;
                $storagePath = 'inbox-attachments/' . $account->id . '/' . $storedName;

                Storage::disk('public')->put($storagePath, $data);

                InboxAttachment::create([
                    'inbox_email_id' => $emailRecord->id,
                    'original_name'  => basename($urlPath) ?: $urlKey,
                    'stored_name'    => $storedName,
                    'mime_type'      => 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext),
                    'size'           => strlen($data),
                    'content_id'     => null,
                    'is_inline'      => true,
                    'storage_path'   => $storagePath,
                ]);

                $localUrl = Storage::disk('public')->url($storagePath);
                $bodyHtml = str_replace($imgUrl, $localUrl, $bodyHtml);

            } catch (\Throwable $e) {
                continue;
            }
        }

        return $bodyHtml;
    }

    /**
     * Detecta el tipo de imagen por magic bytes del contenido.
     */
    private function detectImageExtension(string $data): string
    {
        $bytes = substr($data, 0, 12);
        if (str_starts_with($bytes, "\xFF\xD8\xFF"))        return 'jpg';
        if (str_starts_with($bytes, "\x89PNG\r\n\x1A\n"))  return 'png';
        if (str_starts_with($bytes, 'GIF8'))               return 'gif';
        if (str_starts_with($bytes, 'RIFF') && str_contains(substr($data, 0, 20), 'WEBP')) return 'webp';
        if (str_starts_with($bytes, '<svg') || str_contains(substr($data, 0, 200), '<svg')) return 'svg';
        return '';
    }

    /**
     * Devuelve una extensión de archivo típica para un MIME type.
     */
    private function mimeToExtension(string $mimeType): string
    {
        $map = [
            'application/pdf'                                                  => 'pdf',
            'application/msword'                                               => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel'                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint'                                    => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/zip'                                                  => 'zip',
            'application/x-rar-compressed'                                     => 'rar',
            'text/plain'                                                       => 'txt',
            'text/csv'                                                         => 'csv',
            'image/jpeg'                                                       => 'jpg',
            'image/png'                                                        => 'png',
            'image/gif'                                                        => 'gif',
            'image/webp'                                                       => 'webp',
            'image/svg+xml'                                                    => 'svg',
        ];

        return $map[$mimeType] ?? 'bin';
    }

    /**
     * Decodifica un header MIME (subject, from name) forzando salida UTF-8.
     * Soporta múltiples encoded-words: =?iso-8859-1?Q?...?= =?utf-8?B?...?=
     */
    private function decodeHeader(string $value): string
    {
        if ($value === '') {
            return '';
        }

        // Si contiene encoded-words, decodificarlos manualmente (no depende de mbstring.internal_encoding)
        if (preg_match('/=\?[^?]+\?[BQbq]\?/i', $value)) {
            $result = preg_replace_callback(
                '/=\?([^?]+)\?([BQbq])\?([^?]*)\?=/i',
                function (array $m) {
                    $charset  = strtoupper(trim($m[1]));
                    $encoding = strtoupper($m[2]);
                    $text     = $m[3];

                    $raw = $encoding === 'B'
                        ? base64_decode($text)
                        : quoted_printable_decode(str_replace('_', ' ', $text));

                    if (!$raw) {
                        return '';
                    }

                    // Convertir al UTF-8 desde el charset original
                    $charsetNorm = str_replace(['WINDOWS-', 'WIN-'], 'CP', $charset);
                    $converted = @mb_convert_encoding($raw, 'UTF-8', $charsetNorm);
                    if ($converted !== false && $converted !== '') {
                        return $converted;
                    }
                    // Fallback con iconv
                    if (function_exists('iconv')) {
                        $ic = @iconv($charset, 'UTF-8//TRANSLIT//IGNORE', $raw);
                        if ($ic !== false) {
                            return $ic;
                        }
                    }
                    return $raw;
                },
                $value
            );

            return $result ?? $value;
        }

        // Sin encoded-words: garantizar UTF-8
        return $this->toUtf8($value);
    }

    /**
     * Garantiza que un string esté en UTF-8, convirtiendo desde ISO-8859-1 si es necesario.
     */
    private function toUtf8(string $value): string
    {
        if ($value === '') {
            return '';
        }
        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }
        return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
    }
}
