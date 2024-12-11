<form method="POST" action="{{ $action }}" class="max-w-lg mx-auto card">
    @csrf
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    {{ $slot }}

    <div class="flex items-center justify-between">
        <button type="submit"
            class="w-full bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
            {{ $label }}
        </button>
    </div>
</form>
</div>
</div>
