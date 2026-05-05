@extends('layouts.admin')

@section('title', 'Editar Empresa')

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
        <span>Editar</span>
    </div>

    <div class="admin-header">
        <h1>Editar Empresa: {{ $company->name }}</h1>
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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.companies.update', $company) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre Empresa *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $company->name) }}"
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
                        value="{{ old('nit', $company->nit) }}"
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
                        value="{{ old('contact_name', $company->contact_name) }}"
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
                        value="{{ old('contact_email', $company->contact_email) }}"
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
                        value="{{ old('contact_phone', $company->contact_phone) }}"
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
                >{{ old('address', $company->address) }}</textarea>
                @error('address')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-checkbox">
                <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $company->is_active))>
                <label for="is_active">Empresa Activa</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
