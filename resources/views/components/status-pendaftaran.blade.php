@props(['status'])

@php
    $statuses = [
        'Belum Lengkap' => 'status bg-yellowdark',
        'Lengkap' => 'status bg-greendark',
        'Terverifikasi' => 'status bg-blue',
    ];
@endphp

<span class="status {{ $statuses[$status]  ?? '' }}">{{ $status }}</span>

{{--
<x-status-pendaftaran :status="$pendaftaran->status" />
 --}}
