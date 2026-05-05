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
    </ul>
</aside>
