<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema de Nómina') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="main-header">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="header-left">
            <img src="/assets/images/isologo.png" alt="Logo Alianza">
        </div>

        <div class="user-info">
            <div class="user-dropdown">
                <div class="user-avatar" id="userDropdownToggle" style="cursor: pointer;">
                    <img src="/assets/images/women.png" alt="Usuario">
                </div>
                <div class="dropdown-menu" id="userDropdownMenu">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item logout w-100 text-start border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
            <div class="user-details">
                <p class="user-name">{{ Auth::user()->name ?? 'Usuario' }}</p>
                <p class="user-role">Administrador</p>
            </div>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div class="dashboard-container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-toggle">
                <button id="sidebarToggle">
                    <img src="/assets/images/nav.png" alt="Toggle Menu">
                </button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-submenu" href="#" id="listasMenu">
                        <i class="fas fa-list"></i>
                        <span>Listas</span>
                    </a>
                    <div class="submenu" id="listasSubmenu">
                        <a class="submenu-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                            href="{{ route('employees.index') }}">
                            <i class="fas fa-users mobile-only-icon"></i>
                            Empleados
                        </a>
                        <a class="submenu-link {{ request()->routeIs('charges.*') ? 'active' : '' }}"
                            href="{{ route('charges.index') }}">
                            <i class="fas fa-briefcase mobile-only-icon"></i>
                            Cargos
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-content" id="mainContent">
            <main class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        document.getElementById('listasMenu').addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = document.getElementById('listasSubmenu');
            const menu = document.getElementById('listasMenu');

            submenu.classList.toggle('open');
            menu.classList.toggle('open');
        });

        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        });

        document.getElementById('mobileOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });

        document.getElementById('userDropdownToggle').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('userDropdownMenu');
            dropdown.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdownMenu');
            const toggle = document.getElementById('userDropdownToggle');

            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const submenuLinks = document.querySelectorAll('.submenu-link');
            submenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        document.getElementById('sidebar').classList.remove('mobile-open');
                        document.getElementById('mobileOverlay').classList.remove('active');
                    }
                });
            });
        });

        function highlightActiveRoute() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link, .submenu-link');

            navLinks.forEach(link => {
                link.classList.remove('active');
                const linkHref = link.getAttribute('href');

                if (linkHref === currentPath) {
                    link.classList.add('active');
                }

                if (linkHref && currentPath.startsWith(linkHref) && linkHref !== '/') {
                    link.classList.add('active');
                }
            });

            if (currentPath === '/' || currentPath === '/home') {
                const homeLink = document.querySelector('a[href="{{ route('home') }}"]');
                if (homeLink) {
                    homeLink.classList.add('active');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            highlightActiveRoute();
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar').classList.remove('mobile-open');
                document.getElementById('mobileOverlay').classList.remove('active');
            }
        });
    </script>

    @stack('styles')
    @stack('scripts')
</body>

</html>
