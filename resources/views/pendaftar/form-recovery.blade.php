<x-layouts.app-layout>
<div class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Kelengkapan Informasi Pendaftaran</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding content-padding-side-rem">
            <div class="biodata constrict">
                <x-flash-message flash='blue'>
                    Data pendaftaran Anda tidak ditemukan.
                    Untuk melanjutkan, silakan isi data pada formulir berikut secara lengkap dan jelas sesuai kebenaran yang ada.
                    Kolom isian dengan tajuk berbintang <span style="color:#FF0000;">*</span> wajib diisi.
                </x-flash-message>
                <form method="POST" action="{{ route('pendaftar.recovery.store') }}">@csrf
                    <div class="content-margin-bottom">
                        <table>
                            <tr>
                                <td>Nama Lengkap<sup style="color:#FF0000;">*</sup>
                                    <x-input type="text" name="nama_anak" placeholder="Nama lengkap anak" required/>
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
                            <tr><td>Jarak Tempuh (km)<sup style="color:#FF0000;">*</sup>
                                    <x-input type="number" name="jarak_tempuh" placeholder="Jarak dari rumah ke sekolah" required/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Alamat<sup style="color:#FF0000;">*</sup>
                                    <x-input-textarea rows="4" type="text" name="alamat_anak" placeholder="Tempat Tinggal Anak" required></x-input-textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="margin-vertical text-align-center content-padding-vertical">
                        <input type="submit" class="tombol-besar tombol-netral" value="Simpan"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
