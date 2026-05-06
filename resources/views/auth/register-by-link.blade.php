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
                <p class="register-subtitle">Registro para <strong>{{ $company->name }}</strong></p>
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
            <form method="POST" action="{{ route('register.by-link', $token) }}" id="registerForm">
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
                        value="{{ old('email', $prefilledEmail ?? '') }}"
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

                <!-- Submit Button -->
                <button type="submit" class="btn-register">{{ __('auth.register_button') }}</button>
            </form>

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
