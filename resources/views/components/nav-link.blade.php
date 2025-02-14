@props(['active'=>false])

<a {{ $attributes }} class="{{ $active ? 'current' : ''}}">{{ $slot }}</a>

{{--
<x-nav-link href="/route" :active="request()->is('url/url')">Menu</x-nav-link>
 --}}
