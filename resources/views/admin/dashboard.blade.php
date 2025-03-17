<x-layouts.app-layout>
<div id="admin-beranda" class="app-content gap">
    <div class="wrapper admin-welcome">
        <h3>Selamat Datang <br>
        Di Sistem Informasi Penerimaan Peserta Didik Baru <br>
        TK Negeri Pembina Sungai Kakap</h3>
    </div>
    <div class="wrapper beranda-item text-align-center bg-blue">
        <h3>Gelombang PPDB: </h3>
        <h6>{{ $batch }}</h6>
    </div>
    <div class="admin-summary gap">
        <div class="wrapper justify-between beranda-item flex flex-col bg-red">
            <h6>Jumlah Pendaftar</h6>
            <h3>{{ $pendaftaranTotal }}</h3>
        </div>
        <div class="wrapper justify-between beranda-item flex flex-col bg-orange">
            <h6>Persyaratan Belum Lengkap</h6>
            <h3>{{ $pendaftaranBelumLengkap }}</h3>
        </div>
        <div class="wrapper justify-between beranda-item flex flex-col bg-blue">
            <h6>Persyaratan Lengkap</h6>
            <h3>{{ $pendaftaranLengkap }}</h3>
        </div>
        <div class="wrapper justify-between beranda-item flex flex-col bg-greendark">
            <h6>Pendaftaran Terverifikasi</h6>
            <h3>{{ $pendaftaranTerverifikasi }}</h3>
        </div>
    </div>
</div>
</x-layouts.app-layout>
