@props(['value' => 'Menunggu'])

@php
    $statuses = [
        'Menunggu' => 'tombol-orange',
        'Mengisi' => 'tombol-yellowdark',
        'Lengkap' => 'tombol-positif',
        'Terverifikasi' => 'tombol-netral',
    ];
    $value = $value ?? 'Menunggu';
@endphp

<span {{ $attributes->merge(['class' => "badge round cursor-pointer $statuses[$value]"]) }}>{{ $value }}</span>

{{--
<x-status-pendaftaran class="flex" :status="$pendaftaran->status ?? null" />
 --}}
