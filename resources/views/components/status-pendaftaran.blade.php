@props(['status' => 'Belum Lengkap'])

@php
    $statuses = [
        'Belum Lengkap' => 'status bg-yellowdark',
        'Lengkap' => 'status bg-greendark',
        'Terverifikasi' => 'status bg-blue',
    ];

    $status = $status ?? 'Belum Lengkap';
@endphp

<span class="status {{ $statuses[$status]  ?? 'bg-yellowdark' }}">{{ $status }}</span>

{{--
<x-status-pendaftaran :status="$pendaftaran->status ?? null" />
 --}}
