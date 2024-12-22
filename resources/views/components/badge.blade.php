@props(['type', 'value'])

@php
    $bgColor = 'bg-gray-100';
    $textColor = 'text-gray-800';

    switch ($type) {
        case 'effort':
            $bgColor = 'bg-blue-100';
            $textColor = 'text-blue-800';
            break;
        case 'value':
            $bgColor = 'bg-green-100';
            $textColor = 'text-green-800';
            break;
        case 'status':
            $bgColor = 'bg-yellow-100';
            $textColor = 'text-yellow-800';
            break;
        case 'public':
            $bgColor = 'bg-green-100';
            $textColor = 'text-green-800';
            break;
        case 'private':
            $bgColor = 'bg-red-100';
            $textColor = 'text-red-800';
            break;
    }
@endphp

<span
    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $bgColor }} {{ $textColor }}">
    {{ $value }}
</span>
