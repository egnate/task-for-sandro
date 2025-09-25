@props([
    'type' => 'button',
    'size' => 'default',
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
    'href' => null,
])

@php
    $sizeClasses = match($size) {
        'small' => 'px-4 py-2 text-sm',
        default => 'px-6 py-3.5 text-base',
    };

    $widthClass = $fullWidth ? 'w-full' : '';

    $baseClasses = "
        inline-flex items-center justify-center
        font-semibold rounded-xl uppercase tracking-wide
        bg-gradient-to-r from-primary to-primary-hover
        text-white
        transition-all duration-200 ease-in-out
        transform active:scale-95
        shadow-lg shadow-primary/25
        hover:from-primary-hover hover:to-primary-dark
        hover:shadow-primary/40
        focus:outline-none focus:ring-4 focus:ring-primary/20
        cursor-pointer
        disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
        {$sizeClasses} {$widthClass}
    ";
@endphp

@if($href)
    <a
        href="{{ $href }}"
        wire:navigate
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif

        {{ $slot }}
    </button>
@endif