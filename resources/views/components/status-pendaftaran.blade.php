@props(['value' => 'Belum Lengkap'])

@php
    $statuses = [
        'Belum Lengkap' => 'tombol-orange',
        'Lengkap' => 'tombol-positif',
        'Terverifikasi' => 'tombol-netral',
    ];
    $value = $value ?? 'Belum Lengkap';
@endphp

<span {{ $attributes->merge(['class' => "status $statuses[$value]"]) }}>{{ $value }}</span>

{{--
<x-status-pendaftaran class="flex" :status="$pendaftaran->status ?? null" />
 --}}
