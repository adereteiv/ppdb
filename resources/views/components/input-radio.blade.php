@props(['name', 'options', 'value' => '', 'id'])

<div class="flex gap-rem">
    @foreach ($options as $i => $option)
        <label class="flex flex-center" for="{{ $id }}[{{ $i }}]">
            {{-- <input type="radio" name="{{ $name }}" {{ $attributes->merge(['class'=>'form-item',]) }} value="{{ $option }}" {{ old($name, $value) === $option ? 'checked' : '' }}/> --}}
            <input type="radio" id="{{ $id }}[{{ $i }}]" name="{{ $name }}" value="{{ $option }}" {{ old($name, $value) === $option ? 'checked' : '' }}
            @if ($i === 0 && $attributes->has('required')) required @endif
            {{ $attributes->except('required') }}/>
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
