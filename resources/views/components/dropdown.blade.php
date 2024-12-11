<!-- resources/views/components/user-dropdown.blade.php -->

<div class="relative inline-block text-left">
    <div id="trigger"
        class="flex flex-wrap items-center justify-center gap-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md transition"
        aria-expanded="true" aria-haspopup="true">
        {{ $slot }}
    </div>

    <!-- Dropdown menu -->
    <div id="dropdown"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none transform transition ease-in duration-75 opacity-0 scale-95 hidden"
        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        @foreach ($links as $link)
            <a href="{{ $link['url'] }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem"
                tabindex="-1">{{ $link['label'] }}</a>
        @endforeach
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endpush
