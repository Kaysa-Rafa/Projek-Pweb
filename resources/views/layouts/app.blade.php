<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hive Workshop Clone')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .bg-hive {
            background: linear-gradient(135deg, #1e3a8a 0%, #7e22ce 100%);
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navigation -->
    <nav class="bg-hive text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                    <i class="fas fa-hive mr-2"></i>
                    HiveWorkshop
                </a>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="hover:text-yellow-300 transition duration-200">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('resources.index') }}" class="hover:text-yellow-300 transition duration-200">
                        <i class="fas fa-box mr-1"></i> Resources
                    </a>
                    <a href="{{ route('categories.index') }}" class="hover:text-yellow-300 transition duration-200">
                        <i class="fas fa-folder mr-1"></i> Categories
                    </a>
                    
                    <!-- Auth Links -->
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-300">Welcome, {{ Auth::user()->name }}</span>
                            <a href="#" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded hover:bg-yellow-400 transition">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-white transition">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">
                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-400 transition">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4">
            <div class="container mx-auto">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4">
            <div class="container mx-auto">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-discord fa-lg"></i></a>
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-github fa-lg"></i></a>
                <a href="#" class="hover:text-yellow-400 transition"><i class="fab fa-twitter fa-lg"></i></a>
            </div>
            <p>&copy; 2025 HiveWorkshop. All rights reserved.</p>
            <p class="text-gray-400 text-sm mt-2">Built with Laravel & Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>