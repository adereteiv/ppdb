@props(['flash' => false, 'alert' => false, 'button' => false, 'mode' => false, 'icon' => false])

@php
    $bgFlash = match($flash) {
        default => $flash ? 'must bg-redpowder' : '',
        'yellow' => 'warn bg-yellowpowder',
        'blue' => 'mid bg-bluepowder',
        'green' => 'mild bg-greensoft',
    };

    $bgAlert = match($alert) {
        default => $alert ? 'alert' : '', // sehingga, bila cuma alert, tanpa styling .flash, tambahkan bg secara manual
        'red' => 'alert bg-red',
        'yellow' => 'alert bg-yellow',
        'blue' => 'alert bg-blue',
        'green' => 'alert bg-green',
    };

    $icon = match($icon) {
        default => $icon ? '<i class="bi bi-info-circle"></i>' : '',
        'warn' => '<i class="bi bi-exclamation-circle"></i>',
        'success' => '<i class="bi bi-check2-circle"></i>',
        'error' => '<i class="bi bi-x-circle"></i>'
    };

    if ($mode) {
        [$bgFlash, $bgAlert, $icon] = match($mode) {
            default => ['must bg-redpowder', 'alert', '<i class="bi bi-info-circle"></i>'],
            'flash success' => ['mild bg-greensoft', '', '<i class="bi bi-check2-circle"></i>'],
            'flash warn' => ['warn bg-yellowpowder', '', '<i class="bi bi-exclamation-circle"></i>'],
            'flash error' => ['must bg-redpowder', '', '<i class="bi bi-x-circle"></i>'],
            'alert success' => ['', 'alert bg-green', '<i class="bi bi-check2-circle"></i>'],
            // 'alert warn' => ['', 'alert bg-yellow', '<i class="bi bi-exclamation-circle"></i>'],
            'alert warn' => ['warn bg-yellowpowder', 'alert', '<i class="bi bi-exclamation-circle"></i>'],
            'alert error' => ['', 'alert bg-red', '<i class="bi bi-x-circle"></i>'],
        };
    }
@endphp


<div {{ $attributes -> merge(['class' => "reminder $bgFlash $bgAlert flex flex-nowrap teks-putih justify-between margin-vertical"])}} x-data="{ show: true }" x-show="show" >
    <div class="flex-1 flex flex-nowrap">
        @isset($mode)
            <span class="reminder-icon">
                {!! $icon !!}
            </span>
        {{-- @elseif (isset($icon))
            <span class="reminder-icon">
                <i class="bi bi-info-circle"></i>
            </span> --}}
        @endisset
        <span>{{ $slot }}</span>
    </div>
    @if ($alert || $button || $mode)
        <div><button class="tombol-none" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
    @endif
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
<x-flash-message flash>{{ $slot }}</x-flash-message> simple reminder
<x-flash-message alert="$alert">{{ $slot }}</x-flash-message> stabilo alert, if alert only then it's just blank
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

-----
@props(['header' => null, 'message' => null, 'icon' => null, 'mode' => 'mild'])

@php
    $class = [
        'mild' => 'mild bg-greensoft',
        'mid' => 'mid bg-bluepowder',
        'warn' => 'warn bg-yellowpowder',
        'must' => 'must bg-redpowder',
    ];
    $mode = $mode ?? 'mild';
@endphp

<div class="reminder {{ $class[$mode] }} flex flex-nowrap">
    <span class="reminder-icon">
        {!! $icon ?? '<i class="bi bi-info-circle"></i>' !!}
    </span>
    <span>
        {{ $header }}
        <br>
        {{ $message }}
    </span>
</div>

https://www.itsolutionstuff.com/post/laravel-8-flash-message-tutorial-exampleexample.html
--}}
