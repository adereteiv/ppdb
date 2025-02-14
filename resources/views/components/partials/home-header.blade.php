<header class="home-header">
    <div class="container flex align-items-center">
        <div>
            <h2><a href="">
                <x-nav-link href="/beranda" :active="request()->is('beranda')">Portal PPDB</x-nav-link>
            </a></h2>
        </div>
        <nav class="home-nav">
            <x-nav-link href="/beranda" :active="request()->is('beranda')">Beranda</x-nav-link>
            <x-nav-link href="/profil" :active="request()->is('profil')">Profil TK</x-nav-link>
            <x-nav-link href="/struktur" :active="request()->is('struktur')">Struktur</x-nav-link>
            <x-nav-link href="/daftar" :active="request()->is('daftar')">Daftar</x-nav-link>
            <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
        </nav>
    </div>
</header>
