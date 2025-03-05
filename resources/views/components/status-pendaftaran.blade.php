@props(['status' => 'Belum Lengkap'])

@php
    $statuses = [
        'Belum Lengkap' => 'bg-yellowdark',
        'Lengkap' => 'bg-greendark',
        'Terverifikasi' => 'bg-blue',
    ];

    $status = $status ?? 'Belum Lengkap';
@endphp

<span {{ $attributes->merge(['class' => "status $statuses[$status]"]) }}>{{ $status }}</span>

{{--
<x-status-pendaftaran class="flex" :status="$pendaftaran->status ?? null" />
 --}}
