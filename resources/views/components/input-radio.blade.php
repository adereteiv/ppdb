@props(['name', 'options', 'value' => ''])

@foreach ($options as $option)
    <label>
        <input type="radio" name="{{ $name }}" {{ $attributes->merge(['class'=>'form-item',]) }} value="{{ $option }}" {{ old($name, $value) === $option ? 'checked' : '' }}/>
        {{ $option }}
    </label>&nbsp;
@endforeach

@error($name)
<br><p style="color: red">{{ $message }}</p>
@enderror

{{--
<x-input-radio name="jenis_kelamin" :options="config('form-options.jenis-kelamin')" :value="$infoAnak->jenis_kelamin ?? '' " required/>
 --}}
