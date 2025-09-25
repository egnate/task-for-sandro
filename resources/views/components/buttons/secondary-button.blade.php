@props([
    'type' => 'button',
    'size' => 'default',
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
    'href' => null,
    'theme' => 'light',
    'wireNavigate' => true,
])

@php
    $sizeClasses = match($size) {
        'small' => 'px-5 py-2.5 text-sm',
        default => 'px-7 py-3.5 text-base',
    };

    $widthClass = $fullWidth ? 'w-full' : '';

    $lightThemeClasses = "
        bg-gradient-to-b from-white to-gray-50/80
        border border-gray-200/80
        text-gray-700
        shadow-sm shadow-gray-100/50
        hover:from-gray-50 hover:to-gray-100/60 hover:border-gray-300/90 hover:text-gray-900 hover:shadow-md hover:shadow-gray-200/40
        focus:ring-2 focus:ring-gray-400/30 focus:ring-offset-2 focus:ring-offset-white
        active:from-gray-100 active:to-gray-150/60 active:shadow-inner
        backdrop-blur-sm
    ";

    $darkThemeClasses = "
        bg-gradient-to-b from-white/10 to-white/5
        border border-white/20
        text-white
        shadow-sm shadow-black/10
        hover:from-white/20 hover:to-white/10 hover:border-white/40 hover:shadow-md hover:shadow-black/20
        focus:ring-2 focus:ring-white/30 focus:ring-offset-2 focus:ring-offset-transparent
        active:from-white/30 active:to-white/15 active:shadow-inner
        backdrop-blur-sm
    ";

    $themeClasses = $theme === 'dark' ? $darkThemeClasses : $lightThemeClasses;

    $baseClasses = "
        inline-flex items-center justify-center
        font-medium rounded-xl uppercase tracking-wide
        transition-all duration-300 ease-out
        transform hover:-translate-y-0.5 active:translate-y-0 active:scale-98
        focus:outline-none
        cursor-pointer
        disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none
        {$sizeClasses} {$widthClass} {$themeClasses}
    ";
@endphp

@if($href)
    <a
        href="{{ $href }}"
        wire:navigate
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif

        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif

        {{ $slot }}
    </button>
@endif