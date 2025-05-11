<x-layouts.home-layout>
    <section id="section-hero" class="home-section home-cover" style="background-image: url(img/tk_background_2.png)">
        <div class="flex flex-center flex-col justify-around content-padding-rem  container">
            <div class="beranda-main">
                <div class="text-align-center">
                    <h3 class="header_main">Selamat Datang di Homepage</h3>
                    <h1 class="header_main">Penerimaan Peserta Didik Baru</h1>
                    <h4 class="header_sub">TK Negeri Pembina Sungai Kakap @if($batch)<br> Tahun Ajaran {{ $batch->tahun_ajaran }}@endif</h4>
                </div>
            </div>
            @if ($batch)
                <div class="beranda-main flex flex-center">
                    <a class="hero-button tombol-positif" href="/daftar">
                        <span>Daftar Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M647-440H160v-80h387L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section id="section-prosedur" class="home-section">
        <div class="content-padding-rem container">
            <h2 id="tata-pendaftaran" class="text-align-center margin-vertical">Tata Cara Pendaftaran</h2>
            <div>
                <hr class="content-line">
                <h3 class="margin-vertical">Syarat dan Ketentuan</h3>
                <div class="flex">
                    <div class="section-kid-small">
                        <img src="https://placehold.co/100?text=Dummy+Image" alt="container image">
                    </div>
                    <div class="section-kid-big">
                        <x-partials.list-syarat-pendaftaran/>
                    </div>
                </div>
            </div>
            <div>
                <hr class="content-divider-partial">
                <h3 class="margin-vertical">Langkah Pendaftaran</h3>
                <div class="flex">
                    <div class="section-kid-small">
                        <img src="https://placehold.co/100?text=Dummy+Image" alt="container image">
                    </div>
                    <div class="section-kid-big">
                        <x-partials.list-alur-pendaftaran/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($pengumuman)
    <section id="section-informasi" class="home-section">
        <div class="content-padding-rem container">
            <h2 class="text-align-center margin-vertical">Papan Informasi</h2>
            <x-pengumuman-preview
                :jadwal="$pengumuman->jadwal_posting"
                :judul="$pengumuman->judul"
                :keterangan="$pengumuman->keterangan"
                :file="$pengumuman->file_paths"
            />
        </div>
    </section>
    @endif
</x-layouts.home-layout>
