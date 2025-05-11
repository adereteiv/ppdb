<header class="app-header flex align-items-center justify-between content-padding content-padding-side-rem">
    <div class="app-header__title-2 content-padding-side-rem">
        <button data-toggle-target="#appNavMobile" data-toggle-mode="open" class="tombol-none flex flex-center tooltip" tooltip="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24" width="24"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
            <span class="tooltiptext">Menu</span>
        </button>
    </div>
    <div class="app-header__title-1 flex align-items-center content-padding-side-rem">
        <button data-toggle-target="#appNavbar" class="tombol-none flex flex-center tooltip" tooltip="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="24" width="24"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
            <span class="tooltiptext">Menu</span>
        </button>
        <h3 class="text-align-center content-padding-side-rem">
            @if (request()->is('pendaftar/dashboard*') || request()->is('admin/dashboard*') )Beranda
            @elseif (request()->is('pendaftar/profil*'))Profil
            @elseif (request()->is('pendaftar/recovery*') || request()->is('pendaftar/formulir*') || request()->is('pendaftar/dokumen*') || request()->is('pendaftar/buktibayar*'))Pendaftaran
            @elseif (request()->is('admin/ppdb*'))Kelola PPDB
            @elseif (request()->is('admin/pengumuman*'))Kelola Pengumuman
            @endif
        </h3>
    </div>
    <div class="flex app-topbar align-items-center">
        <div class="content-padding-side-rem tombol-none app-topbar__item left tooltip" tooltip="left">
            <span class="norm flex flex-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                <span class="padding-left-10">@auth{{ Auth::user()->role_id == 1 ? 'Admin' : Auth::user()->name }}@endauth</span>
            </span>
            <span class="mobi flex flex-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                <span class="tooltiptext">@auth{{ Auth::user()->role_id == 1 ? 'Admin' : Auth::user()->name }}@endauth</span>
            </span>
        </div>
        <form id="logoutForm" action="/logout" method="POST"> @csrf
            <button form="logoutForm" type="submit" class="content-padding-side-rem tombol-none app-topbar__item right border-left-groove tooltip" tooltip="left">
                <span class="norm flex flex-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <p class="padding-left-10">Keluar</p>
                </span>
                <span class="mobi flex flex-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <span class="tooltiptext">Keluar</span>
                </span>
            </button>
        </form>
        <script>
            const form = document.getElementById('logoutForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                sessionStorage.clear();
                form.submit();
            });
        </script>
    </div>
</header>
