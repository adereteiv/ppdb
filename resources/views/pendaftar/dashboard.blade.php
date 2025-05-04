<x-layouts.app-layout>

<div id="pendaftar-beranda" class="app-content gap">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true">
            <h5>Status Pendaftaran :&nbsp;</h5>
            <x-status-pendaftaran class="flex align-items-center" :value="$pendaftaran->status ?? null"/>
        </x-partials.app-content-title>
        <div class="stepper scrollable content-padding-side-rem content-padding-bottom-rem">
            <li class="content-padding {{ $formulirLengkap ? 'active' : '' }}">Formulir Pendaftaran</li>
            <li class="content-padding {{ $dokumenLengkap ? 'active' : '' }}">Dokumen Persyaratan</li>
            <li class="content-padding {{ $buktiBayarLengkap ? 'active' : '' }}">Bukti Pembayaran</li>
        </div>
    </div>
    <div class="flex gap">
        <div class="wrapper flex-1">
            <x-partials.app-content-title :hideBackLink="true">
                <h5>Syarat & Ketentuan</h5>
            </x-partials.app-content-title>
            <div class="content-padding-side-rem content-padding-bottom">
                <ol>
                    <li>Usia anak min. 4 tahun (di bulan XXYY):
                        <ol type="a">
                            <li>Usia TK A: 4 - 5 Tahun</li>
                            <li>Usia TK B: 5 - 6 Tahun</li>
                        </ol>
                    </li>
                    <li>Melengkapi Formulir Pendaftaran dan melampirkan;</li>
                    <li>Dokumen Persyaratan (Scan/Foto dengan gambar tampak jernih dan tulisan kelihatan jelas)
                        <ul>
                            <li>Kartu Keluarga</li>
                            <li>KTP Orang Tua/Wali</li>
                            <li>Akta Kelahiran Anak</li>
                            <li>Pas Foto Anak</li>
                            <li>Surat Pernyataan Orang Tua/Wali Calon Siswa <a href="#">(lihat disini)</a></li>
                            <li>KIA (opsional)</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper flex-1">
            <x-partials.app-content-title :hideBackLink="true">
                <h5>Prosedur Pendaftaran</h5>
            </x-partials.app-content-title>
            <div class="content-padding-side-rem content-padding-bottom">
                <ol>
                    <li>Melakukan registrasi akun dengan menekan tombol 'Daftar Sekarang' pada halaman beranda;</li>
                    <li>Silakan mengakses Dashboard Anda dengan melakukan Log In terlebih dahulu;</li>
                    <li>Mengisi Formulir Pendaftaran dengan sebenar-benarnya;</li>
                    <li>Mengunggah Dokumen Persyaratan, format Surat Pernyataan dapat diunduh pada halaman Portal PPDB di bagian Syarat Pendaftaran</a>;</li>
                    <li>Membayar biaya pendaftaran dan mengunggah Bukti Pembayaran pada Dashboard.</li>
                    <li>Pengumuman hasil penerimaan di bagian Papan Informasi pada halaman <a href="/beranda" style="text-decoration: none">Portal PPDB</a>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
