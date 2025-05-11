@props(['isOpen' => false])

<header class="home-header">
    <div class="container">
        <div class="flex align-items-center justify-between">
            <h2 class="content-padding-side-rem">
                <x-nav-link href="/beranda">Portal PPDB</x-nav-link>
            </h2>
            <div class="home-navbar">
                <nav class="navbar">
                    <x-nav-link href="/beranda" :active="request()->is('beranda')">Beranda</x-nav-link>
                    <x-nav-link href="/profil" :active="request()->is('profil')">Profil TK</x-nav-link>
                    <x-nav-link href="/struktur" :active="request()->is('struktur')">Struktur</x-nav-link>
                    <x-nav-link href="/daftar" :active="request()->is('daftar')">Daftar</x-nav-link>
                    @if ($isOpen === true)
                    <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                    @endif
                </nav>
                <button data-toggle-target="#mobileNavbar" class="toggle flex flex-center content-padding-side-rem tombol tombol-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="30" width="30"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>
