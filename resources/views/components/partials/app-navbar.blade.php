<aside id="appNavbar" {{ $attributes->merge(['class'=>"app-navbar open"])}}>
    <div class="scrollable">
        <div class="content-padding">
            <div class="app-topbar flex flex-center ">
                <div class="sidebar-top">
                    <h3 class="text-align-center">Menu</h3>
                </div>
            </div>
        </div>
        <hr style="border: 1px solid rgba(255, 255, 255, .15); margin: 0 1rem;">
        <nav>
            <ul>
                @if (Auth::user()->role_id == 1)
                    <li>
                        <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('admin.dashboard') }}" :active="request()->is('admin/dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                            <span class="flex flex-center padding-left-10">Beranda</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('admin.ppdb.index') }}" :active="request()->is('admin/ppdb*')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M80-200v-80h400v80H80Zm0-200v-80h200v80H80Zm0-200v-80h200v80H80Zm744 400L670-354q-24 17-52.5 25.5T560-320q-83 0-141.5-58.5T360-520q0-83 58.5-141.5T560-720q83 0 141.5 58.5T760-520q0 29-8.5 57.5T726-410l154 154-56 56ZM560-400q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Z"/></svg>
                            <span class="flex flex-center padding-left-10">PPDB</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('admin.pengumuman.index') }}" :active="request()->is('admin/pengumuman*')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M720-440v-80h160v80H720Zm48 280-128-96 48-64 128 96-48 64Zm-80-480-48-64 128-96 48 64-128 96ZM200-200v-160h-40q-33 0-56.5-23.5T80-440v-80q0-33 23.5-56.5T160-600h160l200-120v480L320-360h-40v160h-80Zm240-182v-196l-98 58H160v80h182l98 58Zm120 36v-268q27 24 43.5 58.5T620-480q0 41-16.5 75.5T560-346ZM300-480Z"/></svg>
                            <span class="flex flex-center padding-left-10">Pengumuman</span>
                        </x-nav-link>
                    </li>
                @else
                    @if (request()->is('pendaftar/recovery'))
                        <li>
                            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('pendaftar.recovery') }}" :active="request()->is('pendaftar/recovery')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z"/></svg>
                                <span class="padding-left-10">Pendaftaran</span>
                            </x-nav-link>
                        </li>
                    @else
                        <li>
                            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('pendaftar.dashboard') }}" :active="request()->is('pendaftar/dashboard')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                                <span class="flex flex-center padding-left-10">Beranda</span>
                            </x-nav-link>
                        </li>
                        <li>
                            @php
                                $submenuOpen =  request()->is('pendaftar/formulir') || request()->is('pendaftar/dokumen') || request()->is('pendaftar/buktibayar');
                            @endphp
                            <div class="submenu">
                                <button data-toggle-target="#appNavSub" class="conform nav-link justify-between content-padding-vertical content-padding-side-rem position-relative {{ $submenuOpen ? 'current active' : '' }}">
                                    <span class="flex flex-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z"/></svg>
                                        <span class="flex flex-center padding-left-10">Pendaftaran</span>
                                    </span>
                                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M400-280v-400l200 200-200 200Z"/></svg>
                                </button>
                                <div id="appNavSub" class="submenu-content {{ $submenuOpen ? 'open' : '' }}">
                                    <div class="content-padding-bottom-rem content-padding-side-rem">
                                        <div class="wrapper">
                                            <x-nav-link href="{{ route('pendaftar.buktiBayar') }}" :active="request()->is('pendaftar/buktibayar')">Bukti Pembayaran</x-nav-link>
                                            <x-nav-link href="{{ route('pendaftar.formulir') }}" :active="request()->is('pendaftar/formulir')">Formulir</x-nav-link>
                                            <x-nav-link href="{{ route('pendaftar.dokumen') }}" :active="request()->is('pendaftar/dokumen')">Unggah Dokumen</x-nav-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <x-nav-link class="content-padding-vertical content-padding-side-rem" href="{{ route('pendaftar.profil') }}" :active="request()->is('pendaftar/profil')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-240q-56 0-107 17.5T280-170v10h400v-10q-42-35-93-52.5T480-240Zm0-80q69 0 129 21t111 59v-560H240v560q51-38 111-59t129-21Zm0-160q-25 0-42.5-17.5T420-540q0-25 17.5-42.5T480-600q25 0 42.5 17.5T540-540q0 25-17.5 42.5T480-480ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm240-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Zm0-140Z"/></svg>
                                <span class="flex flex-center padding-left-10">Profil</span>
                            </x-nav-link>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>
    </div>
    <footer class="margin-top-auto content-padding">
        <p class="text-align-center">&copy; 2025 TK Negeri Pembina Sungai Kakap</p>
    </footer>
</aside>
