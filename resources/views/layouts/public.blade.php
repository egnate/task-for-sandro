<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/main/icon.svg') }}">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 antialiased">
    <div class="min-h-screen">
        <!-- Modern Header -->
        <header class="bg-white/95 backdrop-blur-xl shadow-sm border-b border-gray-200/50 sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center group">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center group-hover:from-emerald-100 group-hover:to-emerald-200 transition-all duration-300">
                                <img src="{{ asset('img/main/icon.svg') }}" alt="Logo" class="w-7 h-7">
                            </div>
                        </a>
                    </div>

                    @auth
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('notes.index') }}"
                               class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                My Notes
                            </a>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-6 py-2.5 bg-white/80 hover:bg-white border border-gray-200 hover:border-gray-300 text-gray-700 hover:text-gray-900 text-sm font-medium rounded-2xl transition-all duration-200 backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8 animate__animated animate__fadeIn">
            {{ $slot }}
        </main>

        <!-- Modern Footer -->
        <footer class="bg-white/80 backdrop-blur-xl border-t border-gray-200/50 mt-20">
            <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                            <img src="{{ asset('img/main/icon.svg') }}" alt="Logo" class="w-6 h-6">
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">{{ config('app.name', 'Notes') }}</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>