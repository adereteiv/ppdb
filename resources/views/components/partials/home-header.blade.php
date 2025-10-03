@props(['isOpen' => false, 'loggedIn' => false])

<header class="home-header">
    <div class="container">
        <div class="flex align-items-center justify-between">
            <h2 class="content-padding-side-rem">
                <x-nav-link href="/beranda">Portal PPDB</x-nav-link>
            </h2>
            <div class="home-navbar margin-left-auto">
                <nav class="navbar">
                    <x-nav-link href="/beranda" :active="request()->is('beranda')">Beranda</x-nav-link>
                    <x-nav-link href="/profil" :active="request()->is('profil')">Profil TK</x-nav-link>
                    <x-nav-link href="/struktur" :active="request()->is('struktur')">Struktur</x-nav-link>
                    <x-nav-link href="/daftar" :active="request()->is('daftar')">Daftar</x-nav-link>
                    @if ($loggedIn === true)
                    <x-nav-link href="/pendaftar/dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                        <span class="padding-left-10">@auth{{ Auth::user()->role_id == 1 ? 'Admin' : Auth::user()->name }}@endauth</span>
                    </x-nav-link>
                    @elseif ($isOpen === true)
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
