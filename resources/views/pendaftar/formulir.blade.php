<x-layouts.app-layout>

@if(session()->has('success'))
<x-flash-message class="alert" flash="green">{{ session('success') }}</x-flash-message>
@endif

<div id="pendaftar-formulir" class="app-content wrapper">
    <div class="content-title margin-vertical">Formulir Pendaftaran</div>
    <div class="scrollable">
        <form
        {{-- id="formPendaftaran"  --}}
        method="post" action="/pendaftar/formulir"> @method('PUT') @csrf
            <div class="flex">
                <div class="flex-1">
                    <div class="form-section">
                        <h6>Data Anak</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <x-input type="text" name="nama_anak" :value="old('nama_anak', $infoAnak->nama_anak ?? '')" placeholder="Nama Anak" required/></td></tr>
                            <tr><td>Nama Panggilan</td>
                                <td>: <x-input type="text" name="panggilan_anak" :value="old('panggilan_anak', $infoAnak->panggilan_anak ?? '')" placeholder="Nama Panggilan Anak" required/></td></tr>
                            <tr><td>Tempat Lahir</td>
                                <td>: <x-input type="text" name="tempat_lahir" :value="old('tempat_lahir', $infoAnak->tempat_lahir ?? '')" placeholder="Tempat Lahir Anak" required/></td></tr>
                            <tr><td>Tanggal Lahir</td>
                                <td>: <x-input type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $infoAnak->tanggal_lahir ?? '')" required/></td></tr>
                            <tr><td>Alamat</td>
                                <td>: <x-input-textarea type="text" name="alamat_anak" rows="3" cols="23" :value="old('alamat_anak', $infoAnak->alamat_anak ?? '')" placeholder="Silakan tulis alamat disini" required/>
                                </td></tr>
                            <tr><td>Jenis Kelamin</td>
                                <td>: <x-input-radio name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" :value="$infoAnak->jenis_kelamin ?? '' " required/></td></tr>
                            <tr><td>Kewarganegaraan</td>
                                <td>: <x-input-radio name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" :value="$infoAnak->kewarganegaraan ?? '' " required/></td></tr>
                            <tr><td>Bahasa di Rumah</td>
                                <td>: <x-input-select name="bahasa_di_rumah" :options="config('form-options.bahasa_di_rumah')" :value="$infoAnak->bahasa_di_rumah ?? '' " required/></td></tr>
                            <tr><td>Agama</td>
                                <td>: <x-input-select name="agama" :options="config('form-options.agama')" :value="$infoAnak->agama ?? '' " required/></td></tr>
                            <tr><td>Status Tinggal</td>
                                <td>: <x-input-select name="status_tinggal" :options="config('form-options.status_tinggal')" :value="$infoAnak->status_tinggal ?? '' " required/></td></tr>
                            <tr><td>Yang Mendaftarkan</td>
                                <td>: <x-input-radio name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" :value="$infoAnak->yang_mendaftarkan ?? '' " required/></td></tr>
                            <tr><td>Status Anak</td>
                                <td>: <x-input-radio name="status_anak" :options="config('form-options.status_anak')" :value="$infoAnak->status_anak ?? '' " required/></td></tr>
                            <tr><td>Anak Ke-</td>
                                <td>: <x-input type="number" name="anak_ke" min="1" :value="old('anak_ke', $infoAnak->anak_ke ?? '')" required/></td></tr>
                            <tr><td>Saudara Kandung</td>
                                <td>: <x-input type="number" name="saudara_kandung" min="0" :value="old('saudara_kandung', $infoAnak->saudara_kandung ?? '')"/></td></tr>
                            <tr><td>Saudara Tiri</td>
                                <td>: <x-input type="number" name="saudara_tiri" min="0" :value="old('saudara_tiri', $infoAnak->saudara_tiri ?? '')"/></td></tr>
                            <tr><td>Saudara Angkat</td>
                                <td>: <x-input type="number" name="saudara_angkat" min="0" :value="old('saudara_angkat', $infoAnak->saudara_angkat ?? '')"/></td></tr>
                            <tr><td>Berat Badan (kg)</td>
                                <td>: <x-input type="number" name="berat_badan" :value="old('berat_badan', $infoAnak->berat_badan ?? '')" required/></td></tr>
                            <tr><td>Tinggi Badan (cm)</td>
                                <td>: <x-input type="number" name="tinggi_badan" :value="old('tinggi_badan', $infoAnak->tinggi_badan ?? '')" required/></td></tr>
                            <tr><td>Golongan Darah</td>
                                <td>: <x-input-select name="golongan_darah" :options="config('form-options.golongan_darah')" :value="$infoAnak->golongan_darah ?? '' " required/></td></tr>
                            <tr><td>Riwayat Penyakit</td>
                                <td>: <x-input-textarea type="text" name="riwayat_penyakit" rows="3" cols="23" :value="old('riwayat_penyakit', $infoAnak->riwayat_penyakit ?? '')" placeholder="Silakan diisi bila ada" /></td></tr>
                            <tr><td>Mendaftar Sebagai</td>
                                <td>: <x-input-radio name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" :value="$infoAnak->mendaftar_sebagai ?? '' " required/></td></tr>
                            {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                            <tbody id="pindahanBit" style="display:none;">
                            <tr><td>Sekolah Lama</td>
                                <td>: <x-input class="pindahan-input" type="text" name="sekolah_lama" :value="old('sekolah_lama', $infoAnak->sekolah_lama ?? '')"/></td></tr>
                            <tr><td>Tanggal Pindah</td>
                                <td>: <x-input class="pindahan-input" type="date" name="tanggal_pindah" :value="old('tanggal_pindah', $infoAnak->tanggal_pindah ?? '')"/></td></tr>
                            <tr><td>Dari Kelompok</td>
                                <td>: <x-input-select class="pindahan-input" name="dari_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->dari_kelompok ?? '' "/></td></tr>
                            {{-- <tr><td>Tanggal Diterima</td>
                                <td>: <x-input class="pindahan-input" type="date" name="tanggal_diterima" :value="old('tanggal_diterima', $infoAnak->tanggal_diterima ?? '')"/></td></tr> --}}
                            <tr><td>Ke Kelompok</td>
                                <td>: <x-input-select class="pindahan-input" name="ke_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->ke_kelompok ?? '' "/></td></tr>
                            </tbody>
                            {{-- until here --}}
                        </table>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="form-section" id="dataAyah">
                        <h6>Data Ayah</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <x-input type="text" name="nama_ayah" class="ayah-input" :value="old('nama_ayah', $ayah->nama ?? '')"/></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>: <x-input-select name="pendidikan_ayah" class="ayah-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ayah',$ayah->pendidikan ?? '' )"/></td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>: <x-input-select name="pekerjaan_ayah" class="ayah-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ayah',$ayah->pekerjaan ?? '' )"/></td></tr>
                            <tr><td>Alamat</td>
                                <td>: <x-input-textarea name="alamat_ayah" class="ayah-input" rows="3" cols="23" :value="old('alamat_ayah',$ayah->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                            <tr><td>Nomor HP</td>
                                <td>: <x-input type="tel" name="nomor_hp_ayah" class="ayah-input" :value="old('nomor_hp_ayah',$ayah->nomor_hp ?? '' )"/>
                                </td></tr>
                        </table>
                    </div>
                    <div class="form-section"id="dataIbu">
                        <h6>Data Ibu</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <x-input type="text" name="nama_ibu" class="ibu-input" :value="old('nama_ibu',$ibu->nama ?? '' )"/></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>: <x-input-select name="pendidikan_ibu" class="ibu-input" :options="config('form-options.pendidikan')" :value="old('pendidikan_ibu',$ibu->pendidikan ?? '' )"/></td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>: <x-input-select name="pekerjaan_ibu" class="ibu-input" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ibu',$ibu->pekerjaan ?? '' )"/></td></tr>
                            <tr><td>Alamat</td>
                                <td>: <x-input-textarea name="alamat_ibu" class="ibu-input" rows="3" cols="23" :value="old('alamat_ibu',$ibu->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                            <tr><td>Nomor HP</td>
                                <td>: <x-input type="tel" name="nomor_hp_ibu" class="ibu-input" :value="old('nomor_hp_ibu',$ibu->nomor_hp ?? '' )"/></td></tr>
                        </table>
                    </div>
                    <div class="form-section" id="dataWali">
                        <h6>Data Wali</h6>
                        <table>
                            <tr><td width="180px">Nama</td>
                                <td>: <x-input class="wali-input" type="text" name="nama_wali" :value="old('nama_wali',$wali->nama ?? '' )"/></td></tr>
                            <tr><td>Pendidikan</td>
                                <td>: <x-input-select class="wali-input" name="pendidikan_wali" :options="config('form-options.pendidikan')" :value="old('pendidikan_wali',$wali->pendidikan ?? '' )"/></td></tr>
                            <tr><td>Pekerjaan</td>
                                <td>: <x-input-select class="wali-input" name="pekerjaan_wali" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_wali',$wali->pekerjaan ?? '' )"/></td></tr>
                            <tr><td>Alamat</td>
                                <td>: <x-input-textarea class="wali-input" name="alamat_wali" rows="3" cols="23" :value="old('alamat_wali',$wali->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                            <tr><td>Nomor HP</td>
                                <td>: <x-input class="wali-input" type="tel" name="nomor_hp_wali" :value="old('nomor_hp_wali',$wali->nomor_hp ?? '' )"/></td></tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="margin-vertical text-align-center">
                <input type="submit" class="tombol-besar tombol-netral" value="Simpan"/>
            </div>
        </form>
    </div>
</div>
{{--
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("formPendaftaran");

        const mendaftarRadios = document.querySelectorAll('input[name="mendaftar_sebagai"]');
        const yangMendaftarkanRadios = document.querySelectorAll('input[name="yang_mendaftarkan"]');

        const pindahanBit = document.getElementById("pindahanBit");
        const pindahanInputs = document.querySelectorAll(".pindahan-input");

        const dataAyahInputs = document.querySelectorAll(".ayah-input");
        const dataIbuInputs = document.querySelectorAll(".ibu-input");
        const dataWaliInputs = document.querySelectorAll(".wali-input");

        function togglePindahanBit() {
            const selected = document.querySelector('input[name="mendaftar_sebagai"]:checked');
            const isPindahan = selected && selected.value === "Pindahan";

            pindahanBit.style.display = isPindahan ? "table-row-group" : "none";
            pindahanInputs.forEach(input => input.required = isPindahan);
        }

        function toggleRequiredFields() {
            const selected = document.querySelector('input[name="yang_mendaftarkan"]:checked');
            const isOrangTua = selected && selected.value === "Orang Tua";

            dataAyahInputs.forEach(input => input.required = isOrangTua);
            dataIbuInputs.forEach(input => input.required = isOrangTua);
            dataWaliInputs.forEach(input => input.required = !isOrangTua);
        }


        mendaftarRadios.forEach(radio => radio.addEventListener("change", () => {
            togglePindahanBit();
        }));

        yangMendaftarkanRadios.forEach(radio => radio.addEventListener("change", () => {
            toggleRequiredFields();
            enableSubmitButton();
        }));


        // Initialize on page load
        togglePindahanBit();
        toggleRequiredFields();
    });
</script> --}}

</x-layouts.app-layout>
