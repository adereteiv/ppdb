<x-layouts.app-layout>

@if (session()->has('success'))
<x-flash-message alert="green">{{ session('success') }}</x-flash-message>
@endif

<div id="pendaftar-formulir" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Formulir Pendaftaran</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding content-padding-side-rem">
            <form id="mainForm" method="POST" action="{{ route('pendaftar.formulir') }}">@csrf @method('PUT')
                <div class="biodata flex gap">
                    <div class="flex-1 content-padding-side-rem">
                        <div class="flex flex-col">
                            <div class="">
                                <h6 class="">Data Anak</h6>
                                <div class="">
                                    <table>
                                        <div class="flex">
                                            <tr><td>
                                                Nama
                                                <x-input type="text" name="nama_anak" class="form-item" :value="old('nama_anak', $infoAnak->nama_anak ?? '')" placeholder="Nama Anak" required/>
                                            </td></tr>
                                            <tr><td>
                                                Nama Panggilan
                                                <x-input type="text" name="panggilan_anak" class="form-item" :value="old('panggilan_anak', $infoAnak->panggilan_anak ?? '')" placeholder="Nama Panggilan Anak" required/>
                                            </td></tr>
                                            <tr><td>
                                                Tempat Lahir
                                                <x-input type="text" name="tempat_lahir" class="form-item" :value="old('tempat_lahir', $infoAnak->tempat_lahir ?? '')" placeholder="Tempat Lahir Anak" required/>
                                            </td></tr>
                                            <tr><td>
                                                Tanggal Lahir
                                                <x-input type="date" name="tanggal_lahir" class="form-item" :value="old('tanggal_lahir', $infoAnak->tanggal_lahir ?? '')" required/>
                                            </td></tr>
                                            <tr><td>
                                                Alamat
                                                <x-input-textarea type="text" name="alamat_anak" rows="3" cols="23" :value="old('alamat_anak', $infoAnak->alamat_anak ?? '')" placeholder="Silakan tulis alamat disini" required/>
                                            </td></tr>
                                            <tr><td>
                                                Jenis Kelamin
                                                <x-input-radio name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" :value="$infoAnak->jenis_kelamin ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Kewarganegaraan
                                                <x-input-radio name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" :value="$infoAnak->kewarganegaraan ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Bahasa di Rumah
                                                <x-input-select name="bahasa_di_rumah" class="form-item" :options="config('form-options.bahasa_di_rumah')" :value="$infoAnak->bahasa_di_rumah ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Agama
                                                <x-input-select name="agama" class="form-item" :options="config('form-options.agama')" :value="$infoAnak->agama ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Status Tinggal
                                                <x-input-select name="status_tinggal" class="form-item" :options="config('form-options.status_tinggal')" :value="$infoAnak->status_tinggal ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Yang Mendaftarkan
                                                <x-input-radio name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" :value="$infoAnak->yang_mendaftarkan ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Status Anak (dari yang mendaftarkan)
                                                <x-input-select name="status_anak" :options="config('form-options.status_anak')" :value="$infoAnak->status_anak ?? '' " required class="form-item"/>
                                            </td></tr>
                                            <tr><td>
                                                Anak Ke-
                                                <x-input type="number" name="anak_ke" class="form-item" min="1" :value="old('anak_ke', $infoAnak->anak_ke ?? '')" required/>
                                            </td></tr>
                                            <tr><td>
                                                Saudara Kandung
                                                <x-input type="number" name="saudara_kandung" class="form-item" min="0" :value="old('saudara_kandung', $infoAnak->saudara_kandung ?? '')"/>
                                            </td></tr>
                                            <tr><td>
                                                Saudara Tiri
                                                <x-input type="number" name="saudara_tiri" class="form-item" min="0" :value="old('saudara_tiri', $infoAnak->saudara_tiri ?? '')"/>
                                            </td></tr>
                                            <tr><td>
                                                Saudara Angkat
                                                <x-input type="number" name="saudara_angkat" class="form-item" min="0" :value="old('saudara_angkat', $infoAnak->saudara_angkat ?? '')"/>
                                            </td></tr>
                                            <tr><td>
                                                Berat Badan (kg)
                                                <x-input type="number" name="berat_badan" class="form-item" :value="old('berat_badan', $infoAnak->berat_badan ?? '')" required/>
                                            </td></tr>
                                            <tr><td>
                                                Tinggi Badan (cm)
                                                <x-input type="number" name="tinggi_badan" class="form-item" :value="old('tinggi_badan', $infoAnak->tinggi_badan ?? '')" required/>
                                            </td></tr>
                                            <tr><td>
                                                Golongan Darah
                                                <x-input-select name="golongan_darah" class="form-item" :options="config('form-options.golongan_darah')" :value="$infoAnak->golongan_darah ?? '' " required/>
                                            </td></tr>
                                            <tr><td>
                                                Riwayat Penyakit
                                                <x-input-textarea type="text" name="riwayat_penyakit" class="form-item" rows="3" cols="23" :value="old('riwayat_penyakit', $infoAnak->riwayat_penyakit ?? '')" placeholder="Silakan diisi bila ada"/>
                                            </td></tr>
                                            <tr><td>
                                                Mendaftar Sebagai
                                                <x-input-radio name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" :value="$infoAnak->mendaftar_sebagai ?? '' " required/>
                                            </td></tr>
                                            {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                            <tbody id="pindahanBit" style="display:none;">
                                            <tr><td>
                                                Sekolah Lama
                                                <x-input class="form-item pindahan-input" type="text" name="sekolah_lama" :value="old('sekolah_lama', $infoAnak->sekolah_lama ?? '')"/>
                                            </td></tr>
                                            <tr><td>
                                                Tanggal Pindah
                                                <x-input class="form-item pindahan-input" type="date" name="tanggal_pindah" :value="old('tanggal_pindah', $infoAnak->tanggal_pindah ?? '')"/>
                                            </td></tr>
                                            <tr><td>
                                                Dari Kelompok
                                                <x-input-select class="form-item pindahan-input" name="dari_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->dari_kelompok ?? '' "/>
                                            </td></tr>
                                            {{-- <tr><td>
                                                Tanggal Diterima
                                                <x-input class="form-item pindahan-input" type="date" name="tanggal_diterima" :value="old('tanggal_diterima', $infoAnak->tanggal_diterima ?? '')"/>
                                            </td></tr> --}}
                                            <tr><td>
                                                Ke Kelompok
                                                <x-input-select class="form-item pindahan-input" name="ke_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->ke_kelompok ?? '' "/>
                                            </td></tr>
                                            </tbody>
                                            {{-- until here --}}
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 content-padding-side-rem">
                        <div class="flex flex-col gap-rem">
                            <div class="" id="dataAyah">
                                <h6 class="">Data Ayah</h6>
                                <div class="">
                                    <table>
                                    <tr><td>
                                        Nama
                                        <x-input type="text" name="nama_ayah" class="form-item ayah-input" :value="old('nama_ayah', $ayah->nama ?? '')"/>
                                    </td></tr>
                                    <tr><td>
                                        Pendidikan
                                        <x-input-select name="pendidikan_ayah" class="form-item ayah-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ayah',$ayah->pendidikan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Pekerjaan
                                        <x-input-select name="pekerjaan_ayah" class="form-item ayah-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ayah',$ayah->pekerjaan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Alamat
                                        <x-input-textarea name="alamat_ayah" class="form-item ayah-input" rows="3" cols="23" :value="old('alamat_ayah',$ayah->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/>
                                    </td></tr>
                                    <tr><td>
                                        Nomor HP
                                        <x-input type="tel" name="nomor_hp_ayah" class="form-item ayah-input" :value="old('nomor_hp_ayah',$ayah->nomor_hp ?? '' )"/>
                                    </td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class=""id="dataIbu">
                                <h6 class="">Data Ibu</h6>
                                <div class="">
                                    <table>
                                    <tr><td>
                                        Nama
                                        <x-input type="text" name="nama_ibu" class="form-item ibu-input" :value="old('nama_ibu',$ibu->nama ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Pendidikan
                                        <x-input-select name="pendidikan_ibu" class="form-item ibu-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ibu',$ibu->pendidikan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Pekerjaan
                                        <x-input-select name="pekerjaan_ibu" class="form-item ibu-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ibu',$ibu->pekerjaan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Alamat
                                        <x-input-textarea name="alamat_ibu" class="form-item ibu-input" rows="3" cols="23" :value="old('alamat_ibu',$ibu->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/>
                                    </td></tr>
                                    <tr><td>
                                        Nomor HP
                                        <x-input type="tel" name="nomor_hp_ibu" class="form-item ibu-input" :value="old('nomor_hp_ibu',$ibu->nomor_hp ?? '' )"/>
                                    </td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="" id="dataWali">
                                <h6 class="">Data Wali</h6>
                                <div class="">
                                    <table>
                                    <tr><td>
                                        Nama
                                        <x-input class="form-item wali-input" type="text" name="nama_wali" :value="old('nama_wali',$wali->nama ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Pendidikan
                                        <x-input-select class="form-item wali-input" name="pendidikan_wali" :options="config('form-options.pendidikan')" :value="old('pendidikan_wali',$wali->pendidikan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Pekerjaan
                                        <x-input-select class="form-item wali-input" name="pekerjaan_wali" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_wali',$wali->pekerjaan ?? '' )"/>
                                    </td></tr>
                                    <tr><td>
                                        Alamat
                                        <x-input-textarea class="form-item wali-input" name="alamat_wali" rows="3" cols="23" :value="old('alamat_wali',$wali->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/>
                                    </td></tr>
                                    <tr><td>
                                        Nomor HP
                                        <x-input class="form-item wali-input" type="tel" name="nomor_hp_wali" :value="old('nomor_hp_wali',$wali->nomor_hp ?? '' )"/>
                                    </td></tr>
                                    </table>
                                </div>
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
