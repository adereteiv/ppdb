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

<div {{ $attributes -> merge(['class' => "$bgFlash form-login_item flex teks-putih justify-between reminder margin-vertical"])}} x-data="{ show: true }" x-show="show" >
    <div class="flex-1 align-self-center">{{ $slot }}</div>
    <div><button class="tombol {{ $bgButton }}" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            let alert = document.querySelector(".alert"); //append style class="alert"
            if (alert) {
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 1500); // fade-out dulu 500ms baru remove
            }
        }, 5000); // Auto-dismiss after 3000ms
    });
</script>

{{--
<x-flash-message flash="red">{{ $slot }}</x-flash-message>
--}}

{{-- https://www.itsolutionstuff.com/post/laravel-8-flash-message-tutorial-exampleexample.html --}}
