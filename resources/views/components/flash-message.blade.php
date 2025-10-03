@props(['flash' => false, 'alert' => false, 'button' => false, 'mode' => false, 'icon' => false])

@php
    $bgFlash = match($flash) {
        default => $flash ? 'must bg-redpowder' : '',
        'yellow' => 'warn bg-yellowpowder',
        'blue' => 'mid bg-bluepowder',
        'green' => 'mild bg-greensoft',
    };

    $bgAlert = match($alert) {
        default => $alert ? 'alert' : '', // bila cuma alert, tanpa styling .flash, tambahkan bg secara manual
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
        @endisset
        <div class="flex-1">{{ $slot }}</div>
    </div>
    @if ($alert || $button || $mode)
        <div><button class="tombol-none" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
    @endif
</div>
