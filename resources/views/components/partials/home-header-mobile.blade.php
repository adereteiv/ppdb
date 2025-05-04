<nav id="mobileNavbar" class="home-navbar-mobile">
    <ul class="container content-padding-vertical">
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/beranda" :active="request()->is('beranda')">
                <h6>Beranda</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/profil" :active="request()->is('profil')">
                <h6>Profil TK</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/struktur" :active="request()->is('struktur')">
                <h6>Struktur</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/daftar" :active="request()->is('daftar')">
                <h6>Daftar</h6>
            </x-nav-link>
        </li>
        <li class="flex flex-center">
            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="/login" :active="request()->is('login')">
                <h6>Log In</h6>
            </x-nav-link>
        </li>
    </ul>
</nav>
