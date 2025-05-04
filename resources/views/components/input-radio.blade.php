@props(['name', 'options', 'value' => ''])

<div class="flex gap-rem">
    @foreach ($options as $option)
        <label class="flex flex-center">
            {{-- <input type="radio" name="{{ $name }}" {{ $attributes->merge(['class'=>'form-item',]) }} value="{{ $option }}" {{ old($name, $value) === $option ? 'checked' : '' }}/> --}}
            <input type="radio" name="{{ $name }}" value="{{ $option }}" {{ old($name, $value) === $option ? 'checked' : '' }} {{ $attributes }}/>
            &nbsp;<span>{{ $option }}</span>
        </label>
    @endforeach
</div>

@error($name)
<br><p style="color: red">{{ $message }}</p>
@enderror

{{--
<x-input-radio name="jenis_kelamin" :options="config('form-options.jenis-kelamin')" :value="$infoAnak->jenis_kelamin ?? '' " required/>
 --}}
