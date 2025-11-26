<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hive Workshop')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .main-content {
            min-height: calc(100vh - 200px);
        }
        
        /* Dark Mode Styles */
        .dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        
        .dark-mode .bg-white {
            background-color: #2d3748 !important;
        }
        
        .dark-mode .card {
            background-color: #2d3748;
            border-color: #4a5568;
        }
        
        .dark-mode .card-header {
            background-color: #2d3748 !important;
            border-bottom-color: #4a5568;
        }
        
        .dark-mode .card-footer {
            background-color: #2d3748 !important;
            border-top-color: #4a5568;
        }
        
        .dark-mode .text-dark {
            color: #e2e8f0 !important;
        }
        
        .dark-mode .text-muted {
            color: #a0aec0 !important;
        }
        
        .dark-mode .text-secondary {
            color: #a0aec0 !important;
        }
        
        .dark-mode .form-control {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        
        .dark-mode .form-control:focus {
            background-color: #2d3748;
            border-color: #63b3ed;
            color: #e2e8f0;
        }
        
        .dark-mode .btn-outline-secondary {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        
        .dark-mode .btn-outline-secondary:hover {
            background-color: #4a5568;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        
        .dark-mode .alert-warning {
            background-color: #744210;
            border-color: #744210;
            color: #faf089;
        }
        
        .dark-mode .border {
            border-color: #4a5568 !important;
        }
        
        .dark-mode .breadcrumb {
            background-color: #2d3748;
        }
        
        .dark-mode .breadcrumb-item.active {
            color: #a0aec0;
        }
        
        .dark-mode .breadcrumb-item a {
            color: #63b3ed;
        }
        
        .dark-mode .btn-outline-primary {
            border-color: #63b3ed;
            color: #63b3ed;
        }
        
        .dark-mode .btn-outline-primary:hover {
            background-color: #63b3ed;
            color: #1a202c;
        }
        
        .dark-mode .bg-light {
            background-color: #2d3748 !important;
        }
        
        .dark-mode .bg-primary {
            background-color: #2c5282 !important;
        }
        
        /* Smooth transition */
        body, .card, .form-control, .btn, .alert {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
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
                    <!-- Dark Mode Toggle -->
                    <button class="btn btn-outline-light btn-sm me-2" id="darkModeToggle">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                    
                    <!-- Auth Links -->
                    @auth
                        <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                        <a href="#" class="btn btn-warning btn-sm me-2">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container text-center">
            <div class="mb-3">
                <a href="#" class="text-light me-3"><i class="fab fa-discord fa-lg"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-github fa-lg"></i></a>
                <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
            </div>
            <p class="mb-0">&copy; 2024 Hive Workshop Community. All rights reserved.</p>
            <small class="text-muted">Powered by Laravel & Bootstrap</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Dark Mode Functionality
        function initializeDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const body = document.body;
            
            // Check for saved theme preference or system preference
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                enableDarkMode();
            }
            
            // Toggle dark mode
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
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    if (e.matches) {
                        enableDarkMode();
                    } else {
                        disableDarkMode();
                    }
                }
            });
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', initializeDarkMode);
    </script>
</body>
</html>