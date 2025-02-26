<x-layouts.home-layout>
    <section id="section-hero" class="home-section">
        <div class="container">
            <div class="flex">
                <div class="section-kid-body">
                    <div>
                        <h1>Penerimaan Peserta Didik Baru</h1>
                        <h4>TK Negeri Pembina Sungai Kakap
                            <!--  reflect perubahan dari pembukaan gelombang baru panel admin PPDB -->
                            <br>Tahun Ajaran 2025/2026
                        </h4>
                    </div>
                    <div class="hero-button">
                        <a href="#section-prosedur">Syarat Pendaftaran</a>
                        <a href="/daftar">
                            <span>Daftar Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M647-440H160v-80h387L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="section-kid-img">
                    <img src="https://placehold.co/350x160?text=Dummy+Image" alt="container image">
                </div>
            </div>
        </div>
    </section>

    <section id="section-prosedur" class="home-section">
        <div class="container">
            <h2 id="tata-pendaftaran" class="text-align-center margin-vertical">Tata Cara Pendaftaran</h2>
            <div>
                <h3 class="margin-vertical">Syarat dan Ketentuan</h3>
                <div class="flex">
                    <div class="section-kid-img">
                        <img src="https://placehold.co/100?text=Dummy+Image" alt="container image">
                    </div>
                    <div class="section-kid-body">
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
            </div>
            <div>
                <h3 class="margin-vertical">Langkah Pendaftaran</h3>
                <div class="flex">
                    <div class="section-kid-img">
                        <img src="https://placehold.co/100?text=Dummy+Image" alt="container image">
                    </div>
                    <div class="section-kid-body">
                        <ol>
                            <li>Melakukan registrasi akun dengan menekan tombol 'Daftar Sekarang' pada halaman beranda;</li>
                            <li>Silakan mengakses Dashboard Anda dengan melakukan Log In terlebih dahulu;</li>
                            <li>Mengisi Formulir Pendaftaran dengan sebenar-benarnya;</li>
                            <li>Mengunggah Dokumen Persyaratan, format Surat Pernyataan dapat diunduh pada halaman Portal PPDB di bagian <a href="#tata-pendaftaran" style="text-decoration: none">Syarat Pendaftaran</a>;</li>
                            <li>Membayar biaya pendaftaran dan mengunggah Bukti Pembayaran pada Dashboard.</li>
                            <li>Pengumuman hasil penerimaan di bagian Papan Informasi pada halaman <a href="/beranda">Portal PPDB.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-informasi" class="home-section">
        <div class="container">
            <h2 class="text-align-center margin-vertical">Papan Informasi</h2>
            <h6 class=" text-align-center margin-vertical">Penerimaan dibuka dari tanggal {$start_date} hingga {$end_date}.</h6>
            <div>
                <h3>Pengumuman : {$Judul Pengumuman}</h3>
                <p class="teks-netral"><i>slot $posted_at</i></p><br>
                <div class="flex">
                    <div class="section-kid-img justify-center">
                        <img src="https://placehold.co/100x150?text=Dummy+Image" alt="container image">
                    </div>
                    <div class="section-kid-body">
                        <div class="section-kid-body">
                            <p>slot {$Keterangan}</p>
                            <p>slot {$File link}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.home-layout>
