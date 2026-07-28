<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ACCO Inquiries Portal - Sign In</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="@modernAsset('css/modern_custom.css')?v={{ time() }}">
    <link rel="icon" type="image/png" href="@modernAsset('assets/img/Favicon.png')">
    
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bg-primary) 0%, rgba(var(--accent-rgb), 0.05) 100%);
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }
        
        .login-card {
            padding: 40px 32px;
            border-radius: var(--border-radius-lg);
            background: var(--bg-surface);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }
        
        .theme-toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
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

    <!-- Theme Switcher -->
    <div class="theme-toggle-container">
        <button class="theme-switch-btn" id="theme-toggle-btn" title="Toggle Theme">
            <i class="bi bi-moon-stars"></i>
        </button>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="@modernAsset('assets/img/accoLogo.png')" class="logo-dark-theme-hide mx-auto mb-3" alt="ACCO Logo" style="max-height: 55px; width: auto; object-fit: contain;">
                <img src="@modernAsset('assets/img/Logo.png')" class="logo-light-theme-hide mx-auto mb-3" alt="ACCO Logo" style="max-height: 55px; width: auto; object-fit: contain;">
                <h3 class="display-font mb-1" style="font-weight: 800; letter-spacing: -0.03em; color: var(--accent-color);">ACCO Portal</h3>
                <p class="text-secondary" style="font-size: 0.95rem;">Enter credentials to access inquiries</p>
            </div>
            
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                
                <div class="form-group-custom">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" id="email" name="email" class="modern-input" placeholder="name@company.com" required autofocus>
                </div>
                
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">Password</label>
                    <input type="password" id="password" name="password" class="modern-input" placeholder="••••••••" required>
                </div>
                
                @if($errors->any())
                    <div class="alert alert-danger border-0 p-3 mt-3 d-flex align-items-center gap-2" style="font-size: 0.9rem; border-radius: var(--border-radius-sm); background-color: rgba(239,68,68,0.1); color: var(--danger-color);">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                
                <div class="mt-4">
                    <button type="submit" class="modern-btn btn-primary-modern w-100 py-3">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
</body>
</html>
