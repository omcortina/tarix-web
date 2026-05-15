<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-icon">T</div>
            <h1>{{ __('auth.login_title') }}</h1>
            <p>{{ __('auth.login_subtitle') }}</p>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error auto-alert">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('success'))
            <div class="alert alert-success auto-alert">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('auth.email') }}</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('auth.password') }}</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">{{ __('auth.remember_me') }}</label>
            </div>

            <button type="submit" class="btn-login">{{ __('auth.login_button') }}</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-text">{{ __('auth.continue_with') }}</div>
            <div class="divider-line"></div>
        </div>

        <a href="{{ route('google.redirect') }}" class="btn-google">
            <i class="fa fa-google"></i>
            {{ __('auth.login_with_google') }}
        </a>

        <div class="back-link">
            <a href="/">{{ __('auth.back_to_site') }}</a>
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
                }, 3000);
            });
        });
    </script>
</body>
</html>
