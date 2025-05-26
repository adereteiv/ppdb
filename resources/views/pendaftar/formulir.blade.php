<x-layouts.app-layout>

<div id="pendaftar-formulir" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Formulir Pendaftaran</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding content-padding-side-rem">
            <div class="content-padding-side-rem">
                <x-flash-message flash='blue'>
                    <h6>Petunjuk Pengisian!</h6>
                    <ul>
                        <li>Silakan isi Data Anak terlebih dahulu sebelum mengisi data Orang Tua (Ayah & Ibu) / Wali.</li>
                        <li>Isilah formulir secara lengkap dan jelas sesuai kebenaran yang ada.</li>
                        <li>Kolom isian dengan tajuk berbintang <span style="color:#FF0000;">*</span> wajib diisi.</li>
                    </ul>
                </x-flash-message>
            </div>
            <form id="mainForm" method="POST" action="{{ route('pendaftar.formulir') }}">@csrf @method('PUT')
                <div class="biodata flex gap">
                    <div class="flex-1 content-padding-side-rem">
                        <div class="flex flex-col">
                            <div>
                                <h6>Data Anak</h6>
                                <table>
                                    <div class="flex">
                                        <tr><td>Nama<sup style="color:#FF0000;">*</sup><x-input type="text" name="nama_anak" class="form-item" :value="old('nama_anak', $infoAnak->nama_anak ?? '')" placeholder="Nama Anak"/></td></tr>
                                        <tr><td>Nama Panggilan<sup style="color:#FF0000;">*</sup><x-input type="text" name="panggilan_anak" class="form-item" :value="old('panggilan_anak', $infoAnak->panggilan_anak ?? '')" placeholder="Nama Panggilan Anak"/></td></tr>
                                        <tr><td>Tempat Lahir<sup style="color:#FF0000;">*</sup><x-input type="text" name="tempat_lahir" class="form-item" :value="old('tempat_lahir', $infoAnak->tempat_lahir ?? '')" placeholder="Tempat Lahir Anak"/></td></tr>
                                        <tr><td>Tanggal Lahir<sup style="color:#FF0000;">*</sup><x-input type="date" name="tanggal_lahir" class="form-item" :value="old('tanggal_lahir', $infoAnak->tanggal_lahir ?? '')"/></td></tr>
                                        <tr><td>Jarak Tempuh (km)<sup style="color:#FF0000;">*</sup><x-input type="number" name="jarak_tempuh" class="form-item" :value="old('jarak_tempuh', $infoAnak->jarak_tempuh ?? '')"/></td></tr>
                                        <tr><td>Alamat<sup style="color:#FF0000;">*</sup><x-input-textarea type="text" name="alamat_anak" rows="3" cols="23" :value="old('alamat_anak', $infoAnak->alamat_anak ?? '')" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td>Jenis Kelamin<sup style="color:#FF0000;">*</sup><x-input-radio id="jk" name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" :value="$infoAnak->jenis_kelamin ?? '' "/></td></tr>
                                        <tr><td>Kewarganegaraan<sup style="color:#FF0000;">*</sup><x-input-radio id="kwn" name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" :value="$infoAnak->kewarganegaraan ?? '' "/></td></tr>
                                        <tr><td>Bahasa di Rumah<sup style="color:#FF0000;">*</sup><x-input-select name="bahasa_di_rumah" class="form-item" :options="config('form-options.bahasa_di_rumah')" :value="$infoAnak->bahasa_di_rumah ?? '' "/></td></tr>
                                        <tr><td>Agama<sup style="color:#FF0000;">*</sup><x-input-select name="agama" class="form-item" :options="config('form-options.agama')" :value="$infoAnak->agama ?? '' "/></td></tr>
                                        <tr><td>Status Tinggal<sup style="color:#FF0000;">*</sup><x-input-select name="status_tinggal" class="form-item" :options="config('form-options.status_tinggal')" :value="$infoAnak->status_tinggal ?? '' "/></td></tr>
                                        <tr><td>Yang Mendaftarkan<sup style="color:#FF0000;">*</sup><x-input-radio id="yang_mendaftarkan" name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" :value="$infoAnak->yang_mendaftarkan ?? '' "/></td></tr>
                                        <tr><td>Status Anak (dari yang mendaftarkan)<sup style="color:#FF0000;">*</sup><x-input-select name="status_anak" :options="config('form-options.status_anak')" :value="$infoAnak->status_anak ?? '' " class="form-item"/></td></tr>
                                        <tr><td>Anak Ke-<sup style="color:#FF0000;">*</sup><x-input type="number" name="anak_ke" class="form-item" min="1" :value="old('anak_ke', $infoAnak->anak_ke ?? '')"/></td></tr>
                                        <tr><td>Saudara Kandung<x-input type="number" name="saudara_kandung" class="form-item" min="0" :value="old('saudara_kandung', $infoAnak->saudara_kandung ?? '')"/></td></tr>
                                        <tr><td>Saudara Tiri<x-input type="number" name="saudara_tiri" class="form-item" min="0" :value="old('saudara_tiri', $infoAnak->saudara_tiri ?? '')"/></td></tr>
                                        <tr><td>Saudara Angkat<x-input type="number" name="saudara_angkat" class="form-item" min="0" :value="old('saudara_angkat', $infoAnak->saudara_angkat ?? '')"/></td></tr>
                                        <tr><td>Berat Badan (kg)<sup style="color:#FF0000;">*</sup><x-input type="number" name="berat_badan" class="form-item" :value="old('berat_badan', $infoAnak->berat_badan ?? '')"/></td></tr>
                                        <tr><td>Tinggi Badan (cm)<sup style="color:#FF0000;">*</sup><x-input type="number" name="tinggi_badan" class="form-item" :value="old('tinggi_badan', $infoAnak->tinggi_badan ?? '')"/></td></tr>
                                        <tr><td>Golongan Darah<sup style="color:#FF0000;">*</sup><x-input-select name="golongan_darah" class="form-item" :options="config('form-options.golongan_darah')" :value="$infoAnak->golongan_darah ?? '' "/></td></tr>
                                        <tr><td>Ukuran Baju<sup style="color:#FF0000;">*</sup><x-input-select name="ukuran_baju" class="form-item" :options="config('form-options.ukuran_baju')" :value="$infoAnak->ukuran_baju ?? '' "/></td></tr>
                                        <tr><td>Riwayat Penyakit<x-input-textarea type="text" name="riwayat_penyakit" class="form-item" rows="3" cols="23" :value="old('riwayat_penyakit', $infoAnak->riwayat_penyakit ?? '')" placeholder="Silakan diisi bila ada"/></td></tr>
                                        <tr><td>Mendaftar Sebagai<sup style="color:#FF0000;">*</sup><x-input-radio id="mendaftar_sebagai" name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" :value="$infoAnak->mendaftar_sebagai ?? '' "/></td></tr>
                                        {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                        <tbody id="pindahanBit" style="display:none;">
                                            <tr><td>Sekolah Lama<sup style="color:#FF0000;">*</sup><x-input class="form-item pindahan-input" type="text" name="sekolah_lama" :value="old('sekolah_lama', $infoAnak->sekolah_lama ?? '')"/></td></tr>
                                            <tr><td>Tanggal Pindah<sup style="color:#FF0000;">*</sup><x-input class="form-item pindahan-input" type="date" name="tanggal_pindah" :value="old('tanggal_pindah', $infoAnak->tanggal_pindah ?? '')"/></td></tr>
                                            <tr><td>Dari Kelompok<sup style="color:#FF0000;">*</sup><x-input-select class="form-item pindahan-input" name="dari_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->dari_kelompok ?? '' "/></td></tr>
                                            <tr><td>Ke Kelompok<sup style="color:#FF0000;">*</sup><x-input-select class="form-item pindahan-input" name="ke_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->ke_kelompok ?? '' "/></td></tr>
                                        </tbody>
                                        {{-- until here --}}
                                    </div>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 content-padding-side-rem">
                        <div class="flex flex-col gap-rem">
                            <div id="dataAyah">
                                <h6>Data Ayah</h6>
                                <table>
                                    <tr><td><label for="nama_ayah">Nama</label><x-input id="nama_ayah" type="text" name="nama_ayah" class="form-item ayah-input" :value="old('nama_ayah', $ayah->nama ?? '')"/></td></tr>
                                    <tr><td><label for="pendidikan_ayah">Pendidikan</label><x-input-select id="pendidikan_ayah" name="pendidikan_ayah" class="form-item ayah-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ayah',$ayah->pendidikan ?? '' )"/></td></tr>
                                    <tr><td><label for="pekerjaan_ayah">Pekerjaan</label><x-input-select id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-item ayah-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ayah',$ayah->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td><label for="penghasilan_ayah">Penghasilan</label><x-input-select id="penghasilan_ayah" name="penghasilan_ayah" class="form-item ayah-input" :options="config('form-options.penghasilan')" :value="old('penghasilan_ayah',$ayah->penghasilan ?? '' )"/></td></tr>
                                    <tr><td><label for="alamat_ayah">Alamat</label><x-input-textarea id="alamat_ayah" name="alamat_ayah" class="form-item ayah-input" rows="3" cols="23" :value="old('alamat_ayah',$ayah->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td><label for="nomor_hp_ayah">Nomor HP</label><x-input type="tel" placeholder="Format: +62XXXXXXXXXX atau 08XXXXXXXXX" id="nomor_hp_ayah" name="nomor_hp_ayah" class="form-item ayah-input" :value="old('nomor_hp_ayah',$ayah->nomor_hp ?? '' )"/></td></tr>
                                </table>
                            </div>
                            <div id="dataIbu">
                                <h6>Data Ibu</h6>
                                <table>
                                    <tr><td><label for="nama_ibu">Nama</label><x-input id="nama_ibu" name="nama_ibu" class="form-item ibu-input" type="text" :value="old('nama_ibu',$ibu->nama ?? '' )"/></td></tr>
                                    <tr><td><label for="pendidikan_ibu">Pendidikan</label><x-input-select id="pendidikan_ibu" name="pendidikan_ibu" class="form-item ibu-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ibu',$ibu->pendidikan ?? '' )"/></td></tr>
                                    <tr><td><label for="pekerjaan_ibu">Pekerjaan</label><x-input-select id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-item ibu-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ibu',$ibu->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td><label for="penghasilan_ibu">Penghasilan</label><x-input-select id="penghasilan_ibu" name="penghasilan_ibu" class="form-item ibu-input" :options="config('form-options.penghasilan')" :value="old('penghasilan_ibu',$ibu->penghasilan ?? '' )"/></td></tr>
                                    <tr><td><label for="alamat_ibu">Alamat</label><x-input-textarea id="alamat_ibu" name="alamat_ibu" class="form-item ibu-input" rows="3" cols="23" :value="old('alamat_ibu',$ibu->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td><label for="nomor_hp_ibu">Nomor HP</label><x-input type="tel" placeholder="Format: +62XXXXXXXXXX atau 08XXXXXXXXX" id="nomor_hp_ibu" name="nomor_hp_ibu" class="form-item ibu-input" :value="old('nomor_hp_ibu',$ibu->nomor_hp ?? '' )"/></td></tr>
                                </table>
                            </div>
                            <div id="dataWali">
                                <h6>Data Wali</h6>
                                <table>
                                    <tr><td><label for="nama_wali">Nama</label><x-input id="nama_wali" class="form-item wali-input" type="text" name="nama_wali" :value="old('nama_wali',$wali->nama ?? '' )"/></td></tr>
                                    <tr><td><label for="pendidikan_wali">Pendidikan</label><x-input-select id="pendidikan_wali" class="form-item wali-input" name="pendidikan_wali" :options="config('form-options.pendidikan')" :value="old('pendidikan_wali',$wali->pendidikan ?? '' )"/></td></tr>
                                    <tr><td><label for="pekerjaan_wali">Pekerjaan</label><x-input-select id="pekerjaan_wali" class="form-item wali-input" name="pekerjaan_wali" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_wali',$wali->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td><label for="penghasilan_wali">Penghasilan</label><x-input-select id="penghasilan_wali" class="form-item wali-input" name="penghasilan_wali" :options="config('form-options.penghasilan')" :value="old('penghasilan_wali',$wali->penghasilan ?? '' )"/></td></tr>
                                    <tr><td><label for="alamat_wali">Alamat</label><x-input-textarea id="alamat_wali" class="form-item wali-input" name="alamat_wali" rows="3" cols="23" :value="old('alamat_wali',$wali->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td><label for="nomor_hp_wali">Nomor HP</label><x-input type="tel" placeholder="Format: +62XXXXXXXXXX atau 08XXXXXXXXX" id="nomor_hp_wali" class="form-item wali-input" name="nomor_hp_wali" :value="old('nomor_hp_wali',$wali->nomor_hp ?? '' )"/></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-vertical text-align-center content-padding-vertical">
                    <input type="submit" class="tombol-besar tombol-netral" value="Simpan"/>
                </div>
                <x-scripts.submit-button form="mainForm"/>
            </form>
        </div>
    </div>
</div>

</x-layouts.app-layout>
