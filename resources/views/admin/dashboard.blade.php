<x-layouts.app-layout>
<div class="app-content gap-rem">
    {{-- <div class="admin-welcome wrapper">
        <x-partials.app-content-title class="beranda-item bg-blue" :hideBackLink="true">
            <x-slot:title><h6>Beranda</h6></x-slot:title>
        </x-partials.app-content-title>
        <div class="flex flex-center text-align-center content-padding">
            <h3>Selamat Datang <br>
            Di Sistem Informasi Penerimaan Peserta Didik Baru <br>
            TK Negeri Pembina Sungai Kakap</h3>
        </div>
    </div> --}}
    <div class="admin-welcome wrapper">
        <div class="flex flex-center text-align-center content-padding-rem margin-vertical">
            <h6>Selamat Datang <br>
            Di Sistem Informasi Penerimaan Peserta Didik Baru <br>
            TK Negeri Pembina Sungai Kakap</h6>
        </div>
    </div>
    <div class="wrapper teks-putih text-align-center bg-blue">
        <div class="content-padding-rem">
            <h6 class="margin-vertical">Gelombang PPDB Terbaru:<br>{{ $batch }}</h6>
            @if (!$batch)
                <h6 class="margin-vertical">Total Pendaftar: {{ $pendaftaranTotal }}</h6>
            @endif
        </div>
    </div>
    <div class="admin-summary gap-rem">
        <div class="wrapper beranda-item reminder must">
            <div class="flex flex-col justify-between padding-10 height-100">
                <p>Menunggu Verifikasi</p>
                <h5>{{ $pendaftaranMenunggu }}</h5>
            </div>
        </div>
        <div class="wrapper beranda-item reminder warn">
            <div class="flex flex-col justify-between padding-10 height-100">
                <p>Pendaftaran Belum Lengkap</p>
                <h5>{{ $pendaftaranMengisi }}</h5>
            </div>
        </div>
        <div class="wrapper beranda-item reminder mild">
            <div class="flex flex-col justify-between padding-10 height-100">
                <p>Persyaratan Lengkap</p>
                <h5>{{ $pendaftaranLengkap }}</h5>
            </div>
        </div>
        <div class="wrapper beranda-item reminder mid">
            <div class="flex flex-col justify-between padding-10 height-100">
                <p>Pendaftaran Terverifikasi</p>
                <h5>{{ $pendaftaranTerverifikasi }}</h5>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
