@props(['name', 'options', 'value' => ''])

<select name="{{ $name }}" {{ $attributes->merge(['class'=>'form-item',]) }}>
    <option value="">-- Pilih --</option>

    @foreach ($options as $option)
    <option value="{{ $option }}" {{ old($name, $value) === $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
    @endforeach
</select>

@error($name)
<br><p style="color: red">{{ $message }}</p>
@enderror
{{-- <x-form.select name="agama" :options="config('form-options.agama')" :value="$infoAnak->agama ?? ''" /> --}}

{{-- Whack --}}
{{-- <select name="{{ $slot }}">
    <option value="">-- Pilih --</option>
    @foreach (config('form-options.agama') as $agama)
        <option value="{{ $agama }}" {{ old('agama', $infoAnak->agama ?? '') === $agama ? 'selected' : '' }}>
            {{ $agama }}
        </option>
    @endforeach
</select> --}}

{{-- <x-select name="agama" :options="config('form-options.agama')" :selected="old('agama', $infoAnak->agama ?? '')" /> --}}
