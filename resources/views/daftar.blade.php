<x-layouts.home-layout :hideContact='true'>
<section id="section-daftar" class="home-section">
    <div class="container">
        <div class="text-align-center margin-vertical">
            <h1>Pendaftaran</h1>
        </div>
        <div class="margin-vertical">
            @if ($batchClosed)
                <div class="text-align-center margin-vertical">
                    <h5>PPDB tidak dibuka saat ini</h5>
                </div>
            @elseif ($batchEnd)
                <div class="text-align-center margin-vertical">
                    <h5>Masa penerimaan PPDB Periode {{ $activeBatch->tahun_ajaran }} @if($activeBatch->gelombang !== 1)Gelombang {{ $activeBatch->gelombang }}@endif sudah berakhir. Pengumuman penerimaan dapat dilihat pada dashboard pendaftaran.</h5>
                </div>
            @else
                <div class="constrict">
                    <div class="content-margin-bottom">
                        @if (session()->has('error'))
                        <x-flash-message mode="flash error">
                            {{ session('error') }}
                            {{-- Live Timer - request suhu, ampun suhu --}}
                            @if(session('retryAfter'))
                                Silakan coba lagi dalam
                                <x-scripts.live-timer :expiry="session('retryAfter')"/>
                            @endif
                        </x-flash-message>
                        @endif
                        <x-flash-message icon flash='blue'>
                            <b>Perhatian!</b>
                            <br>
                            <ul>
                                <li>Penerimaan dibuka dari tanggal
                                    <strong><em>{{ $activeBatch->waktu_mulai->translatedFormat('d F Y') }}</em></strong>
                                    pukul {{ $activeBatch->waktu_mulai->translatedFormat('H:m') }}
                                    s/d
                                    <strong><em>{{ $activeBatch->waktu_tenggat->translatedFormat('d F Y') }}</em></strong>
                                    pukul {{ $activeBatch->waktu_tenggat->translatedFormat('H:m') }}.
                                </li>
                                <li>Silahkan isi data untuk mendapatkan Username dan Password.</li>
                                <li>Isilah data secara lengkap dan jelas sesuai dengan data yang tertera di Kartu Keluarga/Akta Kelahiran!</li>
                                <li>Kolom isian dengan tajuk berbintang <span style="color:#FF0000;">*</span> wajib diisi.</li>
                            </ul>
                        </x-flash-message>
                    </div>
                    <form method="POST" action="{{ route('register') }}">@csrf
                        <div class="content-margin-bottom">
                            <h3>Formulir Registrasi</h3>
                            <div class="flex">
                                <div class="flex-1">
                                    <div class="content-padding-side-rem">Nama Lengkap Anak<sup style="color:#FF0000;">*</sup>
                                        <x-input type="text" name="nama_anak"/>
                                        @if (session('akunAda'))
                                            <br><p style="color: red">{{ session('akunAda') }}</p>
                                        @endif
                                    </div>
                                    <div class="content-padding-side-rem">Tempat Lahir Anak<sup style="color:#FF0000;">*</sup>
                                        <x-input type="text" name="tempat_lahir"/>
                                    </div>
                                    <div class="content-padding-side-rem">Tanggal Lahir Anak<sup style="color:#FF0000;">*</sup>
                                        <x-input type="date" name="tanggal_lahir"/>
                                    </div>
                                    <div class="content-padding-side-rem">Jarak Tempuh (km)<sup style="color:#FF0000;">*</sup>
                                        <x-input type="number" name="jarak_tempuh" placeholder="Jarak maksimal 20km"/>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="content-padding-side-rem">Nama Panggilan Anak<sup style="color:#FF0000;">*</sup>
                                        <x-input type="text" name="panggilan_anak"/>
                                    </div>
                                    <div class="content-padding-side-rem">Alamat e-mail Orang Tua/Wali<sup style="visibility: hidden;">*</sup>
                                        <x-input type="email" name="email" placeholder="Masukkan email orang tua"/>
                                    </div>
                                    <div class="content-padding-side-rem">Nomor HP/WA<sup style="color:#FF0000;">*</sup>
                                        <x-input type="tel" name="nomor_hp" placeholder="+62XXXXX atau 08XXXX"/>
                                    </div>
                                    <div class="content-padding-side-rem">Masukkan Kata Sandi (Mohon Diingat!)<sup style="color:#FF0000;">*</sup>
                                        <x-input-password name="password" placeholder="Kata sandi, min. 8 karakter"/>
                                    </div>
                                    <div class="content-padding-side-rem">Konfirmasi Kata Sandi<sup style="color:#FF0000;">*</sup>
                                        <x-input-password name="password_confirmation" placeholder="Masukkan ulang kata sandi"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 1rem 0;">
                        <div class="content-margin-bottom">
                            <h3>Konfirmasi Data Pendaftar</h3>
                            <div class="flex align-items-center">
                                <p class="flex-1">Dengan ini saya menyatakan bahwa data yang saya berikan di formulir ini adalah benar adanya sesuai dengan bukti-bukti yang ada</p>
                                <button type="submit" class="tombol-besar tombol-netral" onclick="this.disabled=true; this.form.submit();">DAFTAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
</x-layouts.home-layout>
