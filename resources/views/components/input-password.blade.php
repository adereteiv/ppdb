@props(['name' => '', 'value' => ''])

<div x-data="{ show: false }" class="position-relative">
    <input
    :type="show ? 'text' : 'password'"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->merge(['class' => 'form-item padding-10']) }}
    />

    <button
    @click="show = !show"
    type="button"
    class="tombol-none position-absolute top-0 right-0 bottom-0 padding-side-10"
    tabindex="-1"
    >
        <i x-show="!show" x-cloak class="bi bi-eye"></i>
        <i x-show="show" x-cloak class="bi bi-eye-slash"></i>
    </button>
</div>

@error($name)
<p class="flex flex-start teks-negatif">{{ $message }}</p>
@enderror
