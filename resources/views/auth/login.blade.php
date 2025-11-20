<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-8">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">H</span>
            </div>
            <span class="font-bold text-gray-900 dark:text-white text-2xl">Hive Workshop</span>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">
                Welcome Back
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                Sign in to your account
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email or Username
                    </label>
                    <input id="email" 
                           class="input-primary" 
                           type="text" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="Enter your email or username">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password
                    </label>
                    <input id="password" 
                           class="input-primary" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Enter your password">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="block mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-hive-600 shadow-sm focus:ring-hive-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mb-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-hive-600 dark:text-hive-400 hover:text-hive-500 dark:hover:text-hive-300 underline" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif

                    <a class="text-sm text-hive-600 dark:text-hive-400 hover:text-hive-500 dark:hover:text-hive-300 underline" href="{{ route('register') }}">
                        Create account
                    </a>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Sign In
                </button>
            </form>

            <!-- Demo Info -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Demo Accounts:</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <div>Admin: admin@hiveworkshop.test / password</div>
                    <div>User: user1@hiveworkshop.test / password</div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>