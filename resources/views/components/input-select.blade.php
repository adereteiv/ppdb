@props(['name', 'options', 'value' => '', 'noDefault' => false])

<select name="{{ $name }}" {{ $attributes }}>
    @if (empty($noDefault))
    <option value="">-- Pilih --</option>
    @endif

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
