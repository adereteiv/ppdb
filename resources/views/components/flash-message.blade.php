@props(['flash'])

@php
    $bgFlash = match($flash){
        default => 'bg-red',
        'green' => 'bg-greendark',
        'blue' => 'bg-blue',
    };
    $bgButton = match($flash){
        default => 'tombol-negatif',
        'green' => 'tombol-positif',
        'blue' => 'tombol-netral',
    };
@endphp

<div class="form-login_item {{ $bgFlash }} teks-putih flex justify-between reminder margin-vertical" x-data="{ show: true }" x-show="show" >
    <div class="flex-1 align-self-center">
        {{ $slot }}
    </div>
    <div><button class="tombol {{ $bgButton }}" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
</div>

{{--
<x-flash-message flash="red">{{ $slot }}</x-flash-message>
--}}
