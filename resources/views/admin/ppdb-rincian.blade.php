<x-layouts.app-layout>

<div id="admin-ppdb-rincian" class="app-content wrapper">
    <div class="content-title margin-vertical">Rincian PPDB
    </div>
    <div class="ppdb-rincian">
        <div class="flex justify-flex-end">
            <div class="dropdown">
                <button class="tombol tombol-netral" onclick="tampilkanLanjutan(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                    Tindakan
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-360 280-560h400L480-360Z"/></svg>
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <!-- Umum -->
                    <a href="#">Export</a>
                    <!-- PPDB-Arsip Only , harus ditutup dulu baru bisa delete -->
                    <a href="#">Hapus PPDB</a>
                    <!-- PPDB-Aktif Only -->
                    <a href="#">Tutup PPDB</a>
                </div>
            </div>
        </div>
        <div class="margin-vertical-narrow">
            <table class="alternate">
                <tr>
                    <th width="30%">Status</th>
                    <td>Slot{Aktif/Arsip}</td>
                </tr>
                <tr>
                    <th>Periode Pendaftaran</th>
                    <td>Slot</td>
                </tr>
                <tr>
                    <th>Gelombang</th>
                    <td>Slot</td>
                </tr>
                <tr>
                    <th>Jumlah Pendaftar</th>
                    <td>Slot</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>Slot</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>Slot</td>
                </tr>
                <tr>
                    <th>Tanggal Berakhir</th>
                    <td>Slot</td>
                </tr>
            </table>
        </div>
    </div>
</div>

</x-layouts.app-layout>
