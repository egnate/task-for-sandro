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
<body class="bg-white antialiased">
    <div class="min-h-screen">
        <!-- Modern Navigation -->
        <nav class="bg-white/95 backdrop-blur-xl border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="/" wire:navigate class="flex items-center group">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center group-hover:from-emerald-100 group-hover:to-emerald-200 transition-all duration-300">
                                    <img src="{{ asset('img/main/icon.svg') }}" alt="Logo" class="w-7 h-7">
                                </div>
                            </a>
                        </div>

                        <!-- Navigation Pills -->
                        <div class="hidden sm:ml-12 sm:flex sm:items-center">
                            <div class="flex bg-gray-50/80 rounded-2xl p-1.5 backdrop-blur-sm">
                                <a href="{{ route('notes.index') }}" wire:navigate
                                   class="flex items-center px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('notes.index') ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    My Notes
                                </a>
                                <a href="{{ route('notes.create') }}" wire:navigate
                                   class="flex items-center px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('notes.create') ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-3 px-3 py-2 rounded-2xl hover:bg-gray-50 transition-all duration-300 border border-gray-200/50 bg-white/80 backdrop-blur-sm">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200 border border-emerald-200 flex items-center justify-center">
                                    <span class="text-sm font-semibold text-emerald-700">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                                 style="display: none;">

                                <!-- User Info Header -->
                                <div class="px-6 py-5 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200 border border-emerald-200 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-emerald-700">
                                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu items -->
                                <div class="py-2">
                                    <!-- Settings -->
                                    <button @click="$dispatch('open-modal', {type: 'settings', title: 'Account Settings', data: {}, size: 'default'}); open = false"
                                            class="w-full text-left px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 flex items-center group">
                                        <div class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-gray-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <span>Settings</span>
                                    </button>

                                    <!-- API Tokens -->
                                    <a href="{{ route('api-tokens') }}" wire:navigate
                                       class="w-full text-left px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 flex items-center group"
                                       @click="open = false">
                                        <div class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-gray-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd">
                                                <path d="M16 1c-4.418 0-8 3.582-8 8 0 .585.063 1.155.182 1.704l-8.182 7.296v5h6v-2h2v-2h2l3.066-2.556c.909.359 1.898.556 2.934.556 4.418 0 8-3.582 8-8s-3.582-8-8-8zm-6.362 17l3.244-2.703c.417.164 1.513.703 3.118.703 3.859 0 7-3.14 7-7s-3.141-7-7-7c-3.86 0-7 3.14-7 7 0 .853.139 1.398.283 2.062l-8.283 7.386v3.552h4v-2h2v-2h2.638zm.168-4l-.667-.745-7.139 6.402v1.343l7.806-7zm10.194-7c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zm-1 0c0-.552-.448-1-1-1s-1 .448-1 1 .448 1 1 1 1-.448 1-1z"/>
                                            </svg>
                                        </div>
                                        <span>API Tokens</span>
                                    </a>
                                </div>

                                <!-- Logout -->
                                <div class="border-t border-gray-100 py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 flex items-center group">
                                            <div class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-gray-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            <span>Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 animate__animated animate__fadeIn">
            {{ $slot }}
        </main>

    </div>

    <!-- Universal Modal (always available when authenticated) -->
    @auth
        <livewire:components.universal-modal />
    @endauth

    @livewireScripts
    @stack('scripts')
</body>
</html>