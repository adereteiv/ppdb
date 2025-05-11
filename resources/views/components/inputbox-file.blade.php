@props(['name', 'label', 'keterangan' => null, 'isWajib' => false, 'dokumen' => null, 'fileType' => 'dokumen',])

@php
$name = Str::slug($label, '_');
$nameFormat = $fileType === 'dokumen' ? "dokumen[$name]" : ($fileType === 'lampiran' ? 'lampiran[]' : $name) ;
$error = $fileType === 'dokumen' ? str_replace(['[', ']'], ['.', ''], $nameFormat) : $nameFormat; // dokumen[akta_kelahiran] → dokumen.akta_kelahiran
@endphp

<x-inputbox class="padding-10" for="{{ $name }}">
    <x-slot:label>
        <div>
            <b>{{ $label }}</b>
            <span class="subtext">
                @if ($dokumen)
                <sup class="subtext" style="color:green;">(✔ sudah diunggah)</s>
                @elseif ($isWajib)
                <sup class="subtext" style="color:#FF0000;">(* wajib)</s>
                @else
                <sup class="subtext" style="color:#2962ff;">(opsional)</s>
                @endif
            </span>
        </div>
        @if ($keterangan)
            <span class="subtext">{{ $keterangan }}</span>
        @endif
    </x-slot>
    <x-preview class="inputbox" :dokumen="$dokumen"/>
    <input {{ $attributes->merge(['class' => 'form-item']) }}
        type="file"
        id="{{ $name }}"
        name="{{ $nameFormat }}"
        accept=".jpg,.jpeg,.png,.pdf"
        @if ($dokumen) @elseif ($isWajib) required @endif/>
</x-inputbox>

@error($error)
<p style="color: red">{{ $message }}</p>
@enderror

{{--
<x-inputbox-file
    name="akta-kelahiran"
    label="Akta Kelahiran"
    :isWajib="true"
    keterangan="Keterangan"
    :dokumen="$dokumenPersyaratan->where('tipe_dokumen_id', 3)->first()"
/>
--}}
