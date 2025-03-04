@props(['name', 'label', 'keterangan' => null, 'isWajib' => false, 'dokumen' => null, 'fileType' => 'dokumen',])

@php
$name = Str::slug($label, '_');
$nameFormat = $fileType === 'bukti_bayar' ? "$name" : "dokumen[$name]" ;
$error = $fileType === 'bukti_bayar' ? $nameFormat : str_replace(['[', ']'], ['.', ''], $nameFormat); // dokumen[akta_kelahiran] → dokumen.akta_kelahiran
@endphp

<div class="inputbox">
    <label for="{{ $name }}">
        <h6 class="flex">
            {{ $label }}
            {{-- Untuk Pendaftar Unggah Dokumen --}}
            <p class="flex-1 subtext">
                @if ($dokumen)
                <font class="subtext" color="green">(sudah diunggah)</font>
                @elseif ($isWajib)
                <font class="subtext" color="#FF0000">(wajib)</font>
                @else
                (opsional)
                @endif
            </p>
        </h6>
        @if ($keterangan)
            <span class="subtext">{{ $keterangan }}</span>
        @endif
    </label>
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $nameFormat }}"
        accept=".jpg,.jpeg,.png,.pdf"
        @if($dokumen) @elseif($isWajib) required @endif
    >
</div>

@error($error)
<p style="color: red">{{ $message }}</p>
@enderror

{{--
<x-inputbox-file
    name="akta-kelahiran"
    label="Akta Kelahiran"
    :isWajib="true"
    keterangan="$syarat->keternagan"
    :dokumen="$dokumenPersyaratan->where('tipe_dokumen_id', 3)->first()"
/>
--}}
