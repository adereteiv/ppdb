@props(['hideBackLink' => false, 'backLink' => null, 'title' => null])

<div {{ $attributes->merge(['class'=>"flex content-title content-padding-vertical content-padding-side-rem"]) }}>
    <span class="flex align-items-center gap">
        @if (empty($hideBackLink))
            <a class="flex flex-center tooltip" tooltip="bottom" href="{{ $backLink }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 -960 960 960"><path d="M640-80 240-480l400-400 71 71-329 329 329 329-71 71Z"/></svg>
                <span class="tooltiptext">Kembali</span>
            </a>
        @endif
        {{ $title }}
    </span>
    {{ $slot }}
</div>

{{--
<x-partials.app-content-title :hideBackLink="true">
    <x-slot:backLink slot:backLink>/admin/pengumuman</x-slot:backLink>
</x-partials.app-content-title>
--}}
