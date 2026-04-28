<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Verificada - TARIX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #22c5bc 0%, #1ba8a0 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.95;
            letter-spacing: 1px;
        }
        
        .content {
            padding: 40px;
        }
        
        .greeting {
            margin-bottom: 24px;
        }
        
        .greeting h2 {
            font-size: 20px;
            color: #22c5bc;
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .greeting p {
            color: #666;
            font-size: 15px;
            margin-bottom: 8px;
        }
        
        .verification-box {
            background-color: #e8f5e9;
            border-left: 4px solid #22c5bc;
            padding: 12px;
            margin: 32px 0;
            border-radius: 8px;
        }
        
        .verification-box h3 {
            color: #22c5bc;
            font-size: 16px;
            margin-bottom: 8px;
        }
        
        .verification-box p {
            color: #333;
            font-size: 14px;
        }
        
        .client-type-badge {
            display: inline-block;
            background-color: #22c5bc;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            margin: 12px 0;
        }
        
        .features {
            margin: 32px 0;
        }
        
        .features h3 {
            font-size: 16px;
            color: #333;
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .feature-list {
            list-style: none;
        }
        
        .feature-list li {
            padding: 5px 0;
            padding-left: 28px;
            position: relative;
            color: #555;
            font-size: 14px;
        }
        
        .feature-list li:before {
            position: absolute;
            left: 0;
            color: #22c5bc;
            font-weight: 700;
            font-size: 18px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #22c5bc;
            color: white !important;
            padding: 16px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button:hover {
            background-color: #1ba8a0;
            text-decoration: none;
        }
        
        .footer {
            background-color: #f9f9f9;
            padding: 24px 40px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
        
        .footer p {
            margin: 8px 0;
        }
        
        .footer a {
            color: #22c5bc;
            text-decoration: none;
        }
        
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 12px 0;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 24px;
            }
            
            .greeting h2 {
                font-size: 18px;
            }
            
            .cta-button {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>TARIX</h1>
            <p>Soluciones en Comercio Exterior</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                <h2>{{ __('app.email_verification_greeting', ['name' => $user->name]) }}</h2>
                <p>{!! __('app.email_verification_intro') !!}</p>
            </div>
            
            <!-- Verification Status -->
            <div class="verification-box">
                <h3>{{ __('app.email_verification_status') }}</h3>
                <p>{{ __('app.email_verification_approved') }} <span class="client-type-badge">{{ $clientType }}</span></p>
                <p style="margin-top: 6px; color: #666;">{{ __('app.email_verification_access') }}</p>
            </div>
            
            <!-- Features -->
            <div class="features">
                <h3>{{ __('app.email_verification_features_title') }}</h3>
                <ul class="feature-list">
                    <li>{{ __('app.email_verification_feature_1') }}</li>
                    <li>{{ __('app.email_verification_feature_2') }}</li>
                </ul>
            </div>
            
            <!-- CTA Button -->
            <center>
                <a href="{{ $loginUrl }}" class="cta-button">{{ __('app.email_verification_cta_btn') }}</a>
            </center>
            
            <!-- Additional Info -->
            <div class="divider"></div>
            <p style="color: #666; font-size: 14px;">
                {{ __('app.email_verification_support') }}
            </p>
            
            <p style="color: #666; font-size: 14px; margin-top: 16px;">
                {{ __('app.email_verification_commitment') }}
            </p>
            
            <p style="margin-top: 24px; color: #999; font-size: 13px;">
                {{ __('app.email_verification_closing') }}<br>
                <strong>{{ __('app.email_verification_team') }}</strong>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} TARIX | Soluciones en Comercio Exterior</p>
            <p>Hecho en Colombia 🇨🇴</p>
            <p>
                <a href="https://tarix.com.co">tarix.com.co</a> | 
                <a href="mailto:info@tarix.com.co">info@tarix.com.co</a>
            </p>
        </div>
    </div>
</body>
</html>
