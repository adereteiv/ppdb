<x-layouts.app-layout>

<div class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true">
            <x-slot:title><h6>Riwayat Pengumuman</h6></x-slot:title>
        </x-partials.app-content-title>
        <x-table-list class="pengumuman-riwayat">
            <x-slot:menu>
                <div class="flex">
                    <form action="{{ route('admin.pengumuman.export') }}" method="GET">
                        <button type="submit" class="tombol tombol-netral tooltip" tooltip="top">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-480ZM202-65l-56-57 118-118h-90v-80h226v226h-80v-89L202-65Zm278-15v-80h240v-440H520v-200H240v400h-80v-400q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H480Z"/></svg>
                            <span class="tooltiptext">Export</span>
                        </button>
                    </form>
                    <a href="{{ route('admin.pengumuman.create') }}" class="tombol tombol-netral tooltip" tooltip="top">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        <span class="tooltiptext">Buat Pengumuman</span>
                    </a>
                </div>
            </x-slot:menu>
            <x-slot:search>
                <div class="flex align-items-center">
                    <div class="searchbar">
                        <input type="text" id="searchInput" class="form-item search" placeholder="Masukkan isi pengumuman..."/>
                        <span class="search-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg></span>
                    </div>
                </div>
            </x-slot:search>
            <x-slot:colgroup><col><col><col><col><col></x-slot:colgroup>
            <x-slot:thead>
                <th>#</th>
                <th class="sortable" data-sort="jadwal_posting">Jadwal Posting</th>
                <th>Keterangan</th>
                <th>Lampiran</th>
                <th>Aksi</th>
            </x-slot:thead>
            {{-- <tbody id="tableBody"></tbody> --}}
            <x-slot:pagination>
                <div class="margin-top-auto flex justify-between">
                    <span>Tampilkan <x-input-select id="perPageSelect" name="perPage" :options="config('form-options.per_page')" :noDefault="true"/> data</span>
                    <div id="handlePagination"></div>
                </div>
            </x-slot:pagination>
        </x-table-list>
    </div>
</div>
</x-layouts.app-layout>
