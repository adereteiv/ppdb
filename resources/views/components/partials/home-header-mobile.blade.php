@props(['isOpen' => false, 'loggedIn' => false])

<nav id="mobileNavbar" class="home-navbar-mobile vertical-dropdown">
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
        @if ($loggedIn === true)
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/pendaftar/dashboard">
                <span class="flex content-padding-side-rem">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                    <h6 class="padding-left-10">@auth{{ Auth::user()->role_id == 1 ? 'Admin' : Auth::user()->name }}@endauth</h6>
                </span>
            </x-nav-link>
        </li>
        @elseif ($isOpen === true)
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/login" :active="request()->is('login')">
                <h6 class="content-padding-side-rem">Log In</h6>
            </x-nav-link>
        </li>
        @endif
    </ul>
</nav>
