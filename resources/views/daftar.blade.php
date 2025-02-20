<x-layouts.home-layout :hideFooter='true'>
@if(session('email'))
    <script>
        alert(@json(session('email')));
    </script>
@endif

<section id="section-daftar" class="home-section">
    <div class="container">
        <div>
            <div class="text-align-center margin-vertical">
                <h1>Pendaftaran</h1>
            </div>
            <div class="form-daftar">
                @if($batchClosed)
                    <div class="text-align-center margin-vertical">
                        <h5>PPDB tidak dibuka saat ini</h5>
                    </div>
                @else
                    <article class="content-margin-bottom">
                        <div class="reminder bg-red">
                            <h5 class="margin-bottom">Ketentuan!</h5>
                            <p>Isi Data Secara Lengkap dan Jelas Sesuai dengan Data Yang Tertera Di KARTU KELUARGA/AKTA KELAHIRAN</p>
                        </div>
                    </article>
                    <form method="post" action="daftar">@csrf
                        <article class="content-margin-bottom">
                            <header><h3>Registrasi Akun</h3></header>
                            <table>
                                <tr>
                                    <td width="20%">Alamat e-mail Orang Tua/Wali</td>
                                    <td>
                                        <input name="email" type="email" class="form-item" style="width:385px;" required placeholder="Masukkan email Orang Tua">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Masukkan Kata Sandi</td>
                                    <td><input name="password" type="password" class="form-item" minlength="8" style="width:385px;" placeholder="Kata Sandi, min. 8 karakter" required></td>
                                </tr>
                                <tr>
                                    <td>Konfirmasi Kata Sandi</td>
                                    <td><input name="password2" type="password" class="form-item" minlength="8" style="width:385px;" placeholder="Masukkan ulang kata sandi" required></td>
                                </tr>
                            </table>
                        </article>
                        <hr>
                        <article class="content-margin-bottom">
                            <header><h3>Keterangan Anak</h3></header>
                            <div>
                                <table>
                                    <tr><td width="20%">Nama Lengkap</td>
                                        <td><input class="form-item" type="text" name="nama_anak" id="nama_anak" style="width:385px;" placeholder="Nama Lengkap Anak" required value="{{ old('nama_anak') }}"></td><td align="right"></td></tr>
                                    <tr><td>Nama Panggilan</td>
                                        <td><input class="form-item" type="text" name="panggilan_anak" id="panggilan_anak" style="width:385px;" placeholder="Nama Panggilan Anak" required value="{{ old('panggilan_anak') }}"></td><td align="right"></td></tr>
                                    <tr><td>Tempat Lahir </td>
                                        <td><input class="form-item" type="text" name="tempat_lahir" id="tempat_lahir" style="width:385px;" required placeholder="Tempat Kelahiran Anak" value="{{ old('tempat_lahir') }}"></td></tr>
                                    <tr><td>Tanggal Lahir</td>
                                        <td><input class="form-item" style="width:385px;" type="date" x-data="{today: new Date().toISOString().split('T')[0],maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 3)).toISOString().split('T')[0]}" x-bind:max="maxDate" x-bind:min="'1900-01-01'" name="tanggal_lahir" id="tanggal_lahir" required></td>
                                    </tr>
                                    <tr><td>Alamat</td>
                                        <td colspan="3"><textarea class="form-item" style="width:385px;" rows="4" type="text" name="alamat_anak" id="alamat_anak" placeholder="Tempat Tinggal Anak" required></textarea></td></tr>
                                </table>
                            </div>
                        </article>
                        <hr>
                        <article class="content-margin-bottom">
                            <header><h3>Konfirmasi Data Pendaftar</h3></header>
                            <div class="flex align-items-center">
                                <p class="flex-1">Dengan ini saya menyatakan bahwa data yang saya berikan di formulir ini adalah benar adanya sesuai dengan bukti-bukti yang ada</p>
                                <button type="submit" class="tombol-besar tombol-netral">DAFTAR</button>
                            </div>
                        </article>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
</x-layouts.home-layout>
