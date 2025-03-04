@props(['status' => 'Belum Lengkap'])

@php
    $statuses = [
        'Belum Lengkap' => 'bg-yellowdark',
        'Lengkap' => 'bg-greendark',
        'Terverifikasi' => 'bg-blue',
    ];

    $status = $status ?? 'Belum Lengkap';
@endphp

<span class="status {{ $statuses[$status]  ?? 'bg-yellowdark' }}">{{ $status }}</span>

{{--
<x-status-pendaftaran :status="$pendaftaran->status ?? null" />
 --}}
