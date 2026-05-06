@extends('layouts.user')

@section('title', 'Link de Registro')
@section('page_title', 'Link de Registro')

@section('content')
<div style="max-width: 100%;">
    <div style="background: white; border-radius: 8px; padding: 28px 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">

    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 18px; font-weight: 700; color: #1a1a2e; margin: 0 0 6px;">Invitar usuario a la empresa</h2>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">Ingresa el correo electrónico al que se enviará el enlace de registro. El usuario podrá registrarse directamente bajo tu empresa.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error" style="margin-bottom: 20px;">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom: 20px;">
            <i class="fa fa-exclamation-circle"></i>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('user.empresa.send-link.send') }}">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                Correo electrónico del destinatario *
            </label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="ejemplo@correo.com"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #111827; outline: none; box-sizing: border-box;"
                class="@error('email') error @enderror"
            >
            @error('email')
                <span style="font-size: 12px; color: #ef4444; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-primary-action" style="padding: 10px 24px; background: #22c5bc; color: #fff; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer;">
            <i class="fa fa-paper-plane"></i> Enviar Link de Registro
        </button>
    </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 400);
            }, 3000);
        });
    });
</script>

@endsection
