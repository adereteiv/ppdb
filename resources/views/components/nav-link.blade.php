@props(['active'=>false])
@php $class = $active ? 'current' : ''; @endphp
<a {{ $attributes->merge(['class' => "$class nav-link"]) }}>{{ $slot }}</a>
{{-- <x-nav-link href="/route" :active="request()->is('url/url')">Menu</x-nav-link> --}}
