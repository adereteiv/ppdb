<x-partials.ppdb-rekam>
    <x-slot:title>Kelola Arsip Pendaftaran</x-slot:title>
    <x-slot:menu>
         <!-- menu -->
         <div class="flex">
            <!-- filter -->
            <button class="tombol tombol-netral tooltip" tooltip="bottom">
                <div class="tooltiptext">Tooltip</div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z"/></svg>
            </button>
            <!-- export -->
            <button class="tombol tombol-netral">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-480ZM202-65l-56-57 118-118h-90v-80h226v226h-80v-89L202-65Zm278-15v-80h240v-440H520v-200H240v400h-80v-400q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H480Z"/></svg>
            </button>
            <!-- create: ppdb->status=>true only -->
            @if ($batch->status)
            <button class="tombol tombol-netral">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20"  width="20"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
            </button>
            @endif
        </div>
        <!-- menu: shows upon select (bulk action) -->
        <div class="flex">
            <button class="tombol tombol-netral">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  height="20" width="20"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
                Pilih Semua
            </button>

            @if ($batch->status)
            <x-dropdown>
                    <x-slot:button>
                        Atur Status
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M480-360 280-560h400L480-360Z"/></svg>
                    </x-slot:button>
                    <a href="#">Belum Lengkap</a>
                    <a href="#">Ditinjau</a>
                    <a href="#">Diverifikasi</a>
                    <a href="#">Ditolak</a>
                    <a href="#">Diterima</a>
            </x-dropdown>
            @endif

            <div class="dropdown">
                <button class="tombol tombol-netral" onclick="tampilkanLanjutan(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M480-360 280-560h400L480-360Z"/></svg>
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="#">Export</a>
                    <a href="#">Catatan Admin</a>
                    @if ($batch->status)
                    <a href="#">Hapus</a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot:menu>
    <x-slot:content>
        <tr>
            <td><input type="checkbox"></td>
            <td>$tanggal-lahir</td>
            <td>$full-name</td>
            <td><x-status-pendaftaran :value="$pendaftaran->status ?? null"/></td>
            <td>$catatan-admin</td>
            <td>
                <div class="flex justify-between">
                    <button class="tombol-none tooltip" tooltip="top">
                        <span class="tooltiptext">Salin</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                    </button>
                    <button class="tombol-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                    </button>
                    <button class="tombol-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    </button>
                </div>
            </td>
        </tr>
    </x-slot:content>
</x-partials.ppdb-rekam>
