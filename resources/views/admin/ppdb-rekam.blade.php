<x-layouts.app-layout>
<x-slot:backLink>/admin/ppdb</x-slot:backLink>

@if (session()->has('success'))
<x-flash-message alert="green">{{ session('success') }}</x-flash-message>
@endif

<div class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title class="justify-between">
            <x-slot:backLink>/admin/ppdb</x-slot:backLink>
            <x-slot:title>
                @if ($batch->status)
                    <h6>Kelola Pendaftaran Aktif</h6></x-slot:title>
                    <a class="sublink tombol-none" href="/admin/ppdb/aktif/rincian">
                @else
                    <h6>Kelola Arsip Pendaftaran</h6></x-slot:title>
                    <a class="sublink tombol-none" href="/admin/ppdb/arsip/rincian">
                @endif
                <span class="norm tooltip" tooltip="top">
                    <i>PPDB {{ $batch->tahun_ajaran }} Gel. {{ $batch->gelombang }}</i>
                    <span class="tooltiptext">Rincian</span>
                </span>
                <span class="mobi tooltip" tooltip="top">
                    <i class="bi bi-info-circle"></i>
                    <span class="tooltiptext">Rincian</span>
                </span>
            </a>
        </x-partials.app-content-title>

        <x-table-list class="ppdb-list-table">
            <x-slot:menu>
                <!-- menu -->
                <div class="flex">
                    {{-- <!-- filter -->
                    <button class="tombol tombol-netral tooltip" tooltip="top">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-160q-17 0-28.5-11.5T400-200v-240L168-736q-15-20-4.5-42t36.5-22h560q26 0 36.5 22t-4.5 42L560-440v240q0 17-11.5 28.5T520-160h-80Zm40-308 198-252H282l198 252Zm0 0Z"/></svg>
                        <div class="tooltiptext">Filter</div>
                    </button> --}}
                    <!-- export -->
                    <button class="tombol tombol-netral tooltip" tooltip="top">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-480ZM202-65l-56-57 118-118h-90v-80h226v226h-80v-89L202-65Zm278-15v-80h240v-440H520v-200H240v400h-80v-400q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H480Z"/></svg>
                        <div class="tooltiptext">Export</div>
                    </button>
                @if ($batch->status)
                        <!-- create -->
                        <a href="{{ route('ppdb.aktif.create') }}" class="tombol tombol-netral tooltip" tooltip="top">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                            <div class="tooltiptext">Tambah</div>
                        </a>
                    </div>
                @endif
            </x-slot:menu>
            <x-slot:search>
                <div class="flex align-items-center">
                    <div class="searchbar">
                        <input type="text" id="searchInput" class="form-item search" placeholder="Cari nama/ID"/>
                        <span class="search-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg></span>
                    </div>
                </div>
            </x-slot:search>
            <x-slot:colgroup><col><col><col><col><col><col></x-slot:colgroup>
            <x-slot:thead>
                <th></th>
                <th class="sortable" data-sort="">Tanggal Mendaftar</th>
                <th class="sortable" data-sort="id">ID Pendaftaran</th>
                <th class="sortable" data-sort="nama_anak">Nama Anak</th>
                <th class="sortable" data-sort="status">Status</th>
                <th>Aksi</th>
            </x-slot:thead>
            {{-- <tbody id="tableBody"></tbody> --}}
            <x-slot:pagination>
                <div class="flex justify-between">
                    <span>Tampilkan <x-input-select id="perPageSelect" name="perPage" :options="config('form-options.per_page')" :noDefault="true" :value="request('perPage')"/> data</span>
                    <div id="handlePagination"></div>
                </div>
            </x-slot:pagination>
        </x-table-list>
    </div>
</div>

</x-layouts.app-layout>
