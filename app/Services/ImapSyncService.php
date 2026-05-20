<?php

namespace App\Services;

use App\Models\EmailAccount;
use App\Models\InboxEmail;
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
                        $fromName  = mb_decode_mimeheader($fromAddr->personal ?? '');
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

                $subject  = mb_decode_mimeheader((string) $message->getSubject());
                $bodyText = (string) $message->getTextBody();
                $bodyHtml = (string) $message->getHtmlBody();

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
                } else {
                    InboxEmail::create([
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
            }

            $client->disconnect();
        } catch (ConnectionFailedException $e) {
            $result['errors'][] = 'No se pudo conectar al servidor IMAP: ' . $e->getMessage();
        } catch (\Exception $e) {
            $result['errors'][] = 'Error al sincronizar: ' . $e->getMessage();
        }

        return $result;
    }
}
