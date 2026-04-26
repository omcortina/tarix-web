<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro en Proceso | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pending-approval.css') }}">
</head>
<body>
    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-badge">
                <i class="fa fa-clock-o"></i> {{ __('auth.pending_badge') }}
            </div>

            <div class="pending-icon">
                <i class="fa fa-check-circle"></i>
            </div>

            <h1 class="pending-title">{{ __('auth.pending_title') }}</h1>

            <p class="pending-subtitle">
                {{ __('auth.pending_subtitle') }}
            </p>

            <div class="pending-info">
                <div class="pending-info-item">
                    <div class="pending-info-icon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div>
                        <div class="pending-info-text">
                            <strong>{{ __('auth.pending_item_1_title') }}</strong>
                            {{ __('auth.pending_item_1_desc') }}
                        </div>
                    </div>
                </div>

                <div class="pending-info-item">
                    <div class="pending-info-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div>
                        <div class="pending-info-text">
                            <strong>{{ __('auth.pending_item_2_title') }}</strong>
                            {{ __('auth.pending_item_2_desc') }}
                        </div>
                    </div>
                </div>

                <div class="pending-info-item">
                    <div class="pending-info-icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                    <div>
                        <div class="pending-info-text">
                            <strong>{{ __('auth.pending_item_3_title') }}</strong>
                            {{ __('auth.pending_item_3_desc') }}
                        </div>
                    </div>
                </div>
            </div>

            <a href="/" class="btn-home">
                <i class="fa fa-home"></i> {{ __('auth.go_home') }}
            </a>
        </div>
    </div>
</body>
</html>
