<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hive Workshop')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .main-content {
            min-height: calc(100vh - 200px);
        }
        
        .dark-mode {
            background-color: #1a202c !important; 
            color: #f7fafc !important; 
        }

        .dark-mode .card {
            background-color: #2d3748; 
            border-color: #4a5568;
            color: #f7fafc;
        }
        
        .dark-mode .card-header {
            background-color: #2d3748 !important;
            border-bottom-color: #4a5568;
            color: #fff;
        }
        
        .dark-mode .card-footer {
            background-color: #2d3748 !important;
            border-top-color: #4a5568;
        }

        .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4, .dark-mode h5, .dark-mode h6,
        .dark-mode .h1, .dark-mode .h2, .dark-mode .h3, .dark-mode .h4, .dark-mode .h5, .dark-mode .h6 {
            color: #fff !important;
        }

        .dark-mode .text-dark, 
        .dark-mode .text-body,
        .dark-mode .text-black {
            color: #f7fafc !important;
        }

        .dark-mode .text-muted,
        .dark-mode .text-secondary {
            color: #a0aec0 !important; 
        }

        .dark-mode a:not(.btn) {
            color: #63b3ed; 
        }
        .dark-mode a:not(.btn):hover {
            color: #90cdf4;
        }

        .dark-mode .form-control, 
        .dark-mode .form-select {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #f7fafc;
        }
        
        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: #2d3748;
            border-color: #63b3ed;
            color: #fff;
        }
        
        .dark-mode .form-text, 
        .dark-mode .form-label {
            color: #e2e8f0;
        }

        .dark-mode .table {
            color: #f7fafc;
            border-color: #4a5568;
        }
        .dark-mode .table-hover tbody tr:hover {
            color: #fff;
            background-color: #4a5568;
        }

        .dark-mode .btn-outline-secondary {
            background-color: transparent;
            border-color: #a0aec0;
            color: #a0aec0;
        }
        .dark-mode .btn-outline-secondary:hover {
            background-color: #a0aec0;
            color: #1a202c;
        }
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .dark-mode .list-group-item {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #f7fafc;
        }

        .dark-mode .bg-light {
            background-color: #2d3748 !important;
        }
        .dark-mode .bg-white {
            background-color: #2d3748 !important;
        }

        body, .card, .form-control, .btn, h1, h2, h3, p, span, div {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-hive me-2"></i>Hive Workshop
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('resources.index') }}">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-light btn-sm me-2" id="darkModeToggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                    
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container text-center">
            <div class="mb-3">
                <a href="#" class="text-light me-3"><i class="fab fa-discord fa-lg"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-github fa-lg"></i></a>
                <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
            </div>
            <p class="mb-0">&copy; 2025 Hive Workshop Community. All rights reserved.</p>
            <small class="text-muted">Powered by Laravel & Bootstrap</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function initializeDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const body = document.body;
            
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                enableDarkMode();
            }
            
            // Toggle Logic
            darkModeToggle.addEventListener('click', function() {
                if (body.classList.contains('dark-mode')) {
                    disableDarkMode();
                } else {
                    enableDarkMode();
                }
            });
            
            function enableDarkMode() {
                body.classList.add('dark-mode');
                themeIcon.className = 'fas fa-sun'; 
                localStorage.setItem('theme', 'dark');
            }
            
            function disableDarkMode() {
                body.classList.remove('dark-mode');
                themeIcon.className = 'fas fa-moon'; 
                localStorage.setItem('theme', 'light');
            }
        }
        
        document.addEventListener('DOMContentLoaded', initializeDarkMode);
    </script>
</body>
</html>