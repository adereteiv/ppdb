<x-layouts.app-layout>

<div id="pendaftar-formulir" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title class="justify-between">
            <x-slot:backLink>/admin/ppdb/aktif</x-slot:backLink>
            <x-slot:title><h6>Tambah Pendaftaran</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding-side-rem content-padding-bottom-rem">
            <div class="constrict">
                <form method="POST" action="{{ route('ppdb.aktif.store') }}" enctype="multipart/form-data">@csrf
                    <div class="biodata scrollable">
                        {{-- Form User --}}
                        <div>
                            <div class="content-padding-side-rem">
                                <h6 class="padding-10">Data Pendaftar</h6>
                            </div>
                            <div class="frame content-padding-rem">
                                <div class="padding-10">
                                    <b>Data Pengguna</b>
                                    <table>
                                        <tr><td width="180px">E-mail Orang Tua/Wali</td>
                                            <td><x-input type="email" name="email" placeholder="Masukkan email orang tua" required/>
                                        </td></tr>
                                        <tr><td>Masukkan Kata Sandi</td>
                                            <td><x-input type="password" name="password" minlength="8" placeholder="Kata sandi, min. 8 karakter" required/>
                                        </td></tr>
                                        <tr><td>Konfirmasi Kata Sandi</td>
                                            <td><x-input type="password" name="password_confirmation" minlength="8" placeholder="Masukkan ulang kata sandi" required/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10">
                                    <b>Data Anak</b>
                                    <table>
                                        <tr><td width="180px">Nama</td>
                                            <td><x-input type="text" name="nama_anak" placeholder="Nama Anak" required/></td></tr>
                                        <tr><td>Nama Panggilan</td>
                                            <td><x-input type="text" name="panggilan_anak" placeholder="Nama Panggilan Anak" required/></td></tr>
                                        <tr><td>Tempat Lahir</td>
                                            <td><x-input type="text" name="tempat_lahir" placeholder="Tempat Lahir Anak" required/></td></tr>
                                        <tr><td>Tanggal Lahir</td>
                                            <td><x-input type="date" name="tanggal_lahir" required/></td></tr>
                                        <tr><td>Alamat</td>
                                            <td><x-input-textarea name="alamat_anak" rows="3" cols="23" placeholder="Silakan tulis alamat disini" required/>
                                            </td></tr>
                                        <tr><td>Jenis Kelamin</td>
                                            <td><x-input-radio name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" required/></td></tr>
                                        <tr><td>Kewarganegaraan</td>
                                            <td><x-input-radio name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" required/></td></tr>
                                        <tr><td>Bahasa di Rumah</td>
                                            <td><x-input-select class="form-item" name="bahasa_di_rumah" :options="config('form-options.bahasa_di_rumah')" required/></td></tr>
                                        <tr><td>Agama</td>
                                            <td><x-input-select class="form-item" name="agama" :options="config('form-options.agama')" required/></td></tr>
                                        <tr><td>Status Tinggal</td>
                                            <td><x-input-select class="form-item" name="status_tinggal" :options="config('form-options.status_tinggal')" required/></td></tr>
                                        <tr><td>Yang Mendaftarkan</td>
                                            <td><x-input-radio name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" required/></td></tr>
                                        <tr><td>Status Anak</td>
                                            <td><x-input-select class="form-item" name="status_anak" :options="config('form-options.status_anak')" required/></td></tr>
                                        <tr><td>Anak Ke-</td>
                                            <td><x-input type="number" name="anak_ke" min="1" required/></td></tr>
                                        <tr><td>Saudara Kandung</td>
                                            <td><x-input type="number" name="saudara_kandung" min="0"/></tr>
                                        <tr><td>Saudara Tiri</td>
                                            <td><x-input type="number" name="saudara_tiri" min="0"/></tr>
                                        <tr><td>Saudara Angkat</td>
                                            <td><x-input type="number" name="saudara_angkat" min="0"/></tr>
                                        <tr><td>Berat Badan (kg)</td>
                                            <td><x-input type="number" name="berat_badan" required/></td></tr>
                                        <tr><td>Tinggi Badan (cm)</td>
                                            <td><x-input type="number" name="tinggi_badan" required/></td></tr>
                                        <tr><td>Golongan Darah</td>
                                            <td><x-input-select class="form-item" name="golongan_darah" :options="config('form-options.golongan_darah')" required/></td></tr>
                                        <tr><td>Riwayat Penyakit</td>
                                            <td><x-input-textarea name="riwayat_penyakit" rows="3" cols="23" placeholder="Silakan diisi bila ada" /></td></tr>
                                        <tr><td>Mendaftar Sebagai</td>
                                            <td><x-input-radio name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" required/></td></tr>
                                        {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                        <tbody id="pindahanBit" style="display:none;">
                                        <tr><td>Sekolah Lama</td>
                                            <td><x-input class="pindahan-input" type="text" name="sekolah_lama" required/></tr>
                                        <tr><td>Tanggal Pindah</td>
                                            <td><x-input class="pindahan-input" type="date" name="tanggal_pindah" required/></tr>
                                        <tr><td>Dari Kelompok</td>
                                            <td><x-input-select class="form-item" class="pindahan-input" name="dari_kelompok" :options="config('form-options.kelompok_umur')" required/></tr>
                                        {{-- <tr><td>Tanggal Diterima</td>
                                            <td><x-input class="pindahan-input" type="date" name="tanggal_diterima" required/></tr> --}}
                                        <tr><td>Ke Kelompok</td>
                                            <td><x-input-select class="form-item" class="pindahan-input" name="ke_kelompok" :options="config('form-options.kelompok_umur')" required/></tr>
                                        </tbody>
                                        {{-- until here --}}
                                    </table>
                                </div>
                                <div class="padding-10" id="dataAyah">
                                    <b>Data Ayah</b>
                                    <table>
                                        <tr><td width="180px">Nama</td>
                                            <td><x-input type="text" name="nama_ayah" class="ayah-input" required/></tr>
                                        <tr><td>Pendidikan</td>
                                            <td><x-input-select class="form-item" name="pendidikan_ayah" class="ayah-input" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td>Pekerjaan</td>
                                            <td><x-input-select class="form-item" name="pekerjaan_ayah" class="ayah-input" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td>Alamat</td>
                                            <td><x-input-textarea name="alamat_ayah" class="ayah-input" rows="3" cols="23" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td>Nomor HP</td>
                                            <td><x-input type="tel" name="nomor_hp_ayah" class="ayah-input"/>
                                            </td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataIbu">
                                    <b>Data Ibu</b>
                                    <table>
                                        <tr><td width="180px">Nama</td>
                                            <td><x-input type="text" name="nama_ibu" class="ibu-input"/></td></tr>
                                        <tr><td>Pendidikan</td>
                                            <td><x-input-select class="form-item" name="pendidikan_ibu" class="ibu-input" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td>Pekerjaan</td>
                                            <td><x-input-select class="form-item" name="pekerjaan_ibu" class="ibu-input" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td>Alamat</td>
                                            <td><x-input-textarea name="alamat_ibu" class="ibu-input" rows="3" cols="23" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td>Nomor HP</td>
                                            <td><x-input type="tel" name="nomor_hp_ibu" class="ibu-input"/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataWali">
                                    <b>Data Wali</b>
                                    <table>
                                        <tr><td width="180px">Nama</td>
                                            <td><x-input type="text" name="nama_wali" class="wali-input"/></td></tr>
                                        <tr><td>Pendidikan</td>
                                            <td><x-input-select class="form-item" name="pendidikan_wali" class="wali-input" :options="config('form-options.pendidikan')"/></td></tr>
                                        <tr><td>Pekerjaan</td>
                                            <td><x-input-select class="form-item" name="pekerjaan_wali" class="wali-input" :options="config('form-options.pekerjaan')"/></td></tr>
                                        <tr><td>Alamat</td>
                                            <td><x-input-textarea name="alamat_wali" rows="3" cols="23" placeholder="Silakan tulis alamat disini" class="wali-input"/></td></tr>
                                        <tr><td>Nomor HP</td>
                                            <td><x-input type="tel" name="nomor_hp_wali" class="wali-input"/></td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Form Dokumen --}}
                        <div class="">
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

                        {{-- Form Bukti Bayar --}}
                        <div class="">
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
