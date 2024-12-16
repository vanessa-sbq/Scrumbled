<!-- resources/views/components/button.blade.php -->

@php
    $baseClasses = 'inline-flex items-center justify-center rounded-md transition-colors';
    $variantClasses = [
        'primary' => 'bg-primary text-white hover:bg-primary/90',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ][$variant];
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-2 text-base',
        'lg' => 'px-8 py-3 text-lg',
    ][$size];
@endphp

<a href="{{ $href }}" class="{{ $baseClasses }} {{ $variantClasses }} {{ $sizeClasses }} {{ $class }}">
    {{ $slot }}
</a>
