@props([
    'checkboxName', 'checkboxId', 'checkboxValue',
    'label',
    'keteranganName', 'keteranganId', 'keterangan',
    'wajibName', 'wajibId', 'wajibChecked' => true,
    ])

<div class="checkmenu">
    <input id="{{ $checkboxId }}" type="checkbox" name="{{ $checkboxName }}" value="{{ $checkboxValue }}">
    <div>
        <x-inputbox for="{{ $checkboxId }}">
            <x-slot:label><b class="number">{{ $label }}</b></x-slot>
            <p>Keterangan :</p>
            <textarea id="{{ $keteranganId }}" name="{{ $keteranganName }}">{{ $keterangan }}</textarea>
        </x-inputbox>
        <div>
            <input id="{{ $wajibId }}" type="checkbox" name="{{ $wajibName }}" value="1" {{ $wajibChecked ? 'checked' : ''}}>
            <label for="{{ $wajibId }}"> Wajibkan</label>
        </div>
    </div>
</div>

{{--
<div class="checkmenu">
    <input id="checkbox_{{ $name }}" type="checkbox" name="include[{{ $name }}]" value="{{ $tipe->id }}">
    <div>
        <x-inputbox for="keterangan_{{ $name }}">
            <x-slot:label><h6 class="number">{{ $num }}. {{ $label }}</h6></x-slot>
            <p>Keterangan :</p>
            <textarea id="keterangan_{{ $name }}" name="keterangan[{{ $name }}]">{{ $syarat ? $syarat->keterangan : '' }}</textarea>
        </x-inputbox>
        <div>
            <input id="wajib_{{ $name }}" type="checkbox" name="is_wajib[{{ $name }}]" value="1" {{ $syarat && $syarat->is_wajib ? 'checked' : '' }}>
            <label for="wajib_{{ $name }}"> Wajibkan</label>
        </div>
    </div>
</div>
--}}
