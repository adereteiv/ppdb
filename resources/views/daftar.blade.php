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
                <h5>
                    Masa penerimaan PPDB Periode {{ $activeBatch->tahun_ajaran }} @if($activeBatch->gelombang !== 1)Gelombang {{ $activeBatch->gelombang }}@endif sudah berakhir. Pengumuman penerimaan dapat dilihat pada halaman beranda dashboard pendaftaran.
                </h5>
            </div>
            @else
            <div class="constrict">
                <div class="content-margin-bottom">
                    @if (session()->has('error'))
                    <x-flash-message flash="red" button>
                        {{ session('error') }}
                        {{-- Live Timer - request suhu, ampun suhu --}}
                        @if(session('retryAfter'))
                            Silakan coba lagi dalam <span id="countdown"></span>.
                            <script>
                                let seconds = {{ session('retryAfter') }};
                                const countdownElement = document.getElementById('countdown');

                                function updateTimer() {
                                    const minutes = Math.floor(seconds / 60);
                                    const secs = seconds % 60;
                                    countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                                    if (seconds > 0) {
                                        seconds--;
                                        setTimeout(updateTimer, 1000);
                                    }
                                }

                                updateTimer();
                            </script>
                        @endif
                    </x-flash-message>
                    @endif
                    <x-flash-message icon flash='blue'>
                        <b>Perhatian!</b>
                        <br>
                        <p>Penerimaan dibuka dari tanggal
                            <strong><em>{{ $activeBatch->waktu_mulai->translatedFormat('d F Y') }}</em></strong>
                            pukul {{ $activeBatch->waktu_mulai->translatedFormat('H:m') }}
                            s/d
                            <strong><em>{{ $activeBatch->waktu_tenggat->translatedFormat('d F Y') }}</em></strong>
                            pukul {{ $activeBatch->waktu_tenggat->translatedFormat('H:m') }}.
                        </p>
                        Isilah data secara lengkap dan jelas sesuai dengan data yang tertera di Kartu Keluarga/Akta Kelahiran!
                        Kolom isian dengan tajuk berbintang <span style="color:#FF0000;">*</span> wajib diisi.
                    </x-flash-message>
                </div>
                <form method="POST" action="{{ route('register') }}">@csrf
                    <div class="content-margin-bottom">
                        <h3>Registrasi Akun</h3>
                        <table>
                            <tr>
                                <td width="30%">Alamat e-mail Orang Tua/Wali<sup style="color:#FF0000;">*</sup>
                                    <x-input type="email" name="email" placeholder="Masukkan email orang tua" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor HP/WA<sup style="color:#FF0000;">*</sup>
                                    <x-input type="tel" name="nomor_hp" placeholder="Nomor HP yang bisa dihubungi" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Masukkan Kata Sandi (Mohon Diingat!)<sup style="color:#FF0000;">*</sup>
                                    <x-input type="password" name="password" placeholder="Kata sandi, min. 8 karakter" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Konfirmasi Kata Sandi<sup style="color:#FF0000;">*</sup>
                                    <x-input type="password" name="password_confirmation" placeholder="Masukkan ulang kata sandi" required/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 1rem 0;">
                    <div class="content-margin-bottom">
                        <h3>Keterangan Anak</h3>
                        <table>
                            <tr>
                                <td>Nama Lengkap<sup style="color:#FF0000;">*</sup>
                                    <x-input type="text" name="nama_anak" placeholder="Nama lengkap anak" required/>
                                    @if (session('akunAda'))
                                        <br><p style="color: red">{{ session('akunAda') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Panggilan<sup style="color:#FF0000;">*</sup>
                                    <x-input type="text" name="panggilan_anak" placeholder="Nama panggilan anak" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir<sup style="color:#FF0000;">*</sup>
                                    <x-input type="text" name="tempat_lahir" placeholder="Tempat kelahiran anak" required/>
                                </td>
                            </tr>
                            <tr><td>Tanggal Lahir<sup style="color:#FF0000;">*</sup>
                                    <x-input type="date" name="tanggal_lahir" required/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Alamat<sup style="color:#FF0000;">*</sup>
                                    <x-input-textarea rows="4" type="text" name="alamat_anak" placeholder="Tempat Tinggal Anak" required></x-input-textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 1rem 0;">
                    <div class="content-margin-bottom">
                        <h3>Konfirmasi Data Pendaftar</h3>
                        <div class="flex align-items-center">
                            <p class="flex-1">Dengan ini saya menyatakan bahwa data yang saya berikan di formulir ini adalah benar adanya sesuai dengan bukti-bukti yang ada</p>
                            <button type="submit" class="tombol-besar tombol-netral">DAFTAR</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
</x-layouts.home-layout>
