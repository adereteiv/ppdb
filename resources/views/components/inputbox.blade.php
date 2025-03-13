<div {{ $attributes->merge(['class'=>"inputbox"]) }}>
    <label for="{{ $for }}">
        {{ $label }}
    </label>
    {{ $slot }}
</div>

{{-- <x-inputbox label="Label">
    <x-slot:id>
        The field's id
    </x-slot>
    <x-slot:label>
        The field's label
    </x-slot>
    <textarea class="form-item" type="text" id="gelombang" required></textarea>
</x-inputbox> --}}
