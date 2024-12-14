<!-- resources/views/components/dropdown-item.blade.php -->
<div class="px-2 rounded-md">
    <a href="{{ $to }}"
        {{ $attributes->merge(['class' => 'block rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors ' . $class]) }}>
        {{ $slot }}
    </a>
</div>
