@props(['name', 'label', 'keterangan' => null, 'isWajib' => false, 'dokumen' => null, 'fileType' => 'dokumen',])

@php
$name = Str::slug($label, '_');
$nameFormat = $fileType === 'dokumen' ? "dokumen[$name]" : "$name" ;
$error = $fileType === 'dokumen' ? str_replace(['[', ']'], ['.', ''], $nameFormat) : $nameFormat; // dokumen[akta_kelahiran] → dokumen.akta_kelahiran
@endphp

<x-inputbox class="padding-10" for="{{ $name }}">
    <x-slot:label>
        <b class="flex">
            {{ $label }}
            <span class="subtext">
                @if ($dokumen)
                <font class="subtext" color="green">(✔ sudah diunggah)</font>
                @elseif ($isWajib)
                <font class="subtext" color="#FF0000">(* wajib)</font>
                @else
                <font class="subtext" color="#2962ff">(opsional)</font>
                @endif
            </span>
        </b>
        @if ($keterangan)
            <span class="subtext">{{ $keterangan }}</span>
        @endif
    </x-slot>
    <x-preview class="inputbox" :dokumen="$dokumen"/>
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $nameFormat }}"
        accept=".jpg,.jpeg,.png,.pdf"
        @if ($dokumen) @elseif ($isWajib) required @endif
    >
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
