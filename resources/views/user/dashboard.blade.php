<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.dashboard_title') }} | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-user.css') }}">
</head>
<body>
    <div class="user-wrapper">
        <!-- Mobile Top Bar -->
        <div class="user-top-bar" style="display: none;" id="mobileTopBar">
            <h1>TARIX</h1>
            <button class="user-hamburger" id="hamburgerBtn">
                <i class="fa fa-bars"></i>
                <i class="fa fa-times" style="display: none;"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside class="user-sidebar" id="userSidebar">
            <div class="user-sidebar-logo">
                <h2>TARIX</h2>
            </div>

            <ul class="user-sidebar-menu">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="active">
                        <i class="fa fa-home"></i>
                        {{ __('app.sidebar_home') }}
                    </a>
                </li>
            </ul>

            <div class="user-sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="user-logout-btn">
                        <i class="fa fa-sign-out"></i>
                        {{ __('app.sidebar_logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content -->
        <main class="user-content">
            <div class="user-header">
                <h1>{{ __('app.dashboard_welcome', ['name' => Auth::user()->name]) }}</h1>
                <div class="user-info">
                    <div class="user-info-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info-text">
                        <small>{{ __('app.dashboard_account') }}</small>
                        <strong>{{ Auth::user()->client_type ?? __('app.dashboard_account_type') }}</strong>
                    </div>
                </div>
            </div>

            <div class="user-cards-grid">
                <!-- Card 1: Clasificación Arancelaria -->
                <a href="#" class="user-card arancel">
                    <div class="user-card-icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <h3>{{ __('app.dashboard_classification_title') }}</h3>
                    <p>{{ __('app.dashboard_classification_desc') }}</p>
                </a>

                <!-- Card 2: Consulta de Trámites -->
                <a href="#" class="user-card tramite">
                    <div class="user-card-icon">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <h3>{{ __('app.dashboard_procedures_title') }}</h3>
                    <p>{{ __('app.dashboard_procedures_desc') }}</p>
                </a>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const userSidebar = document.getElementById('userSidebar');
            const mobileTopBar = document.getElementById('mobileTopBar');
            const barsIcon = hamburgerBtn.querySelector('.fa-bars');
            const timesIcon = hamburgerBtn.querySelector('.fa-times');

            // Show mobile top bar on small screens
            function updateMobileView() {
                if (window.innerWidth <= 768) {
                    mobileTopBar.style.display = 'flex';
                } else {
                    mobileTopBar.style.display = 'none';
                    userSidebar.classList.remove('active');
                    hamburgerBtn.classList.remove('active');
                    barsIcon.style.display = 'flex';
                    timesIcon.style.display = 'none';
                }
            }

            updateMobileView();

            // Toggle menu on hamburger click
            hamburgerBtn.addEventListener('click', function() {
                userSidebar.classList.toggle('active');
                hamburgerBtn.classList.toggle('active');
                
                if (userSidebar.classList.contains('active')) {
                    barsIcon.style.display = 'none';
                    timesIcon.style.display = 'flex';
                } else {
                    barsIcon.style.display = 'flex';
                    timesIcon.style.display = 'none';
                }
            });

            // Close menu when clicking a menu item
            const menuLinks = userSidebar.querySelectorAll('.user-sidebar-menu a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    userSidebar.classList.remove('active');
                    hamburgerBtn.classList.remove('active');
                    barsIcon.style.display = 'flex';
                    timesIcon.style.display = 'none';
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && !event.target.closest('.user-sidebar') && !event.target.closest('.user-hamburger')) {
                    userSidebar.classList.remove('active');
                    hamburgerBtn.classList.remove('active');
                    barsIcon.style.display = 'flex';
                    timesIcon.style.display = 'none';
                }
            });

            // Handle window resize
            window.addEventListener('resize', updateMobileView);
        });
    </script>
</body>
</html>
