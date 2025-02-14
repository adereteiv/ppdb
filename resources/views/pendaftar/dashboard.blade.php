<x-layouts.app-layout>

<div id="pendaftar-beranda" class="app-content gap">
    {{-- <div class="wrapper">
        <h5 class="margin-vertical">
            <x-status-pendaftaran :status="$pendaftaran->status" />
        </h5>
        <div>
            <ul>
                <li class="">Formulir Pendaftaran</li>
                <li class="">Dokumen Persyaratan</li>
                <li class="">Bukti Pembayaran</li>
            </ul>
        </div>
    </div> --}}
    <div class="flex gap">
        <div class="wrapper flex-1">
            <div class="margin-vertical">
                <h5>Syarat & Ketentuan</h5>
            </div>
            <div>
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
                            <li>Surat Pernyataan Orang Tua/Wali Calon Siswa <a href="#">(unduh disini)</a></li>
                            <li>KIA (opsional)</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper flex-1">
            <div class="margin-vertical">
                <h5>Prosedur Pendaftaran</h5>
            </div>
            <div>
                <ol>
                    <li>Melakukan registrasi akun dengan menekan tombol Daftar Sekarang pada halaman Beranda atau halaman Log In;</li>
                    <li>Silakan mengakses Portal Pendaftar dengan melakukan Log In terlebih dahulu;</li>
                    <li>Mengisi Formulir Pendaftaran dengan sebenar-benarnya dan mengunggah Dokumen Persyaratan;</li>
                    <li>Format Surat Pernyataan dapat diunduh pada halaman Portal PPDB di bagian Syarat Pendaftaran;</li>
                    <li>Menerima hasil penerimaan yang diumumkan pada Notifikasi di Portal Pendaftar maupun bagian Papan Informasi di halaman Portal PPDB.</li>
                    <li>Mengunggah Bukti Pembayaran dilakukan setelah .... </li>
                </ol>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
