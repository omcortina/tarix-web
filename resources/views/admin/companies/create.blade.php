@extends('layouts.admin')

@section('title', 'Crear Empresa')

@section('extra_css')
<style>
    /* Sin estilos adicionales - todo está en admin-general.css */
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.companies.index') }}">Empresas</a>
        <span>/</span>
        <span>Crear</span>
    </div>

    <div class="admin-header">
        <h1>Crear Nueva Empresa</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Error al guardar:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.companies.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nombre Empresa *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    placeholder="Ej: Mi Empresa S.A."
                    class="form-input @error('name') error @enderror"
                >
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nit">NIT</label>
                    <input 
                        type="text" 
                        id="nit" 
                        name="nit" 
                        value="{{ old('nit') }}"
                        placeholder="Ej: 860123456-7"
                        class="form-input @error('nit') error @enderror"
                    >
                    @error('nit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact_name">Nombre Contacto</label>
                    <input 
                        type="text" 
                        id="contact_name" 
                        name="contact_name" 
                        value="{{ old('contact_name') }}"
                        placeholder="Ej: Juan Pérez"
                        class="form-input @error('contact_name') error @enderror"
                    >
                    @error('contact_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_email">Email Contacto</label>
                    <input 
                        type="email" 
                        id="contact_email" 
                        name="contact_email" 
                        value="{{ old('contact_email') }}"
                        placeholder="contacto@empresa.com"
                        class="form-input @error('contact_email') error @enderror"
                    >
                    @error('contact_email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact_phone">Teléfono Contacto</label>
                    <input 
                        type="tel" 
                        id="contact_phone" 
                        name="contact_phone" 
                        value="{{ old('contact_phone') }}"
                        placeholder="Ej: +57 1 234 5678"
                        class="form-input @error('contact_phone') error @enderror"
                    >
                    @error('contact_phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <textarea 
                    id="address" 
                    name="address" 
                    placeholder="Dirección de la empresa"
                    class="form-textarea @error('address') error @enderror"
                >{{ old('address') }}</textarea>
                @error('address')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <hr style="margin: 30px 0; border: none; border-top: 1px solid #e0e0e0;">

            <div style="background: #f9f9f9; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #333;">Credenciales del Usuario EMPRESA</h3>
                <p style="margin: 0 0 15px 0; font-size: 14px; color: #666;">Se creará automáticamente un usuario de tipo EMPRESA con estas credenciales.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Contraseña *</label>
                        <div style="position: relative;">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Mínimo 8 caracteres"
                                class="form-input @error('password') error @enderror"
                                required
                                style="padding-right: 40px;"
                            >
                            <button type="button" onclick="toggleVisibility('password', 'eyeIconPwd')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#888; padding:0;">
                                <svg id="eyeIconPwd" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña *</label>
                        <div style="position: relative;">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Confirma la contraseña"
                                class="form-input @error('password_confirmation') error @enderror"
                                required
                                style="padding-right: 40px;"
                            >
                            <button type="button" onclick="toggleVisibility('password_confirmation', 'eyeIconConfirm')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#888; padding:0;">
                                <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="margin-top: 8px; display: flex; align-items: center; gap: 12px;">
                    <button type="button" onclick="generateCompanyPassword()" style="padding: 8px 18px; background: #22c5bc; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">Generar contraseña</button>
                    <span id="pwdIndicator" style="font-size: 12px; color: #22c5bc; display: none;"></span>
                </div>
            </div>

            <div class="form-checkbox">
                <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', true))>
                <label for="is_active">Empresa Activa</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Crear Empresa</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    function generateCompanyPassword() {
        const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lower = 'abcdefghijklmnopqrstuvwxyz';
        const digits = '0123456789';
        const special = '!@#$%&*?';
        const all = upper + lower + digits + special;
        let pwd = [
            upper[Math.floor(Math.random() * upper.length)],
            lower[Math.floor(Math.random() * lower.length)],
            digits[Math.floor(Math.random() * digits.length)],
            special[Math.floor(Math.random() * special.length)],
        ];
        for (let i = 4; i < 12; i++) {
            pwd.push(all[Math.floor(Math.random() * all.length)]);
        }
        pwd = pwd.sort(() => Math.random() - 0.5).join('');
        document.getElementById('password').value = pwd;
        document.getElementById('password_confirmation').value = pwd;
        document.getElementById('password').type = 'text';
        document.getElementById('password_confirmation').type = 'text';
        const indicator = document.getElementById('pwdIndicator');
        indicator.textContent = 'Contraseña generada: ' + pwd;
        indicator.style.display = 'block';
    }

    function toggleVisibility(fieldId, iconId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
