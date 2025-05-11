@props(['isOpen' => false])

<nav id="mobileNavbar" class="home-navbar-mobile">
    <ul class="container content-padding-vertical">
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/beranda" :active="request()->is('beranda')">
                <h6 class="content-padding-side-rem">Beranda</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/profil" :active="request()->is('profil')">
                <h6 class="content-padding-side-rem">Profil TK</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/struktur" :active="request()->is('struktur')">
                <h6 class="content-padding-side-rem">Struktur</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/daftar" :active="request()->is('daftar')">
                <h6 class="content-padding-side-rem">Daftar</h6>
            </x-nav-link>
        </li>
        @if ($isOpen === true)
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/login" :active="request()->is('login')">
                <h6 class="content-padding-side-rem">Log In</h6>
            </x-nav-link>
        </li>
        @endif
    </ul>
</nav>
