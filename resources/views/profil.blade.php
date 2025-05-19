<x-layouts.home-layout>
    <section id="section-hero" class="home-section" style="background-image: url(img/Filler-Al_Fityan_2.jpg);">
        <div class="hero-overlay" style="background: rgba(0, 0, 0, 0.3);"></div>
        <div class="hero-title flex flex-center flex-col justify-around content-padding-rem container">
            <div class="beranda-main">
                <div class="text-align-center">
                    <h1 class="header_main">Profil Taman Kanak-Kanak</h1>
                </div>
            </div>
        </div>
    </section>
    <section id="section-informasi" class="">
        <div class="container">
            <div class="flex flex-center">
                <div class="info-section">
                    <hr class="content-line">
                    <div class="info-part">
                        <div class="flex-1">
                            <h2>Selayang Pandang</h2>
                        </div>
                        <div class="flex-3">
                            <p>TKN Pembina Sungai Kakap beroperasional sejak tanggal 18 Juli  pada tanggal X. Terdaftar di Y pada tanggal X.
                                SK Pendirian 2016-05-10, Mei
                                Operasional 18 Juli 2016
                                di bawah naungan
                                Kementerian Pendidikan dan Kebudayaan
                                Tanggal SK Izin Operasional : 2017-01-12 Januari berdiri
                                SK Izin Operasional : 503/124/BPMPT-E/TK/2017</p>
                        </div>
                    </div>
                    <hr class="content-divider">
                    <div class="info-part">
                        <div class="flex-1">
                            <h2>Tujuan</h2>
                        </div>
                        <div class="flex-3">
                            <p>Menciptakan anak yang berprestasi, berkarakter, dan berakhlak mulia</p>
                        </div>
                    </div>
                    <hr class="content-divider">
                    <div class="info-part">
                        <div class="flex-1">
                            <h2>Visi</h2>
                        </div>
                        <div class="flex-3">
                            <ul>
                                <li>P = Prestasi</li>
                                <li>U = Unggul</li>
                                <li>N = Nyaman</li>
                                <li>C = Cakep</li>
                                <li>A = Asri</li>
                                <li>K = Kreatif</li>
                            </ul>
                        </div>
                    </div>
                    <hr class="content-divider">
                    <div class="info-part">
                        <div class="flex-1">
                            <h2>Misi</h2>
                        </div>
                        <div class="flex-3">
                            <ol type="a">
                                <li>Menciptakan anak berpengetahuan dan terampil</li>
                                <li>Unggul dalam bidang keagamaan dan sosial</li>
                                <li>Menjadikan sekolah tempat yang aman dan nyaman bagi anak</li>
                                <li>Cakep membudayakan 5S (Salam, Senyum, Sapa, Santun, dan Sopan)</li>
                                <li>Lingkungan yang Asri</li>
                                <li>Menciptakan generasi yang kreatif dan berprestasi</li>
                            </ol>
                        </div>
                    </div>
                    <hr class="content-divider">
                    <div class="info-part">
                        <div class="flex-1">
                            <h2>Karakteristik Kurikulum</h2>
                        </div>
                        <div class="flex-3">
                            <p>
                                Kurikulum disusun dengan mengusung nilai-nilai nasionalism dan keberagaman sebagai dasar untuk pengembangan karakter Taman Kanak-Kanak.
                                Selain itu, karakter pantang menyerah, toleransi dan percaya diri juga terus dilakukan melalui pembiasaaan rutin yang diterapkan selama anak
                                berada di satuan PAUD Taman Kanak-Kanak Negeri Pembina Sungai Kakap.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="section-gallery" class="home-section">
        <div class="container">
            <h2 class="margin-vertical">Galeri Kegiatan</h2>
            {{-- refer to lightbox.js --}}
            <div class="scrollable gallery-main">
                {{-- .gallery-item for styling, .gallery-lightbox for js hook --}}
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Al_Fityan.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Al_Fityan.jpg') }}" alt="Foto kegiatan di Al-Fityan Islamic Student Competition 3">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Al_Fityan_2.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Al_Fityan_2.jpg') }}" alt="Foto kegiatan di Al-Fityan Islamic Student Competition 3">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Creativity.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Creativity.jpg') }}" alt="Foto kegiatan pembelajaran prakarya di TK">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Daily.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Daily.jpg') }}" alt="Foto kegiatan pembelajaran bercerita di TK">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Daily_2.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Daily_2.jpg') }}" alt="Foto kegiatan bercerita di TK">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Daily_2.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Manasik_Haji.jpg') }}" alt="Foto kegiatan Manasik Haji">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('static/Filler-Porseni.jpg') }}" class="gallery-lightbox">
                        <img src="{{ asset('static/Filler-Porseni.jpg') }}" alt="Foto kegiatan PORSENI (Pekan Olahraga dan Seni)">
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.home-layout>
