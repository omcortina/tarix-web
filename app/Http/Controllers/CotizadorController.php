<?php

namespace App\Http\Controllers;

use App\Models\EmailAccount;
use App\Models\EmailReply;
use App\Models\InboxEmail;
use App\Models\QuoteClient;
use App\Models\QuoteTemplate;
use App\Models\SentQuote;
use App\Services\ImapSyncService;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as SymfonyEmail;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class CotizadorController extends Controller
{
    // ─────────────────────────────────────────────
    // DASHBOARD
    // ─────────────────────────────────────────────

    public function dashboard()
    {
        $totalTemplates   = QuoteTemplate::where('created_by', auth()->id())->count();
        $totalSent        = SentQuote::where('sent_by', auth()->id())->count();
        $totalAccounts    = EmailAccount::count();
        $totalInbox       = InboxEmail::whereHas('emailAccount', fn($q) => $q->where('created_by', auth()->id()))->count();
        $unreadInbox      = InboxEmail::whereHas('emailAccount', fn($q) => $q->where('created_by', auth()->id()))
                            ->where('is_read', false)->count();

        $recentSent = SentQuote::with(['emailAccount'])
            ->where('sent_by', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('cotizador.dashboard', compact(
            'totalTemplates', 'totalSent', 'totalAccounts', 'totalInbox', 'unreadInbox', 'recentSent'
        ));
    }

    // ─────────────────────────────────────────────
    // PLANTILLAS DE COTIZACIÓN
    // ─────────────────────────────────────────────

    public function templates()
    {
        $query = QuoteTemplate::with('creator');

        if (auth()->user()->user_type !== 'ADMIN') {
            $query->where('created_by', auth()->id());
        }

        $templates = $query->latest()->get();

        return view('cotizador.templates.index', compact('templates'));
    }

    public function createTemplate()
    {
        return view('cotizador.templates.create');
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:120',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        QuoteTemplate::create([
            'name'       => $request->name,
            'subject'    => $request->subject,
            'body'       => $request->body,
            'is_active'  => true,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('cotizador.templates')->with('success', 'Plantilla creada correctamente.');
    }

    public function editTemplate(QuoteTemplate $template)
    {
        $this->authorizeTemplate($template);
        return view('cotizador.templates.edit', compact('template'));
    }

    public function updateTemplate(Request $request, QuoteTemplate $template)
    {
        $this->authorizeTemplate($template);

        $request->validate([
            'name'    => 'required|string|max:120',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        $template->update([
            'name'      => $request->name,
            'subject'   => $request->subject,
            'body'      => $request->body,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('cotizador.templates')->with('success', 'Plantilla actualizada.');
    }

    public function destroyTemplate(QuoteTemplate $template)
    {
        $this->authorizeTemplate($template);
        $template->delete();
        return redirect()->route('cotizador.templates')->with('success', 'Plantilla eliminada.');
    }

    // ─────────────────────────────────────────────
    // ENVÍO DE COTIZACIONES
    // ─────────────────────────────────────────────

    public function sendQuoteForm()
    {
        $isAdmin = auth()->user()->user_type === 'ADMIN';

        $templates = QuoteTemplate::where('is_active', true)
            ->when(!$isAdmin, fn($q) => $q->where('created_by', auth()->id()))
            ->get();
        $accounts  = EmailAccount::where('is_active', true)->get();
        $clients   = QuoteClient::when(!$isAdmin, fn($q) => $q->where('created_by', auth()->id()))
            ->orderBy('name')->get();

        return view('cotizador.quotes.send', compact('templates', 'accounts', 'clients'));
    }

    public function sendQuote(Request $request)
    {
        $request->validate([
            'email_account_id'  => 'required|exists:email_accounts,id',
            'to_emails'         => 'required|array|min:1|max:20',
            'to_emails.*'       => 'required|email',
            'to_name'           => 'nullable|string|max:120',
            'to_company'        => 'nullable|string|max:150',
            'to_nit'            => 'nullable|string|max:30',
            'to_phone'          => 'nullable|string|max:30',
            'to_city'           => 'nullable|string|max:80',
            'subject'           => 'required|string|max:255',
            'body'              => 'required|string',
            'quote_total'       => 'nullable|string|max:50',
            'quote_validity'    => 'nullable|string|max:50',
            'template_id'       => 'nullable|exists:quote_templates,id',
            'sender_title'      => 'nullable|string|max:120',
            'sender_phone'      => 'nullable|string|max:50',
            'attachments'       => 'nullable|array|max:10',
            'attachments.*'     => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:20480',
        ]);

        $account = EmailAccount::where('id', $request->email_account_id)
            ->where('is_active', true)
            ->firstOrFail();

        // Reemplazar variables de plantilla en asunto y cuerpo
        $templateVars = [
            '{{nombre_cliente}}'   => $request->to_name      ?? '',
            '{{nombre cliente}}'   => $request->to_name      ?? '',
            '{{email_cliente}}'    => $request->to_email     ?? '',
            '{{email cliente}}'    => $request->to_email     ?? '',
            '{{empresa_cliente}}'  => $request->to_company   ?? '',
            '{{empresa cliente}}'  => $request->to_company   ?? '',
            '{{nit_cliente}}'      => $request->to_nit       ?? '',
            '{{nit cliente}}'      => $request->to_nit       ?? '',
            '{{telefono_cliente}}' => $request->to_phone     ?? '',
            '{{telefono cliente}}' => $request->to_phone     ?? '',
            '{{ciudad_cliente}}'   => $request->to_city      ?? '',
            '{{ciudad cliente}}'   => $request->to_city      ?? '',
            '{{total}}'              => $request->quote_total    ?? '',
            '{{vigencia}}'           => $request->quote_validity ?? '',
            '{{fecha}}'              => now()->format('d/m/Y'),
            '{{remitente}}'          => auth()->user()->name,
            '{{cargo_cotizador}}'    => $request->sender_title  ?? '',
            '{{telefono_cotizador}}' => $request->sender_phone  ?? '',
        ];

        $finalSubject = str_replace(array_keys($templateVars), array_values($templateVars), $request->subject);
        $finalBody    = str_replace(array_keys($templateVars), array_values($templateVars), $request->body);

        $attachmentPaths = [];

        // Guardar archivos adjuntos si el cotizador subió alguno
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = 'adjunto_' . now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
                $attachmentPaths[] = $file->storeAs('quotes', $fileName);
            }
        }

        $success  = true;
        $errorMsg = null;
        $errors   = [];

        try {
            $fromName = $account->smtp_from_name ?: $account->email;
            $htmlBody = $this->wrapInEmailTemplate($finalBody, $fromName, $account->email, $request->sender_title, $request->sender_phone);
            foreach ($request->to_emails as $toEmail) {
                $toEmail = trim($toEmail);
                if (!$toEmail) continue;
                try {
                    $this->sendViaSmtp($account, $toEmail, $request->to_name, $finalSubject, $htmlBody, $attachmentPaths);
                } catch (\Exception $e) {
                    $errors[] = "{$toEmail}: " . $e->getMessage();
                }
            }
            if (!empty($errors)) {
                $success  = false;
                $errorMsg = implode(' | ', $errors);
            }
        } catch (\Exception $e) {
            $success  = false;
            $errorMsg = $e->getMessage();
        }

        SentQuote::create([
            'sent_by'           => auth()->id(),
            'email_account_id'  => $account->id,
            'template_id'       => $request->template_id,
            'to_email'          => implode(', ', $request->to_emails),
            'to_name'           => $request->to_name,
            'subject'           => $finalSubject,
            'body'              => $finalBody,
            'pdf_path'          => !empty($attachmentPaths) ? $attachmentPaths : null,
            'sent_at'           => now(),
            'success'           => $success,
            'error_message'     => $errorMsg,
        ]);

        if (!$success) {
            return back()->with('error', 'Error al enviar el correo: ' . $errorMsg)->withInput();
        }

        return redirect()->route('cotizador.quotes.history')->with('success', 'Cotización enviada correctamente.');
    }

    public function quotesHistory()
    {
        $query = SentQuote::with(['emailAccount', 'template', 'sender']);

        if (auth()->user()->user_type !== 'ADMIN') {
            $query->where('sent_by', auth()->id());
        }

        $quotes = $query->latest()->get();

        return view('cotizador.quotes.history', compact('quotes'));
    }

    // ─────────────────────────────────────────────
    // CUENTAS DE CORREO
    // ─────────────────────────────────────────────

    public function emailAccounts()
    {
        $isAdmin  = auth()->user()->user_type === 'ADMIN';
        $accounts = EmailAccount::latest()->get();
        return view('cotizador.email-accounts.index', compact('accounts'));
    }

    public function createEmailAccount()
    {
        return view('cotizador.email-accounts.create');
    }

    public function storeEmailAccount(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:120',
            'email'           => 'required|email',
            'imap_host'       => 'nullable|string|max:255',
            'imap_port'       => 'nullable|integer|min:1|max:65535',
            'imap_encryption' => 'required|in:ssl,tls,starttls,none',
            'imap_username'   => 'nullable|string|max:255',
            'imap_password'   => 'nullable|string',
            'smtp_host'       => 'nullable|string|max:255',
            'smtp_port'       => 'nullable|integer|min:1|max:65535',
            'smtp_encryption' => 'required|in:ssl,tls,starttls,none',
            'smtp_username'   => 'nullable|string|max:255',
            'smtp_password'   => 'nullable|string',
            'smtp_from_name'  => 'nullable|string|max:120',
        ]);

        EmailAccount::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'imap_host'       => $request->imap_host,
            'imap_port'       => $request->imap_port ?? 993,
            'imap_encryption' => $request->imap_encryption,
            'imap_username'   => $request->imap_username,
            'imap_password'   => $request->imap_password,
            'smtp_host'       => $request->smtp_host,
            'smtp_port'       => $request->smtp_port ?? 587,
            'smtp_encryption' => $request->smtp_encryption,
            'smtp_username'   => $request->smtp_username,
            'smtp_password'   => $request->smtp_password,
            'smtp_from_name'  => $request->smtp_from_name,
            'is_active'       => true,
            'created_by'      => auth()->id(),
        ]);

        return redirect()->route('cotizador.email-accounts')->with('success', 'Cuenta de correo agregada.');
    }

    public function editEmailAccount(EmailAccount $emailAccount)
    {
        $this->authorizeAccount($emailAccount);
        return view('cotizador.email-accounts.edit', compact('emailAccount'));
    }

    public function updateEmailAccount(Request $request, EmailAccount $emailAccount)
    {
        $this->authorizeAccount($emailAccount);

        $request->validate([
            'name'            => 'required|string|max:120',
            'email'           => 'required|email',
            'imap_host'       => 'nullable|string|max:255',
            'imap_port'       => 'nullable|integer|min:1|max:65535',
            'imap_encryption' => 'required|in:ssl,tls,starttls,none',
            'imap_username'   => 'nullable|string|max:255',
            'imap_password'   => 'nullable|string',
            'smtp_host'       => 'nullable|string|max:255',
            'smtp_port'       => 'nullable|integer|min:1|max:65535',
            'smtp_encryption' => 'required|in:ssl,tls,starttls,none',
            'smtp_username'   => 'nullable|string|max:255',
            'smtp_password'   => 'nullable|string',
            'smtp_from_name'  => 'nullable|string|max:120',
        ]);

        $data = [
            'name'            => $request->name,
            'email'           => $request->email,
            'imap_host'       => $request->imap_host,
            'imap_port'       => $request->imap_port ?? 993,
            'imap_encryption' => $request->imap_encryption,
            'imap_username'   => $request->imap_username,
            'smtp_host'       => $request->smtp_host,
            'smtp_port'       => $request->smtp_port ?? 587,
            'smtp_encryption' => $request->smtp_encryption,
            'smtp_username'   => $request->smtp_username,
            'smtp_from_name'  => $request->smtp_from_name,
            'is_active'       => $request->has('is_active'),
        ];

        // Solo actualizar contraseñas si se proporcionaron nuevas
        if ($request->filled('imap_password')) {
            $data['imap_password'] = $request->imap_password;
        }
        if ($request->filled('smtp_password')) {
            $data['smtp_password'] = $request->smtp_password;
        }

        $emailAccount->update($data);

        return redirect()->route('cotizador.email-accounts')->with('success', 'Cuenta actualizada.');
    }

    public function destroyEmailAccount(EmailAccount $emailAccount)
    {
        $this->authorizeAccount($emailAccount);
        $emailAccount->delete();
        return redirect()->route('cotizador.email-accounts')->with('success', 'Cuenta eliminada.');
    }

    // ─────────────────────────────────────────────
    // BANDEJA DE ENTRADA (INBOX)
    // ─────────────────────────────────────────────

    public function inbox(Request $request)
    {
        $isAdmin  = auth()->user()->user_type === 'ADMIN';
        $accounts = EmailAccount::where('is_active', true)->get();

        $selectedAccountId = $request->get('account_id', $accounts->first()?->id);
        $selectedAccount   = $accounts->firstWhere('id', $selectedAccountId);

        $emails = collect();
        if ($selectedAccount) {
            $emails = InboxEmail::where('email_account_id', $selectedAccount->id)
                ->orderByDesc('received_at')
                ->paginate(25);
        }

        return view('cotizador.inbox.index', compact('accounts', 'selectedAccount', 'emails'));
    }

    public function syncInbox(Request $request, ImapSyncService $imapService)
    {
        $request->validate([
            'account_id' => 'required|exists:email_accounts,id',
        ]);

        $account = EmailAccount::where('id', $request->account_id)
            ->firstOrFail();

        $result = $imapService->sync($account);

        if (!empty($result['errors'])) {
            return back()->with('error', implode(' | ', $result['errors']));
        }

        return back()->with('success', "Sincronización completada. {$result['imported']} correo(s) nuevo(s) importado(s).");
    }

    public function showEmail(InboxEmail $inboxEmail)
    {
        $this->authorizeInboxEmail($inboxEmail);

        // Marcar como leído
        if (!$inboxEmail->is_read) {
            $inboxEmail->update(['is_read' => true]);
        }

        $isAdmin = auth()->user()->user_type === 'ADMIN';

        $templates   = QuoteTemplate::where('is_active', true)
            ->when(!$isAdmin, fn($q) => $q->where('created_by', auth()->id()))
            ->get();
        $accounts    = EmailAccount::where('is_active', true)->get();
        $replies     = $inboxEmail->replies()->with('sender', 'emailAccount')->latest()->get();
        $attachments = $inboxEmail->attachments()->where('is_inline', false)->orderBy('original_name')->get();

        return view('cotizador.inbox.show', compact('inboxEmail', 'templates', 'accounts', 'replies', 'attachments'));
    }

    public function downloadInboxAttachment(InboxEmail $inboxEmail, \App\Models\InboxAttachment $attachment)
    {
        $this->authorizeInboxEmail($inboxEmail);

        if ($attachment->inbox_email_id !== $inboxEmail->id) {
            abort(404);
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($attachment->storage_path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $attachment->storage_path,
            $attachment->original_name,
            ['Content-Type' => $attachment->mime_type ?? 'application/octet-stream']
        );
    }

    public function replyEmail(Request $request, InboxEmail $inboxEmail)
    {
        $this->authorizeInboxEmail($inboxEmail);

        $request->validate([
            'email_account_id' => 'required|exists:email_accounts,id',
            'subject'          => 'required|string|max:255',
            'body'             => 'required|string',
            'template_id'      => 'nullable|exists:quote_templates,id',
        ]);

        $account = EmailAccount::where('id', $request->email_account_id)
            ->where('is_active', true)
            ->firstOrFail();

        $success  = true;
        $errorMsg = null;

        try {
            $fromName = $account->smtp_from_name ?: $account->email;
            $htmlBody = $this->wrapInEmailTemplate($request->body, $fromName, $account->email);
            $this->sendViaSmtp($account, $inboxEmail->from_email, $inboxEmail->from_name, $request->subject, $htmlBody);
        } catch (\Exception $e) {
            $success  = false;
            $errorMsg = $e->getMessage();
        }

        EmailReply::create([
            'inbox_email_id'   => $inboxEmail->id,
            'sent_by'          => auth()->id(),
            'email_account_id' => $account->id,
            'template_id'      => $request->template_id,
            'to_email'         => $inboxEmail->from_email,
            'subject'          => $request->subject,
            'body'             => $request->body,
            'success'          => $success,
            'error_message'    => $errorMsg,
            'sent_at'          => now(),
        ]);

        if (!$success) {
            return back()->with('error', 'Error al enviar la respuesta: ' . $errorMsg);
        }

        return back()->with('success', 'Respuesta enviada correctamente.');
    }

    // ─────────────────────────────────────────────
    // API: cargar cuerpo de plantilla (AJAX)
    // ─────────────────────────────────────────────

    public function templateBody(QuoteTemplate $template)
    {
        $this->authorizeTemplate($template);
        return response()->json([
            'subject' => $template->subject,
            'body'    => $template->body,
        ]);
    }

    // ─────────────────────────────────────────────
    // CLIENTES
    // ─────────────────────────────────────────────

    public function clients()
    {
        $query = QuoteClient::query();

        if (auth()->user()->user_type !== 'ADMIN') {
            $query->where('created_by', auth()->id());
        }

        $clients = $query->latest()->paginate(20);

        return view('cotizador.clients.index', compact('clients'));
    }

    public function createClient()
    {
        return view('cotizador.clients.create');
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email|max:180',
            'company' => 'nullable|string|max:150',
            'nit'     => 'nullable|string|max:30',
            'phone'   => 'nullable|string|max:30',
            'city'    => 'nullable|string|max:80',
            'notes'   => 'nullable|string|max:500',
        ]);

        QuoteClient::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'company'    => $request->company,
            'nit'        => $request->nit,
            'phone'      => $request->phone,
            'city'       => $request->city,
            'notes'      => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('cotizador.clients')->with('success', 'Cliente guardado correctamente.');
    }

    public function editClient(QuoteClient $client)
    {
        $this->authorizeClient($client);
        return view('cotizador.clients.edit', compact('client'));
    }

    public function updateClient(Request $request, QuoteClient $client)
    {
        $this->authorizeClient($client);

        $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email|max:180',
            'company' => 'nullable|string|max:150',
            'nit'     => 'nullable|string|max:30',
            'phone'   => 'nullable|string|max:30',
            'city'    => 'nullable|string|max:80',
            'notes'   => 'nullable|string|max:500',
        ]);

        $client->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'company' => $request->company,
            'nit'     => $request->nit,
            'phone'   => $request->phone,
            'city'    => $request->city,
            'notes'   => $request->notes,
        ]);

        return redirect()->route('cotizador.clients')->with('success', 'Cliente actualizado.');
    }

    public function destroyClient(QuoteClient $client)
    {
        $this->authorizeClient($client);
        $client->delete();
        return redirect()->route('cotizador.clients')->with('success', 'Cliente eliminado.');
    }

    // ─────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ─────────────────────────────────────────────

    private function authorizeClient(QuoteClient $client): void
    {
        if (auth()->user()->user_type !== 'ADMIN' && $client->created_by !== auth()->id()) {
            abort(403);
        }
    }

    private function authorizeTemplate(QuoteTemplate $template): void
    {
        if (auth()->user()->user_type !== 'ADMIN' && $template->created_by !== auth()->id()) {
            abort(403);
        }
    }

    private function authorizeAccount(EmailAccount $account): void
    {
        if (auth()->user()->user_type !== 'ADMIN' && $account->created_by !== auth()->id()) {
            abort(403);
        }
    }

    private function authorizeInboxEmail(InboxEmail $email): void
    {
        if (auth()->user()->user_type !== 'ADMIN' && $email->emailAccount->created_by !== auth()->id()) {
            abort(403);
        }
    }

    /**
     * Enviar correo usando la configuración SMTP de la cuenta seleccionada (Symfony Mailer).
     */
    private function sendViaSmtp(
        EmailAccount $account,
        string $toEmail,
        ?string $toName,
        string $subject,
        string $body,
        array $attachmentPaths = []
    ): void {
        if (!$account->smtp_host || !$account->smtp_username || !$account->smtp_password) {
            throw new \RuntimeException('La cuenta de correo no tiene configuración SMTP completa.');
        }

        $useTls = in_array($account->smtp_encryption, ['tls', 'starttls']);
        $useSsl = $account->smtp_encryption === 'ssl';

        $transport = new EsmtpTransport(
            $account->smtp_host,
            (int) $account->smtp_port,
            $useSsl
        );

        $transport->setUsername($account->smtp_username);
        $transport->setPassword($account->smtp_password);

        $mailer = new Mailer($transport);

        $fromName = $account->smtp_from_name ?: $account->email;

        $email = (new SymfonyEmail())
            ->from(new Address($account->email, $fromName))
            ->to(new Address($toEmail, $toName ?: $toEmail))
            ->subject($subject)
            ->html($body);

        foreach ($attachmentPaths as $storagePath) {
            $fullPath = storage_path('app/' . $storagePath);
            if (file_exists($fullPath)) {
                $email->addPart(new DataPart(new File($fullPath), basename($fullPath)));
            }
        }

        $mailer->send($email);
    }

    private function wrapInEmailTemplate(string $bodyContent, string $fromName, string $fromEmail, ?string $senderTitle = null, ?string $senderPhone = null): string
    {
        $year       = date('Y');
        $date       = now()->format('d/m/Y');
        $titleLine  = $senderTitle  ? "<p style=\"margin:2px 0 0;font-size:12px;color:#374151;font-style:italic;\">{$senderTitle}</p>" : '';
        $phoneLine  = $senderPhone  ? "<p style=\"margin:2px 0 0;font-size:12px;color:#64748b;\">Cel: {$senderPhone}</p>" : '';

        return <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin:0;padding:0;background-color:#f0f2f5;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f2f5;padding:40px 16px;">
                <tr>
                    <td align="center">

                        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#1a2332;border-radius:10px 10px 0 0;">
                            <tr>
                                <td style="padding:28px 40px;">
                                    <p style="margin:0;font-size:22px;font-weight:800;color:#ffffff;letter-spacing:1px;">TARIX</p>
                                    <p style="margin:4px 0 0;font-size:12px;color:#94a3b8;letter-spacing:0.5px;text-transform:uppercase;">Soluciones en comercio exterior</p>
                                </td>
                                <td style="padding:28px 40px;text-align:right;">
                                    <p style="margin:0;font-size:11px;color:#64748b;">{$date}</p>
                                </td>
                            </tr>
                        </table>

                        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;">
                            <tr>
                                <td style="padding:40px 40px 32px;">
                                    <div style="font-size:15px;line-height:1.8;color:#374151;">
                                        {$bodyContent}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#ffffff;">
                            <tr>
                                <td style="padding:0 40px;">
                                    <div style="height:3px;background-color:#1db899;border-radius:2px;"></div>
                                </td>
                            </tr>
                        </table>

                        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background-color:#f8fafc;border-radius:0 0 10px 10px;border-top:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:20px 40px;">
                                    <p style="margin:0;font-size:13px;font-weight:700;color:#1a2332;">{$fromName}</p>
                                    {$titleLine}
                                    <p style="margin:2px 0 0;font-size:12px;color:#64748b;">{$fromEmail}</p>
                                    {$phoneLine}
                                    <p style="margin:2px 0 0;font-size:12px;color:#64748b;">TARIX — Soluciones en comercio exterior</p>
                                </td>
                            </tr>
                        </table>

                        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;margin-top:16px;">
                            <tr>
                                <td align="center">
                                    <p style="font-size:11px;color:#9ca3af;margin:0;">© {$year} TARIX. Todos los derechos reservados.</p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }
}
