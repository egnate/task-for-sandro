@props([
    'type' => 'button',
    'size' => 'default', // 'small', 'default', 'large'
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left', // 'left' or 'right'
    'variant' => 'solid', // 'solid' or 'outline'
])

@php
    $sizeClasses = match($size) {
        'small' => 'px-3.5 py-2 text-sm',
        'large' => 'px-8 py-4 text-lg',
        default => 'px-6 py-2.5 text-base',
    };

    $widthClass = $fullWidth ? 'w-full' : '';

    $variantClasses = match($variant) {
        'outline' => '
            bg-white
            text-red-600
            border border-red-300
            hover:bg-red-50 hover:border-red-400
            focus:ring-red-100
        ',
        default => '
            bg-red-600
            text-white
            shadow-sm
            hover:bg-red-700 hover:shadow-md
            focus:ring-red-100
        ',
    };

    $baseClasses = "
        inline-flex items-center justify-center gap-2
        font-medium rounded-xl
        transition-all duration-200
        transform active:scale-[0.98]
        focus:outline-none focus:ring-4
        disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
        {$variantClasses}
        {$sizeClasses} {$widthClass}
    ";
@endphp

@if($href)
    <a
        href="{{ $href }}"
        wire:navigate
        {{ $attributes->class([$baseClasses, 'cursor-pointer' => !$disabled]) }}
        @if($disabled) aria-disabled="true" onclick="return false;" @endif
    >
        @if($loading)
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            {!! $icon !!}
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right' && !$loading)
            {!! $icon !!}
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class([$baseClasses]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            {!! $icon !!}
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right' && !$loading)
            {!! $icon !!}
        @endif
    </button>
@endif