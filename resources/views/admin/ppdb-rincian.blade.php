<x-layouts.app-layout>
<x-slot:backLink></x-slot:backLink>
<div id="admin-ppdb-rincian" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>
                @if ($batch->status)
                    {{ route('admin.ppdb.aktif.index') }}
                @else
                    {{ route('admin.ppdb.arsip.index') }}
                @endif
            </x-slot:backLink>
            <x-slot:title><h6>Rincian PPDB</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="ppdb-rincian content-padding-vertical content-padding-side-rem">
            <div class="flex justify-flex-end">
                <x-dropdown class="wrapper right-0">
                    <x-slot:button>
                        <span class="padding-left-10">Tindakan</span>
                        <svg :style="open ? 'transform: rotate(90deg); transition: transform 0.15s;' : 'transform: rotate(0deg); transition: transform 0.15s;'" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M400-280v-400l200 200-200 200Z"/></svg>
                    </x-slot:button>
                    @if ($batch->status)
                    <!-- Umum -->
                    <form action="{{ route('admin.ppdb.aktif.export') }}" method="GET">
                        <button type="submit" class="dropdown-menu tombol-none margin-unset">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-480ZM202-65l-56-57 118-118h-90v-80h226v226h-80v-89L202-65Zm278-15v-80h240v-440H520v-200H240v400h-80v-400q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H480Z"/></svg>
                            <span class="padding-left-10">Export Data</span>
                        </button>
                    </form>
                    <!-- PPDB-Aktif Only -->
                    <form action="{{ route('admin.ppdb.aktif.tutup') }}" method="POST" onsubmit="return confirm('Yakin ingin menutup gelombang ini?')"> @csrf
                        <button type="submit" class="dropdown-menu tombol-none margin-unset">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                            <span class="padding-left-10">Tutup PPDB</span>
                        </button>
                    @else
                    <form action="{{ route('admin.ppdb.arsip.export', $batch->id) }}" method="GET">
                        <button type="submit" class="dropdown-menu tombol-none margin-unset">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M480-480ZM202-65l-56-57 118-118h-90v-80h226v226h-80v-89L202-65Zm278-15v-80h240v-440H520v-200H240v400h-80v-400q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H480Z"/></svg>
                            <span class="padding-left-10">Export Data</span>
                        </button>
                    </form>
                    <!-- PPDB-Arsip Only , harus ditutup dulu baru bisa delete -->
                    <form action="{{ route('admin.ppdb.arsip.destroy', $batch->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gelombang ini? (Tindakan tidak dapat diurung!)')"> @csrf
                        <button type="submit" class="dropdown-menu tombol-none margin-unset">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="20" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            <span class="padding-left-10">Hapus PPDB</span>
                        </button>
                    @endif
                    </form>
                </x-dropdown>
            </div>
            <div class="margin-vertical-narrow">
                <table class="alternate fixed detail">
                    <tr><td width="20%">Status</td>
                        <td width="2%">:</td>
                        <td>
                            {{ $batch->status ? ($batch->waktu_tenggat->greaterThan(now()) ? 'Menerima Pendaftaran' : 'Tidak Menerima Pendaftaran') : 'Tutup' }}
                        </td>
                    </tr>
                    <tr><td>Periode Pendaftaran</td>
                        <td>:</td>
                        <td>{{ $batch->tahun_ajaran }}</td>
                    </tr>
                    <tr><td>Gelombang</td>
                        <td>:</td>
                        <td>{{ $batch->gelombang }}</td>
                    </tr>
                    <tr><td>Jumlah Pendaftar</td>
                        <td>:</td>
                        <td>{{ $batch->pendaftaran->count() }}</td>
                    </tr>
                    <tr><td>Tanggal Mulai</td>
                        <td>:</td>
                        <td>{{ $batch->waktu_mulai->translatedFormat('d F Y, H:m:i') }}</td>
                    </tr>
                    <tr><td>Tanggal Berakhir</td>
                        <td>:</td>
                        <td>{{ $batch->waktu_tenggat->translatedFormat('d F Y, H:m:i') }}</td>
                    </tr>
                    @if (!$batch->status)
                    <tr><td>Tanggal Tutup</td>
                        <td>:</td>
                        <td>{{ $batch->waktu_tutup->translatedFormat('d F Y, H:m:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
