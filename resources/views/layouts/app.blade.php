<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hive Workshop') }} - Warcraft 3 Community</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 h-full">
        <div class="min-h-full">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">H</span>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white text-xl">Hive Workshop</span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                    {{ __('Home') }}
                                </x-nav-link>
                                <x-nav-link :href="route('resources.index')" :active="request()->routeIs('resources.index')">
                                    {{ __('Resources') }}
                                </x-nav-link>
                                @auth
                                <x-nav-link :href="route('resources.upload')" :active="request()->routeIs('resources.upload')">
                                    {{ __('Upload') }}
                                </x-nav-link>
                                @endauth
                            </div>
                        </div>

                        <!-- Right Side Of Navbar -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button id="dark-mode-toggle" class="p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                                <svg id="dark-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                                <svg id="light-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </button>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                            <div>{{ Auth::user()->name ?? 'Guest' }}</div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @auth
                                            <!-- Menu untuk user yang login -->
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('resources.my')">
                                                {{ __('My Resources') }}
                                            </x-dropdown-link>
                                            
                                            @if(Auth::user()->isModerator())
                                                <x-dropdown-link :href="route('admin.dashboard')">
                                                    {{ __('Admin Panel') }}
                                                </x-dropdown-link>
                                            @endif

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        @else
                                            <!-- Menu untuk Guest -->
                                            <x-dropdown-link :href="route('login')">
                                                {{ __('Log in') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('register')">
                                                {{ __('Register') }}
                                            </x-dropdown-link>
                                        @endauth
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('resources.index')" :active="request()->routeIs('resources.index')">
                            {{ __('Resources') }}
                        </x-responsive-nav-link>
                        @auth
                        <x-responsive-nav-link :href="route('resources.upload')" :active="request()->routeIs('resources.upload')">
                            {{ __('Upload') }}
                        </x-responsive-nav-link>
                        @endauth
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        @auth
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('resources.my')">
                                    {{ __('My Resources') }}
                                </x-responsive-nav-link>
                                
                                @if(Auth::user()->isModerator())
                                    <x-responsive-nav-link :href="route('admin.dashboard')">
                                        {{ __('Admin Panel') }}
                                    </x-responsive-nav-link>
                                @endif

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        @else
                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('login')">
                                    {{ __('Log in') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('register')">
                                    {{ __('Register') }}
                                </x-responsive-nav-link>
                            </div>
                        @endauth

                        <!-- Dark Mode Toggle Mobile -->
                        <div class="mt-3 px-4">
                            <button id="dark-mode-toggle-mobile" class="flex items-center w-full text-left px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                <svg id="dark-icon-mobile" class="w-5 h-5 mr-3 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                                <svg id="light-icon-mobile" class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span id="dark-mode-text">Toggle Dark Mode</span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-16">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hive Workshop</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                The premier community for Warcraft 3 custom maps, models, and resources.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Resources</h4>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li><a href="{{ route('resources.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">All Resources</a></li>
                                <li><a href="{{ route('resources.index', ['category' => 1]) }}" class="hover:text-blue-600 dark:hover:text-blue-400">Maps</a></li>
                                <li><a href="{{ route('resources.index', ['category' => 2]) }}" class="hover:text-blue-600 dark:hover:text-blue-400">Models</a></li>
                                <li><a href="{{ route('resources.index', ['category' => 3]) }}" class="hover:text-blue-600 dark:hover:text-blue-400">Textures</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Community</h4>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Forums</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Discord</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Contribute</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Support</h4>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Help</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">FAQ</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
                        <p>&copy; {{ date('Y') }} Hive Workshop. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            // Dark Mode Toggle Functionality
            function initDarkMode() {
                const toggleBtn = document.getElementById('dark-mode-toggle');
                const toggleBtnMobile = document.getElementById('dark-mode-toggle-mobile');
                const darkIcon = document.getElementById('dark-icon');
                const lightIcon = document.getElementById('light-icon');
                const darkIconMobile = document.getElementById('dark-icon-mobile');
                const lightIconMobile = document.getElementById('light-icon-mobile');
                const darkModeText = document.getElementById('dark-mode-text');

                // Check for saved theme or prefer color scheme
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const savedTheme = localStorage.getItem('theme');
                
                // Determine initial theme
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                    updateIcons(true);
                } else {
                    document.documentElement.classList.remove('dark');
                    updateIcons(false);
                }

                // Toggle function
                function toggleDarkMode() {
                    const isDark = document.documentElement.classList.contains('dark');
                    if (isDark) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        updateIcons(false);
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        updateIcons(true);
                    }
                }

                // Update icon visibility
                function updateIcons(isDark) {
                    if (isDark) {
                        darkIcon.classList.remove('hidden');
                        lightIcon.classList.add('hidden');
                        darkIconMobile.classList.remove('hidden');
                        lightIconMobile.classList.add('hidden');
                        darkModeText.textContent = 'Switch to Light Mode';
                    } else {
                        darkIcon.classList.add('hidden');
                        lightIcon.classList.remove('hidden');
                        darkIconMobile.classList.add('hidden');
                        lightIconMobile.classList.remove('hidden');
                        darkModeText.textContent = 'Switch to Dark Mode';
                    }
                }

                // Event listeners
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', toggleDarkMode);
                }
                if (toggleBtnMobile) {
                    toggleBtnMobile.addEventListener('click', toggleDarkMode);
                }
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', initDarkMode);
        </script>
    </body>
</html>