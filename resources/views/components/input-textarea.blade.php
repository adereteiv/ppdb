@props(['name', 'value' => ''])

<textarea name="{{ $name }}"
{{ $attributes->merge(['class'=>'form-item',]) }}
>{{ old($name, $value) }}</textarea>

@error($name)
<br><p style="color: red">{{ $message }}</p>
@enderror
{{--
<x-input-textarea class="form-item" name="nama_anak"></x-input-textarea>
--}}
