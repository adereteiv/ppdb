@props(['flash' => false, 'alert' => false, 'icon' => false])

@php
    $bgFlash = match($flash){
        default => $flash ? 'must' : '',
        'blue' => 'mid',
        'green' => 'mild',
    };
    $bgAlert = match($alert){
        default => $alert ? 'alert must' : '',
        'blue' => 'alert mid',
        'green' => 'alert mild',
    };
    // $bgButton = match($flash){
    //     default => 'tombol-negatif',
    //     'blue' => 'tombol-netral',
    //     'green' => 'tombol-positif',
    // };
@endphp

<div {{ $attributes -> merge(['class' => "reminder $bgFlash $bgAlert form-login_item flex teks-putih justify-between margin-vertical"])}} x-data="{ show: true }" x-show="show" >
    <div class="flex-1 flex">
        @if ($icon)
            <span class="reminder-icon">
                {{ $icon }}
            </span>
        @endif
        <span>{{ $slot }}</span>
    </div>
    <div><button class="tombol-none" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
    {{-- <div class="flex-1 align-self-center">{{ $slot }}</div> --}}
    {{-- <div><button class="tombol-none" @click="show = false"><i class="bi bi-x-lg"></i></button></div> --}}
    {{-- <div><button class="tombol {{ $bgButton }}" @click="show = false"><i class="bi bi-x-lg"></i></button></div> --}}
</div>
{{--
<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            let alert = document.querySelector(".alert"); //append style class="alert"
            if (alert) {
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 2000); // fade-out dulu 500ms baru remove
            }
        }, 10000); // Auto-dismiss after 3000ms
    });
</script> --}}

{{--
<x-flash-message flash>{{ $slot }}</x-flash-message> closable reminder
<x-flash-message alert>{{ $slot }}</x-flash-message> stabilo alert
<x-flash-message alert flash>{{ $slot }}</x-flash-message> reminder style alert, specify only the flash
<x-flash-message class="alert" flash>{{ $slot }}</x-flash-message> reminder style alert, sama aja, lebih rapi yang diatas

<x-slot:icon>
    <i class="bi bi-info-circle"></i>
    <i class="bi bi-exclamation-circle"></i>
    <i class="bi bi-check-lg"></i>
</x-slot:icon>

/* Paket 10.000 */
<div class="reminder mild flex flex-nowrap">
    <span class="reminder-icon">
        <i class="bi bi-info-circle"></i>
    </span>
    <span>
        <b>Ketentuan!</b>
        <br>
        Isi data secara lengkap dan jelas sesuai dengan data yang tertera di Kartu Keluarga/Akta Kelahiran
    </span>
</div>
https://www.itsolutionstuff.com/post/laravel-8-flash-message-tutorial-exampleexample.html
--}}
