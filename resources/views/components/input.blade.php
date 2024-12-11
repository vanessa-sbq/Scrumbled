<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-muted-foreground">{{ $label }}</label>

    @if ($type === 'text')
        <input id="{{ $name }}" type="text" name="{{ $name }}" value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}" @if ($required) required @endif
            @if ($autofocus) autofocus @endif
            class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
            @if ($required) required @endif @if ($autofocus) autofocus @endif
            class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
            @if ($autofocus) autofocus @endif
            class="mt-1 block w-full px-3 py-2 border border-muted rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}</option>
            @endforeach
        </select>
    @endif

    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
