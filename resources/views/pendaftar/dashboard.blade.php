<x-layouts.app-layout>

<div id="pendaftar-beranda" class="app-content gap">
    <div class="wrapper">
        <h3 class="margin-vertical flex"> Status Pendaftaran :&nbsp;<x-status-pendaftaran class="flex align-items-center" :status="$pendaftaran->status ?? null"/>
        </h3>
        <div class="stepper">
            <ul>
                <li class="{{ $formulirLengkap ? 'active' : '' }}">Formulir Pendaftaran</li>
                <li class="{{ $dokumenLengkap ? 'active' : '' }}">Dokumen Persyaratan</li>
                <li class="{{ $buktiBayarLengkap ? 'active' : '' }}">Bukti Pembayaran</li>
            </ul>
        </div>
    </div>
    <div class="flex gap">
        <div class="wrapper flex-1">
            <div class="margin-vertical">
                <h2>Syarat & Ketentuan</h2>
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
                            <li>Surat Pernyataan Orang Tua/Wali Calon Siswa <a href="#">(lihat disini)</a></li>
                            <li>KIA (opsional)</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper flex-1">
            <div class="margin-vertical">
                <h2>Prosedur Pendaftaran</h2>
            </div>
            <div>
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
