<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/main/icon.svg') }}">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased auth-background relative bg-gray-50">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating orbs -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-emerald-100/30 to-green-100/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-green-100/30 to-emerald-100/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-emerald-100/20 to-green-100/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col items-center justify-center p-4 py-12 relative z-10">
        <div class="w-full max-w-md flex-shrink-0">
            <!-- Logo Section with modern styling -->
            <div class="text-center mb-8">
                <a href="/" wire:navigate class="inline-block group">
                    <div class="relative">
                        <!-- Logo glow effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-200/20 to-green-200/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-gray-200 hover:border-emerald-300 transition-all duration-300">
                            <img src="{{ asset('img/main/logo.svg') }}" alt="Logo" class="h-12 mx-auto">
                        </div>
                    </div>
                </a>
            </div>

            <!-- Auth Card with modern design -->
            <div class="auth-card rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-200 relative overflow-hidden bg-white">
                <!-- Card accent elements -->
                <div class="absolute -top-6 -right-6 w-12 h-12 bg-gradient-to-br from-emerald-200/20 to-green-200/20 rounded-full blur-lg"></div>
                <div class="absolute -bottom-6 -left-6 w-8 h-8 bg-gradient-to-tr from-green-200/20 to-emerald-200/20 rounded-full blur-lg"></div>

                <!-- Content -->
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

        </div>

        <!-- Footer links with modern styling -->
        <div class="w-full max-w-md text-center mt-8 space-y-4 flex-shrink-0">
            <div class="flex justify-center space-x-6 text-sm flex-wrap gap-y-2">
                <a href="#" class="text-gray-600 hover:text-emerald-600 transition-colors duration-200">
                    Privacy Policy
                </a>
                <a href="#" class="text-gray-600 hover:text-emerald-600 transition-colors duration-200">
                    Terms of Service
                </a>
                <a href="#" class="text-gray-600 hover:text-emerald-600 transition-colors duration-200">
                    Support
                </a>
            </div>
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </p>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')

</body>
</html>