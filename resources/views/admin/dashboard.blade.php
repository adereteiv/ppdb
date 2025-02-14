<x-layouts.app-layout>
<div id="admin-beranda" class="app-content gap">
    <div class="wrapper admin-welcome">
        <h3>Selamat Datang <br>
        Di Sistem Informasi Penerimaan Peserta Didik Baru <br>
        TK Negeri Pembina Sungai Kakap</h3>
    </div>
    <!-- Beranda shows the status of current 'active' ppdb, if there isn't any shows the latest PPDB-->
    <!-- reflects whats going on in database -->
    <div class="admin-summary gap">
        <div class="wrapper beranda-item flex flex-col bg-red">
            <h6>Jumlah Pendaftar</h6>
            <h3>Shows how many records of registration in a given admission batch</h3>
        </div>
        <div class="wrapper beranda-item flex flex-col bg-yellow">
            <h6>Persyaratan Belum Lengkap</h6>
            <h3>Shows how many registration has the $status->'Belum Lengkap'</h3>
        </div>
        <div class="wrapper beranda-item flex flex-col bg-blue">
            <h6>Persyaratan Lengkap</h6>
            <h3>Shows how many registration has the $status->'Lengkap'</h3>
        </div>
        <div class="wrapper beranda-item flex flex-col bg-greendark">
            <h6>Pendaftaran Terverifikasi</h6>
            <h3>Shows how many registration has the $status->'Terverifikasi'</h3>
        </div>
    </div>
</div>
</x-layouts.app-layout>
