<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ACCO | Inquiry Management Portal</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="@modernAsset('css/modern_custom.css')?v={{ time() }}">
    <link rel="icon" type="image/png" href="@modernAsset('assets/img/Favicon.png')">
    
    @stack('styles')
</head>
<body>
    <!-- Theme pre-load protection to prevent white flash in dark mode -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-theme');
            }
        })();
    </script>

    <div class="app-container">
        <!-- Desktop Sidebar -->
        <aside class="desktop-sidebar">
            <a href="/" class="sidebar-brand">
                <img src="@modernAsset('assets/img/accoLogo.png')" class="logo-dark-theme-hide" alt="ACCO Logo">
                <img src="@modernAsset('assets/img/Logo.png')" class="logo-light-theme-hide" alt="ACCO Logo">
            </a>
            
            <ul class="sidebar-menu">
                <li class="sidebar-header">Core Actions</li>
                <li>
                    <a href="/" class="menu-item {{ Request::is('/') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                @php
                    $inquiriesSectionActive = Request::is('inquiries') || Request::is('inquiry-by-type/*') || Request::is('inquiries-by-status*');
                @endphp
                <li>
                    <div class="menu-item-row">
                        <a href="/inquiries" class="menu-item flex-grow-1 {{ $inquiriesSectionActive ? 'active' : '' }}">
                            <i class="bi bi-folder2-open"></i> Inquiries
                        </a>
                        @if(isset($sidebarProjectTypes) && count($sidebarProjectTypes) > 0)
                            <button type="button" class="submenu-toggle {{ $inquiriesSectionActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#inquiriesSubmenu" aria-expanded="{{ $inquiriesSectionActive ? 'true' : 'false' }}" aria-controls="inquiriesSubmenu" aria-label="Toggle inquiry categories">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        @endif
                    </div>
                    @if(isset($sidebarProjectTypes) && count($sidebarProjectTypes) > 0)
                        <ul class="menu-submenu collapse {{ $inquiriesSectionActive ? 'show' : '' }}" id="inquiriesSubmenu">
                            @foreach ($sidebarProjectTypes as $type)
                                <li>
                                    <a href="{{ url('/inquiry-by-type', $type->id) }}" class="submenu-item {{ Request::is('inquiry-by-type/' . $type->id) ? 'active' : '' }}">
                                        {{ $type->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                
                <li class="sidebar-header">Filters</li>
                <li>
                    <a href="/today-followups" class="menu-item {{ Request::is('today-followups') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> Today's Followups
                    </a>
                </li>
                <li>
                    <a href="/most-important" class="menu-item {{ Request::is('most-important') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i> Most Important
                    </a>
                </li>
                
                <li class="sidebar-header">Management</li>
                <li>
                    <a href="/project-type" class="menu-item {{ Request::is('project-type') || Request::is('add-project-type') || Request::is('update-project-type/*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Project Categories
                    </a>
                </li>
                
                <li class="sidebar-header">Quick Creation</li>
                <li>
                    <a href="/add-inquiry" class="menu-item {{ Request::is('add-inquiry') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i> Add Inquiry
                    </a>
                </li>
                <li>
                    <a href="/add-project-type" class="menu-item {{ Request::is('add-project-type') ? 'active' : '' }}">
                        <i class="bi bi-folder-plus"></i> Add Category
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="modern-btn btn-danger-modern w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="app-content-wrapper">
            <!-- Navbar -->
            <nav class="app-navbar">
                <div class="d-flex align-items-center gap-3">
                    <h4 class="mb-0 display-font d-none d-md-block" style="font-weight: 700; letter-spacing: -0.02em;">Ahmed Construction Company</h4>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Global Search -->
                    <form class="d-none d-md-flex align-items-center gap-2" method="GET" action="{{ url('/inquiries') }}">
                        <input class="modern-input py-1 px-3" type="search" name="search" placeholder="Search inquiries..." value="{{ request('search') }}" style="max-width: 220px;">
                        <button class="modern-btn btn-primary-modern py-1 px-3" type="submit" style="padding: 10px 15px !important;"><i class="bi bi-search"></i></button>
                    </form>

                    <!-- Theme Switcher -->
                    <button class="theme-switch-btn" id="theme-toggle-btn" title="Toggle Theme">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                    
                    <!-- User Section -->
                    <div class="navbar-user-section dropdown">
                        <button class="navbar-user-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="@modernAsset('assets/img/160x160.png')" class="navbar-user-avatar" alt="Avatar">
                            <span class="fw-semibold d-none d-sm-inline">Mohammad Emraan</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="background-color: var(--bg-surface-solid); border-radius: var(--border-radius-md);">
                            <li><span class="dropdown-item-text text-muted" style="font-size:0.8rem;">Signed in as Web Developer</span></li>
                            <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2" style="background: none; border: none; width: 100%; text-align: left;">
                                        <i class="bi bi-box-arrow-right"></i> Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="page-container">
                @yield('content')
            </div>
        </div>
        
        <!-- Mobile Bottom Navigation Bar -->
        <nav class="mobile-nav-bar">
            <a href="/" class="mobile-nav-item {{ Request::is('/') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Home</span>
            </a>
            <a href="/inquiries" class="mobile-nav-item {{ Request::is('inquiries') || Request::is('inquiry-by-type/*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i>
                <span>Inquiries</span>
            </a>
            <a href="/today-followups" class="mobile-nav-item {{ Request::is('today-followups') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Today</span>
            </a>
            <a href="/most-important" class="mobile-nav-item {{ Request::is('most-important') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Important</span>
            </a>
        </nav>
        
        <!-- Mobile FAB (Floating Action Button) for adding inquiry -->
        <a href="/add-inquiry" class="mobile-fab" title="Add Inquiry">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <!-- Local Storage Theme Manager Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const htmlElement = document.documentElement;
            
            // Sync initial state
            if (htmlElement.classList.contains('dark-theme')) {
                themeToggleBtn.innerHTML = '<i class="bi bi-sun"></i>';
            } else {
                themeToggleBtn.innerHTML = '<i class="bi bi-moon-stars"></i>';
            }
            
            themeToggleBtn.addEventListener('click', () => {
                if (htmlElement.classList.contains('dark-theme')) {
                    htmlElement.classList.remove('dark-theme');
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.innerHTML = '<i class="bi bi-moon-stars"></i>';
                } else {
                    htmlElement.classList.add('dark-theme');
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.innerHTML = '<i class="bi bi-sun"></i>';
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
