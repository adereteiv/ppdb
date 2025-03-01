<aside class="app-sidebar content-padding">
    <div class="text-align-center margin-vertical">
        <h3>
            @auth
                {{ Auth::user()->role_id == 1 ? 'Admin' : 'Pendaftar' }}
            @endauth
        </h3>
        <img src="https://placehold.co/100?text=Dummy+Image" alt="">
        <h3>PPDB Daring</h3>
    </div>
    <nav class="margin-bottom-auto scrollable">
        @if(Auth::user()->role_id == 1)
        <ul>
            <li><x-nav-link href="/admin/dashboard" :active="request()->is('admin/dashboard')">Beranda</x-nav-link></li>
            <li><x-nav-link href="/admin/ppdb" :active="request()->is('admin/ppdb*')">PPDB</x-nav-link></li>
            <li><x-nav-link href="/admin/pengumuman" :active="request()->is('admin/pengumuman*')">Pengumuman</x-nav-link></li>
            <li><form action="/logout" method="post">
                @csrf
                <button type="submit" class="conform justify-between">Log Out</button>
            </form></li>
        </ul>
        @else
        <ul>
            <li><x-nav-link href="/pendaftar/dashboard" :active="request()->is('pendaftar/dashboard')">Beranda</x-nav-link></li>
            <li><div x-data="{
                open: false,  // Start with the dropdown closed
                init() {
                    if (['/pendaftar/formulir', '/pendaftar/dokumen', '/pendaftar/buktibayar'].includes(window.location.pathname)) {
                        this.open = true;
                    } else {
                        this.open = false;
                    }
                },
                toggle() {
                    this.open = !this.open;
                    sessionStorage.setItem('pendaftar_menu_open', this.open);
            }}">
                <button class="conform justify-between" @click="toggle">Pendaftaran
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-360 280-560h400L480-360Z"/></svg>
                </button>
                <ul x-show="open" class="submenu">
                    <li><x-nav-link href="/pendaftar/formulir" :active="request()->is('pendaftar/formulir')">Formulir</x-nav-link></li>
                    <li><x-nav-link href="/pendaftar/dokumen" :active="request()->is('pendaftar/dokumen')">Unggah Dokumen</x-nav-link></li>
                    <li><x-nav-link href="/pendaftar/buktibayar" :active="request()->is('pendaftar/buktibayar')">Bukti Pembayaran</x-nav-link></li>
                </ul>
            </div></li>
            <li><x-nav-link href="/pendaftar/profil" :active="request()->is('pendaftar/profil')">Profil</x-nav-link></li>
            <li><form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="conform justify-between">Log Out</button>
            </form></li>
        </ul>
        @endif
    </nav>
    <footer>
        <p>&copy; 2025 TK Negeri Pembina Sungai Kakap</p>
    </footer>
</aside>
