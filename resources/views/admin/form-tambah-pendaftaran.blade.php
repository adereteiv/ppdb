<x-layouts.app-layout>
<div id="pendaftar-formulir" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title class="justify-between">
            <x-slot:backLink>{{ route('admin.ppdb.aktif.index') }}</x-slot:backLink>
            <x-slot:title><h6>Tambah Pendaftaran</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding-side-rem content-padding-bottom-rem">
            <div class="constrict">
                <x-flash-message flash='blue' button>Untuk menambahkan rekam pendaftaran secara manual, silakan mengisi data dengan lengkap.</x-flash-message>
                <form method="POST" action="{{ route('admin.ppdb.aktif.store') }}" enctype="multipart/form-data">@csrf
                    <div class="biodata scrollable">
                        <div>{{-- Form User --}}
                            <div class="content-padding-side-rem">
                                <h6 class="padding-10">Data Pendaftar</h6>
                            </div>
                            <div class="frame content-padding-rem">
                                <div class="padding-10">
                                    <b>Data Pengguna</b>
                                    <table>
                                        <tr><td width="180px">E-mail Orang Tua/Wali
                                            <td><x-input type="email" name="email" placeholder="Masukkan email orang tua"/>
                                        </td></tr>
                                        <tr><td>Nomor HP/WA<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="tel" name="nomor_hp" placeholder="Nomor HP yang bisa dihubungi"/>
                                        </td></tr>
                                        <tr><td>Masukkan Kata Sandi<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="password" name="password" placeholder="Kata sandi, min. 8 karakter"/>
                                        </td></tr>
                                        <tr><td>Konfirmasi Kata Sandi<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="password" name="password_confirmation" placeholder="Masukkan ulang kata sandi"/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10">
                                    <b>Data Anak</b>
                                    <table>
                                        <tr><td width="180px">Nama<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="text" name="nama_anak" placeholder="Nama Anak"/></td></tr>
                                        <tr><td>Nama Panggilan<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="text" name="panggilan_anak" placeholder="Nama Panggilan Anak"/></td></tr>
                                        <tr><td>Tempat Lahir<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="text" name="tempat_lahir" placeholder="Tempat Lahir Anak"/></td></tr>
                                        <tr><td>Tanggal Lahir<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="date" name="tanggal_lahir"/></td></tr>
                                        <tr><td>Jarak Tempuh<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="number" name="jarak_tempuh" min="1"/></td></tr>
                                        <tr><td>Alamat<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-textarea name="alamat_anak" rows="3" cols="23" placeholder="Silakan tulis alamat disini"/>
                                            </td></tr>
                                        <tr><td>Jenis Kelamin<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-radio id="jenis_kelamin" name="jenis_kelamin" :options="config('form-options.jenis_kelamin')"/></td></tr>
                                        <tr><td>Kewarganegaraan<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-radio id="kewarganegaraan" name="kewarganegaraan" :options="config('form-options.kewarganegaraan')"/></td></tr>
                                        <tr><td>Bahasa di Rumah<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="bahasa_di_rumah" :options="config('form-options.bahasa_di_rumah')"/></td></tr>
                                        <tr><td>Agama<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="agama" :options="config('form-options.agama')"/></td></tr>
                                        <tr><td>Status Tinggal<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="status_tinggal" :options="config('form-options.status_tinggal')"/></td></tr>
                                        <tr><td>Yang Mendaftarkan<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-radio id="yang_mendaftarkan" name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')"/></td></tr>
                                        <tr><td>Status Anak<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="status_anak" :options="config('form-options.status_anak')"/></td></tr>
                                        <tr><td>Anak Ke-<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="number" name="anak_ke" min="1"/></td></tr>
                                        <tr><td>Saudara Kandung</td>
                                            <td><x-input type="number" name="saudara_kandung" min="0"/></tr>
                                        <tr><td>Saudara Tiri</td>
                                            <td><x-input type="number" name="saudara_tiri" min="0"/></tr>
                                        <tr><td>Saudara Angkat</td>
                                            <td><x-input type="number" name="saudara_angkat" min="0"/></tr>
                                        <tr><td>Berat Badan (kg)<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="number" name="berat_badan"/></td></tr>
                                        <tr><td>Tinggi Badan (cm)<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input type="number" name="tinggi_badan"/></td></tr>
                                        <tr><td>Ukuran Baju<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="ukuran_baju" :options="config('form-options.ukuran_baju')"/></td></tr>
                                        <tr><td>Golongan Darah<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" name="golongan_darah" :options="config('form-options.golongan_darah')"/></td></tr>
                                        <tr><td>Riwayat Penyakit</td>
                                            <td><x-input-textarea name="riwayat_penyakit" rows="3" cols="23" placeholder="Silakan diisi bila ada" /></td></tr>
                                        <tr><td>Mendaftar Sebagai<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-radio id="mendaftar_sebagai" name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')"/></td></tr>
                                        {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                        <tbody id="pindahanBit" style="display:none;">
                                        <tr><td>Sekolah Lama<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input class="pindahan-input" type="text" name="sekolah_lama"/></tr>
                                        <tr><td>Tanggal Pindah<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input class="pindahan-input" type="date" name="tanggal_pindah"/></tr>
                                        <tr><td>Dari Kelompok<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" class="pindahan-input" name="dari_kelompok" :options="config('form-options.kelompok_umur')"/></tr>
                                        {{-- <tr><td>Tanggal Diterima</td>
                                            <td><x-input class="pindahan-input" type="date" name="tanggal_diterima"/></tr> --}}
                                        <tr><td>Ke Kelompok<sup style="color:#FF0000;">*</sup></td>
                                            <td><x-input-select class="form-item" class="pindahan-input" name="ke_kelompok" :options="config('form-options.kelompok_umur')"/></tr>
                                        </tbody>
                                        {{-- until here --}}
                                    </table>
                                </div>
                                <div class="padding-10" id="dataAyah">
                                    <b>Data Ayah</b>
                                    <table>
                                        <tr><td width="180px"><label for="nama_ayah">Nama</label></td>
                                            <td><x-input id="nama_ayah" type="text" name="nama_ayah" class="ayah-input"/></tr>
                                        <tr><td><label for="pendidikan_ayah">Pendidikan</label></td>
                                            <td><x-input-select id="pendidikan_ayah" name="pendidikan_ayah" class="ayah-input form-item" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td><label for="pekerjaan_ayah">Pekerjaan</label></td>
                                            <td><x-input-select id="pekerjaan_ayah" name="pekerjaan_ayah" class="ayah-input form-item" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td><label for="penghasilan_ayah">Penghasilan</label></td>
                                            <td><x-input-select id="penghasilan_ayah" name="penghasilan_ayah" class="ayah-input form-item" :options="config('form-options.penghasilan')"/></td></tr>
                                        <tr><td><label for="alamat_ayah">Alamat</label></td>
                                            <td><x-input-textarea id="alamat_ayah" name="alamat_ayah" class="ayah-input" rows="3" cols="23" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td><label for="nomor_hp_ayah">Nomor HP</label></td>
                                            <td><x-input type="tel" id="nomor_hp_ayah" name="nomor_hp_ayah" class="ayah-input"/>
                                            </td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataIbu">
                                    <b>Data Ibu</b>
                                    <table>
                                        <tr><td width="180px"><label for="nama_ibu">Nama</label></td>
                                            <td><x-input type="text" id="nama_ibu" name="nama_ibu" class="ibu-input"/></td></tr>
                                        <tr><td><label for="pendidikan_ibu">Pendidikan</label></td>
                                            <td><x-input-select id="pendidikan_ibu" name="pendidikan_ibu" class="ibu-input form-item" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td><label for="pekerjaan_ibu">Pekerjaan</label></td>
                                            <td><x-input-select id="pekerjaan_ibu" name="pekerjaan_ibu" class="ibu-input form-item" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td><label for="penghasilan_ibu">Penghasilan</label></td>
                                            <td><x-input-select id="penghasilan_ibu" name="penghasilan_ibu" class="ibu-input form-item" :options="config('form-options.penghasilan')"/></td></tr>
                                        <tr><td><label for="alamat_ibu">Alamat</label></td>
                                            <td><x-input-textarea id="alamat_ibu" name="alamat_ibu" class="ibu-input" rows="3" cols="23" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td><label for="nomor_hp_ibu">Nomor HP</label></td>
                                            <td><x-input type="tel" id="nomor_hp_ibu" name="nomor_hp_ibu" class="ibu-input"/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataWali">
                                    <b>Data Wali</b>
                                    <table>
                                        <tr><td width="180px"><label for="nama_wali">Nama</label></td>
                                            <td><x-input type="text" id="nama_wali" name="nama_wali" class="wali-input"/></td></tr>
                                        <tr><td><label for="pendidikan_wali">Pendidikan</label></td>
                                            <td><x-input-select id="pendidikan_wali" name="pendidikan_wali" class="wali-input form-item" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td><label for="pekerjaan_wali">Pekerjaan</label></td>
                                            <td><x-input-select id="pekerjaan_wali" name="pekerjaan_wali" class="wali-input form-item" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td><label for="penghasilan_wali">Penghasilan</label></td>
                                            <td><x-input-select id="penghasilan_wali" name="penghasilan_wali" class="wali-input form-item" :options="config('form-options.penghasilan')"/></td></tr>
                                        <tr><td><label for="alamat_wali">Alamat</label></td>
                                            <td><x-input-textarea id="alamat_wali" name="alamat_wali" rows="3" cols="23" placeholder="Silakan tulis alamat disini" class="wali-input"/></td></tr>
                                        <tr><td><label for="nomor_hp_wali">Nomor HP</label></td>
                                            <td><x-input type="tel" id="nomor_hp_wali" name="nomor_hp_wali" class="wali-input"/></td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>{{-- Form Dokumen --}}
                            <div class="content-padding-side-rem">
                                <h6 class="padding-10">Dokumen Persyaratan</h6>
                            </div>
                            <div class="frame content-padding-rem">
                                @foreach ($syaratDokumen as $syarat)
                                    <x-inputbox-file
                                        :label="$syarat->tipeDokumen->tipe"
                                        :isWajib="$syarat->is_wajib"
                                        keterangan="{{ $syarat->keterangan }}"
                                        fileType="dokumen"
                                    />
                                @endforeach
                            </div>
                        </div>
                        <div>{{-- Form Bukti Bayar --}}
                            <div class="content-padding-side-rem">
                                <h6 class="padding-10">Bukti Pembayaran</h6>
                            </div>
                            <div class="frame content-padding-rem">
                                <x-inputbox-file
                                    label="Bukti Bayar"
                                    isWajib="true"
                                    fileType="pelengkap"
                                    keterangan="Unggah bukti pembayaran Anda disini"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="margin-vertical text-align-center">
                        <input type="submit" class="tombol-besar tombol-netral" value="Simpan"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
