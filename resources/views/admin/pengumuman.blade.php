<x-layouts.app-layout>
<div class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true">
            <x-slot:title><h6>Riwayat Pengumuman</h6></x-slot:title>
        </x-partials.app-content-title>
        <x-table-list class="pengumuman-riwayat">
            <x-slot:menu>
                <div class="flex">
                    <a href="/admin/pengumuman/buat" class="tombol tombol-netral tooltip" tooltip="top">
                        <span class="tooltiptext">Buat</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                    </a>
                    <!-- Shows upon select (Bulk Action) -->
                    <button class="tombol tombol-netral tooltip" tooltip="top">
                        <span class="tooltiptext">Pilih Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  height="20" width="20"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
                    </button>
                    <button class="tombol tombol-negatif">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg> -->
                        Hapus
                    </button>
                </div>
            </x-slot:menu>
            <x-slot:search>
                <div class="flex align-items-center">
                    <form action="/admin/pengumuman" method="get">
                        <div class="searchbar">
                            <input class="form-item search" type="text" name="" id="" placeholder="Cari isi pengumuman..." value=""/>
                            <span class="search-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                            </span>
                            {{-- <button type="submit" class="tombol tombol-netral">
                            </button> --}}
                        </div>
                    </form>
                </div>
            </x-slot:search>
            <x-slot:colgroup><col><col><col><col><col></x-slot:colgroup>
            <x-slot:thead>
                <th></th>
                <th>Tanggal Posting</th>
                <th>Keterangan</th>
                <th>File Upload</th>
                <th>Aksi</th>
            </x-slot:thead>
            <tr>
                <td><input type="checkbox"></td>
                <td>31 Desember 2024</td>
                <td>
                    <p><strong>
                        [Judul Pengumuman]
                    </strong></p>
                    <P>File Upload File UploadFile UploadFile UploadFile
                        UploadFile Upload File UploadFile UploadFile Upload</P>
                </td>
                <td>Slot</td>
                <td>
                    <div class="flex justify-center">
                        <button class="tombol tooltip" tooltip="top">
                            <span class="tooltiptext">Lihat</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                        </button>
                        <button class="tombol tooltip" tooltip="top">
                            <span class="tooltiptext">Hapus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            <!-- Hapus -->
                        </button>
                    </div>
                </td>
            </tr>
            <x-slot:pagination>
                <div class="margin-top-auto flex justify-between">
                    <span>Tampilkan <x-input-select name="perPage" :options="config('form-options.per_page')" :resetSelector="true" :noDefault="true"/> data</span>
                </div>
            </x-slot:pagination>
        </x-table-list>
        {{--
        <div class="flex justify-between">
            <!-- Searchbar -->
            <div class="flex align-items-center">
                <form action="" method="">
                    <div class="flex">
                        <input class="form-item" width="100px" type="text" name="" id="" placeholder="Cari Pengumuman" value="">
                        <button type="submit" class="tombol-mini tombol-netral">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex">
                <a href="/admin/pengumuman/buat" class="tombol tombol-netral">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                    Buat
                </a>
                <!-- Shows upon select (Bulk Action) -->
                <button class="tombol tombol-netral">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  height="20" width="20"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
                    Pilih Semua
                </button>
                <button class="tombol tombol-negatif">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg> -->
                    Hapus
                </button>
            </div>
        </div>
        <div class="pengumuman-riwayat scrollable margin-vertical-narrow">
            <div class="scrollable">
                <table class="alternate fixed">
                    <colgroup>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal Posting</th>
                            <th>Keterangan</th>
                            <th>File Upload</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table-entries-on">
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="checkbox"></td>
                            <td>31 Desember 2024</td>
                            <td>
                                <p><strong>
                                    [Judul Pengumuman]
                                </strong></p>
                                <P>File Upload File UploadFile UploadFile UploadFile
                                    UploadFile Upload File UploadFile UploadFile Upload</P>
                            </td>
                            <td>Slot</td>
                            <td>
                                <div class="flex justify-between">
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </button>
                                    <button class="tombol-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        <!-- Hapus -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="margin-top-auto">
            Pagination
        </div>
        --}}
    </div>
</div>
</x-layouts.app-layout>
