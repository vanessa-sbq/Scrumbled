<!-- resources/views/components/dropdown.blade.php -->

<div class="relative inline-block text-left">
    <div id="dropdown-trigger">
        {{ $trigger }}
    </div>

    <div id="dropdown-menu"
        class="dropdown-menu py-2 rounded-xl shadow-lg border border-muted bg-white absolute right-0 top-full w-72 space-y-2 hidden opacity-0 scale-95 transition-all duration-200"
        aria-labelledby="dropdown-trigger">
        {{ $slot }}
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/dropdown.js') }}"></script>
@endpush
