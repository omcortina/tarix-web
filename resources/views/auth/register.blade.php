<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
                <h1 class="register-title">{{ __('auth.register_title') }}</h1>
                <p class="register-subtitle">{{ __('auth.register_subtitle') }}</p>
            </div>

            <!-- Error messages -->
            @if ($errors->any())
                <div class="alert alert-error auto-alert">
                    <i class="fa fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">{{ __('auth.full_name') }} *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="{{ __('auth.full_name_placeholder') }}" 
                        value="{{ old('name') }}"
                        required
                        class="@error('name') error @enderror"
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">{{ __('auth.email') }} *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="{{ __('auth.email_placeholder') }}" 
                        value="{{ old('email') }}"
                        required
                        class="@error('email') error @enderror"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">{{ __('auth.phone') }} *</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="{{ __('auth.phone_placeholder') }}" 
                        value="{{ old('phone') }}"
                        required
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

                <!-- Password -->
                <div class="form-group">
                    <label for="password">{{ __('auth.password') }} *</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="{{ __('auth.password_placeholder') }}" 
                        required
                        class="@error('password') error @enderror"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('auth.confirm_password') }} *</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="{{ __('auth.confirm_password_placeholder') }}" 
                        required
                        class="@error('password_confirmation') error @enderror"
                    >
                    @error('password_confirmation')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Terms checkbox -->
                {{-- <div class="form-checkbox">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        required
                    >
                    <label for="terms" style="margin: 0; cursor: pointer;">
                        Acepto los <a href="#">términos y condiciones</a> y la <a href="#">política de privacidad</a>
                    </label>
                </div> --}}

                <!-- Submit Button -->
                <button type="submit" class="btn-register">{{ __('auth.register_button') }}</button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">{{ __('auth.continue_with') }}</div>
                <div class="divider-line"></div>
            </div>

            <!-- Google Register Button -->
            <a href="{{ route('google.redirect') }}" class="btn-google">
                <i class="fa fa-google"></i>
                {{ __('auth.continue_with_google') }}
            </a>

            <!-- Footer -->
            <div class="register-footer">
                {{ __('auth.already_have_account') }} 
                <a href="{{ route('login') }}">{{ __('auth.login_here') }}</a>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .auto-alert.fade-out {
            animation: fadeOut 0.3s ease forwards;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 2500);
            });
        });
    </script>
</body>
</html>
