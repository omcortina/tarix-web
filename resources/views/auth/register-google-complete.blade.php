<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Registro | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-google-complete.css') }}">
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <a href="/" class="register-logo">
                    <div class="logo-icon">T</div>
                    <div class="logo-text">TARIX</div>
                </a>
                <h1 class="register-title">{{ __('auth.google_complete_title') }}</h1>
                <p class="register-subtitle">{{ __('auth.google_complete_subtitle') }}</p>
                <div class="google-badge">
                    <i class="fa fa-google"></i> {{ __('auth.registered_with_google') }}
                </div>
            </div>

            <!-- Error messages -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- User Info Display -->
            <div class="user-info-display">
                <div class="user-info-item">
                    <div class="user-info-label">{{ __('auth.name') }}</div>
                    <div class="user-info-value">{{ $name }}</div>
                </div>
                <div class="user-info-item">
                    <div class="user-info-label">{{ __('auth.email') }}</div>
                    <div class="user-info-value">{{ $email }}</div>
                </div>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register.google.store') }}" id="completeForm">
                @csrf

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">{{ __('auth.phone_required') }}</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="{{ __('auth.phone_placeholder') }}" 
                        value="{{ old('phone') }}"
                        required
                        autofocus
                        class="@error('phone') error @enderror"
                    >
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Company Selection -->
                @if($companies->count() > 0)
                <div class="form-group">
                    <label for="company_id">{{ __('auth.company') }} *</label>
                    <select 
                        id="company_id" 
                        name="company_id"
                        required
                        class="@error('company_id') error @enderror"
                    >
                        <option value="">Seleccionar empresa...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="btn-continue">{{ __('auth.complete_button') }}</button>
            </form>
        </div>
    </div>
</body>
</html>
