<!-- NAVBAR -->
<div class="admin-navbar">
    <div class="admin-brand">
        <button class="hamburger-admin" id="hamburgerAdmin" aria-label="Toggle menu">
            <i class="fa fa-bars"></i>
            <i class="fa fa-times"></i>
        </button>
        TARIX Admin
    </div>
    <div class="admin-user">
        <div class="user-info">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">Administrador</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fa fa-sign-out"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>

<!-- SIDEBAR -->
<aside class="admin-sidebar" id="adminSidebar">
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-home"></i>
                </div>
                <span>Dashboard</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.values.index') }}" class="{{ request()->routeIs('admin.values.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-star"></i>
                </div>
                <span>Valores</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <span>Servicios</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <span>Artículos</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <span>Mensajes</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span>Usuarios</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.companies.index') }}" class="{{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-building"></i>
                </div>
                <span>Empresas</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.classifications.settings') }}" class="{{ request()->routeIs('admin.classifications.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-cog"></i>
                </div>
                <span>Clasificaciones</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.billing') }}" class="{{ request()->routeIs('admin.billing') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-usd"></i>
                </div>
                <span>Facturación y Totales</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.inbox') }}" class="{{ request()->routeIs('admin.inbox*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-inbox"></i>
                </div>
                <span>Bandeja de Entrada</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li class="sidebar-section-label" style="padding: 18px 20px 4px 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8899a6;">
            Cotizador
        </li>

        <li>
            <a href="{{ route('cotizador.templates') }}" class="{{ request()->routeIs('cotizador.templates*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-file-text-o"></i>
                </div>
                <span>Plantillas</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li>
            <a href="{{ route('cotizador.quotes.history') }}" class="{{ request()->routeIs('cotizador.quotes.*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-paper-plane"></i>
                </div>
                <span>Cotizaciones</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li>
            <a href="{{ route('cotizador.email-accounts') }}" class="{{ request()->routeIs('cotizador.email-accounts*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-cog"></i>
                </div>
                <span>Config. Correo</span>
                <div class="menu-indicator"></div>
            </a>
        </li>

        <li>
            <a href="{{ route('cotizador.clients') }}" class="{{ request()->routeIs('cotizador.clients*') ? 'active' : '' }}">
                <div class="menu-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span>Clientes</span>
                <div class="menu-indicator"></div>
            </a>
        </li>
    </ul>
</aside>
