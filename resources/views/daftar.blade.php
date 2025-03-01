<x-layouts.home-layout :hideFooter='false'>

@if(session()->has('error'))
<x-flash-message class="alert" flash>{{ session('error') }}</x-flash-message>
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
                            <h5 class="margin-bottom teks-putih">Ketentuan!</h5>
                            <p class="teks-putih">Isi Data Secara Lengkap dan Jelas Sesuai dengan Data Yang Tertera Di KARTU KELUARGA/AKTA KELAHIRAN</p>
                        </div>
                    </article>
                    <form method="post" action="daftar">@csrf
                        <article class="content-margin-bottom">
                            <header><h3>Registrasi Akun</h3></header>
                            <table>
                                <tr>
                                    <td width="20%">Alamat e-mail Orang Tua/Wali</td>
                                    <td>
                                        <x-input type="email" name="email" style="width:385px;" placeholder="Masukkan email orang tua" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Masukkan Kata Sandi</td>
                                    <td>
                                        <x-input type="password" name="password" style="width:385px;" minlength="8" placeholder="Kata sandi, min. 8 karakter" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Konfirmasi Kata Sandi</td>
                                    <td>
                                        <x-input type="password" name="password_confirmation" style="width:385px;" minlength="8" placeholder="Masukkan ulang kata sandi" required/>
                                    </td>
                                </tr>
                            </table>
                        </article>
                        <hr>
                        <article class="content-margin-bottom">
                            <header><h3>Keterangan Anak</h3></header>
                            <div>
                                <table>
                                    <tr><td width="20%">Nama Lengkap</td>
                                        <td>
                                            <x-input type="text" name="nama_anak" style="width:385px;" placeholder="Nama lengkap anak" required/>
                                            @if(session('akunAda'))
                                                <br><p style="color: red">{{ session('akunAda') }}</p>
                                            @endif
                                        </td>
                                        </tr>
                                    <tr><td>Nama Panggilan</td>
                                        <td><x-input type="text" name="panggilan_anak" style="width:385px;" placeholder="Nama panggilan anak" required/></td>
                                    </tr>
                                    <tr><td>Tempat Lahir </td>
                                        <td><x-input type="text" name="tempat_lahir" style="width:385px;" placeholder="Tempat kelahiran anak" required/></td>
                                    </tr>
                                    <tr><td>Tanggal Lahir</td>
                                        <td>
                                            <x-input style="width:385px;" type="date" name="tanggal_lahir" required/>
                                        </td>
                                    </tr>
                                    <tr><td>Alamat</td>
                                        <td colspan="3"><x-input-textarea style="width:385px;" rows="4" type="text" name="alamat_anak" placeholder="Tempat Tinggal Anak" required></x-input-textarea></td>
                                    </tr>
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
