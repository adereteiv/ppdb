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
