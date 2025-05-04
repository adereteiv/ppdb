<x-layouts.app-layout>

@if (session()->has('success'))
<x-flash-message alert="green">{{ session('success') }}</x-flash-message>
@endif

<div id="admin-ppdb-entry" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>/admin/ppdb/aktif</x-slot:backLink>
            <x-slot:title><h6>Edit Pendaftaran</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding content-padding-side-rem">
            <div class="constrict">
                <div class="biodata scrollable">
                    <form id="patchForm" action="{{ route('ppdb.aktif.patch', $pendaftaran->id) }}" method="POST">@csrf @method('PATCH')
                        <div class="padding-10">
                            <b>Data Pengguna</b>
                            <table>
                                <tr><td width="180px">ID Pengguna</td>
                                    <td>{{ $pendaftaran->user->id }}</td></tr>
                                <tr><td>ID Pendaftaran</td>
                                    <td>{{ $pendaftaran->id }}</td></tr>
                                <tr><td>Mendaftar Pada</td>
                                    <td>{{ ($pendaftaran->created_at)->translatedFormat('l, d F Y') }}</td></tr>
                                <tr><td>Email</td>
                                    <td>{{ $pendaftaran->user->email }}</td></tr>
                                <tr><td>Status Pendaftaran</td>
                                    <td>
                                        @if ($pendaftaran->status == 'Belum Lengkap')
                                            <x-status-pendaftaran :value="$pendaftaran->status"/>
                                        @else
                                            <input id="statusInput" type="hidden" name="status" value="{{ $pendaftaran->status }}"/>
                                            <x-dropdown class="wrapper gap padding-10 left-0">
                                                <x-slot:clicker><div class="flex"><x-status-pendaftaran id="status" :value="$pendaftaran->status" @click="open = !open" @click.outside="open = false"/></div></x-slot:clicker>
                                                <div class="text-align-center">Status Pendaftaran</div>
                                                <hr style="border: 1px solid rgba(0, 0, 0, .15);">
                                                <x-status-pendaftaran class="text-align-center" id="statusLengkap" value="Lengkap"/>
                                                <x-status-pendaftaran class="text-align-center" id="statusTerverifikasi" value="Terverifikasi"/>
                                            </x-dropdown>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', () => {
                                                    const form = document.getElementById('patchForm');
                                                    const input = document.getElementById('statusInput');
                                                    const display = document.getElementById('status');

                                                    function removeTombolClasses(el) {
                                                        el.classList.forEach(cls => {
                                                            if (cls.startsWith('tombol')) {
                                                                el.classList.remove(cls);
                                                            }
                                                        });
                                                    }

                                                    document.getElementById('statusLengkap').addEventListener('click', () => {
                                                        input.value = 'Lengkap';
                                                        display.textContent = 'Lengkap';
                                                        removeTombolClasses(display);
                                                        display.classList.add('tombol-positif');
                                                    });

                                                    document.getElementById('statusTerverifikasi').addEventListener('click', () => {
                                                        input.value = 'Terverifikasi';
                                                        display.textContent = 'Terverifikasi';
                                                        removeTombolClasses(display);
                                                        display.classList.add('tombol-netral');
                                                    });
                                                });
                                            </script>
                                        @endif
                                    </td>
                                </tr>
                                <tr><td>Catatan Admin</td>
                                    <td><x-input-textarea class="form-item" name="catatan_admin" rows="4" cols="23" :value="old('catatan_admin', $pendaftaran->catatan_admin ?? '')" placeholder="Catatan mengenai pendaftaran ini, contoh: 'Berkas kurang jelas', 'Segera hubungi orang tua', dsb. "/></td></tr>
                            </table>
                        </div>
                    </form>
                    <hr style="border: 1px solid rgba(0, 0, 0, .15);">
                    <form id="mainForm" method="POST" action="{{ route('ppdb.aktif.update', $pendaftaran->id) }}" enctype="multipart/form-data">@csrf @method('PUT')
                        <div class="margin-vertical">
                            {{-- Form Pendaftaran --}}
                            <div class="padding-10">
                                <b>Data Anak</b>
                                <table>
                                    <tr><td width="180px">Nama</td>
                                        <td><x-input type="text" class="form-item" name="nama_anak" :value="old('nama_anak', $infoAnak->nama_anak ?? '')" placeholder="Nama Anak" required/></td></tr>
                                    <tr><td>Nama Panggilan</td>
                                        <td><x-input type="text" class="form-item" name="panggilan_anak" :value="old('panggilan_anak', $infoAnak->panggilan_anak ?? '')" placeholder="Nama Panggilan Anak" required/></td></tr>
                                    <tr><td>Tempat Lahir</td>
                                        <td><x-input type="text" class="form-item" name="tempat_lahir" :value="old('tempat_lahir', $infoAnak->tempat_lahir ?? '')" placeholder="Tempat Lahir Anak" required/></td></tr>
                                    <tr><td>Tanggal Lahir</td>
                                        <td><x-input type="date" class="form-item" name="tanggal_lahir" :value="old('tanggal_lahir', $infoAnak->tanggal_lahir ?? '')" required/></td></tr>
                                    <tr><td>Alamat</td>
                                        <td><x-input-textarea class="form-item" name="alamat_anak" rows="4" cols="23" :value="old('alamat_anak', $infoAnak->alamat_anak ?? '')" placeholder="Silakan tulis alamat disini" required/>
                                        </td></tr>
                                    <tr><td>Jenis Kelamin</td>
                                        <td><x-input-radio name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" :value="$infoAnak->jenis_kelamin ?? '' " required/></td></tr>
                                    <tr><td>Kewarganegaraan</td>
                                        <td><x-input-radio name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" :value="$infoAnak->kewarganegaraan ?? '' " required/></td></tr>
                                    <tr><td>Bahasa di Rumah</td>
                                        <td><x-input-select class="form-item" name="bahasa_di_rumah" :options="config('form-options.bahasa_di_rumah')" :value="$infoAnak->bahasa_di_rumah ?? '' " required/></td></tr>
                                    <tr><td>Agama</td>
                                        <td><x-input-select class="form-item" name="agama" :options="config('form-options.agama')" :value="$infoAnak->agama ?? '' " required/></td></tr>
                                    <tr><td>Status Tinggal</td>
                                        <td><x-input-select class="form-item" name="status_tinggal" :options="config('form-options.status_tinggal')" :value="$infoAnak->status_tinggal ?? '' " required/></td></tr>
                                    <tr><td>Yang Mendaftarkan</td>
                                        <td><x-input-radio name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" :value="$infoAnak->yang_mendaftarkan ?? '' " required/></td></tr>
                                    <tr><td>Status Anak</td>
                                        <td><x-input-select class="form-item" name="status_anak" :options="config('form-options.status_anak')" :value="$infoAnak->status_anak ?? '' " required/></td></tr>
                                    <tr><td>Anak Ke-</td>
                                        <td><x-input type="number" class="form-item" name="anak_ke" min="1" :value="old('anak_ke', $infoAnak->anak_ke ?? '')" required/></td></tr>
                                    <tr><td>Saudara Kandung</td>
                                        <td><x-input type="number" class="form-item" name="saudara_kandung" min="0" :value="old('saudara_kandung', $infoAnak->saudara_kandung ?? '')"/></td></tr>
                                    <tr><td>Saudara Tiri</td>
                                        <td><x-input type="number" class="form-item" name="saudara_tiri" min="0" :value="old('saudara_tiri', $infoAnak->saudara_tiri ?? '')"/></td></tr>
                                    <tr><td>Saudara Angkat</td>
                                        <td><x-input type="number" class="form-item" name="saudara_angkat" min="0" :value="old('saudara_angkat', $infoAnak->saudara_angkat ?? '')"/></td></tr>
                                    <tr><td>Berat Badan (kg)</td>
                                        <td><x-input type="number" class="form-item" name="berat_badan" :value="old('berat_badan', $infoAnak->berat_badan ?? '')" required/></td></tr>
                                    <tr><td>Tinggi Badan (cm)</td>
                                        <td><x-input type="number" class="form-item" name="tinggi_badan" :value="old('tinggi_badan', $infoAnak->tinggi_badan ?? '')" required/></td></tr>
                                    <tr><td>Golongan Darah</td>
                                        <td><x-input-select class="form-item" name="golongan_darah" :options="config('form-options.golongan_darah')" :value="$infoAnak->golongan_darah ?? '' " required/></td></tr>
                                    <tr><td>Riwayat Penyakit</td>
                                        <td><x-input-textarea class="form-item" name="riwayat_penyakit" rows="4" cols="23" :value="old('riwayat_penyakit', $infoAnak->riwayat_penyakit ?? '')" placeholder="Silakan diisi bila ada" /></td></tr>
                                    <tr><td>Mendaftar Sebagai</td>
                                        <td><x-input-radio name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" :value="$infoAnak->mendaftar_sebagai ?? '' " required/></td></tr>
                                    {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                    <tbody id="pindahanBit" style="display:none;">
                                    <tr><td>Sekolah Lama</td>
                                        <td><x-input class="pindahan-input form-item" type="text" name="sekolah_lama" :value="old('sekolah_lama', $infoAnak->sekolah_lama ?? '')"/></td></tr>
                                    <tr><td>Tanggal Pindah</td>
                                        <td><x-input class="pindahan-input form-item" type="date" name="tanggal_pindah" :value="old('tanggal_pindah', $infoAnak->tanggal_pindah ?? '')"/></td></tr>
                                    <tr><td>Dari Kelompok</td>
                                        <td><x-input-select class="pindahan-input form-item" name="dari_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->dari_kelompok ?? '' "/></td></tr>
                                    {{-- <tr><td>Tanggal Diterima</td>
                                        <td><x-input class="pindahan-input form-item" type="date" name="tanggal_diterima" :value="old('tanggal_diterima', $infoAnak->tanggal_diterima ?? '')"/></td></tr> --}}
                                    <tr><td>Ke Kelompok</td>
                                        <td><x-input-select class="pindahan-input form-item" name="ke_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->ke_kelompok ?? '' "/></td></tr>
                                    </tbody>
                                    {{-- until here --}}
                                </table>
                            </div>
                            <div class="padding-10" id="dataAyah">
                                <b>Data Ayah</b>
                                <table>
                                    <tr><td width="180px">Nama</td>
                                        <td><x-input type="text" name="nama_ayah" class="ayah-input form-item" :value="old('nama_ayah', $ayah->nama ?? '')"/></td></tr>
                                    <tr><td>Pendidikan</td>
                                        <td><x-input-select name="pendidikan_ayah" class="ayah-input form-item" :options="config('form-options.pendidikan')" :value="old('pendidikan_ayah',$ayah->pendidikan ?? '' )"/></td></tr>
                                    <tr><td>Pekerjaan</td>
                                        <td><x-input-select name="pekerjaan_ayah" class="ayah-input form-item" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ayah',$ayah->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td>Alamat</td>
                                        <td><x-input-textarea name="alamat_ayah" class="ayah-input form-item" rows="4" cols="23" :value="old('alamat_ayah', $ayah->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td>Nomor HP</td>
                                        <td><x-input type="tel" name="nomor_hp_ayah" class="ayah-input form-item" :value="old('nomor_hp_ayah', $ayah->nomor_hp ?? '' )"/>
                                        </td></tr>
                                </table>
                            </div>
                            <div class="padding-10" id="dataIbu">
                                <b>Data Ibu</b>
                                <table>
                                    <tr><td width="180px">Nama</td>
                                        <td><x-input type="text" name="nama_ibu" class="ibu-input form-item" :value="old('nama_ibu', $ibu->nama ?? '' )"/></td></tr>
                                    <tr><td>Pendidikan</td>
                                        <td><x-input-select name="pendidikan_ibu" class="ibu-input form-item" :options="config('form-options.pendidikan')" :value="old('pendidikan_ibu', $ibu->pendidikan ?? '' )"/></td></tr>
                                    <tr><td>Pekerjaan</td>
                                        <td><x-input-select name="pekerjaan_ibu" class="ibu-input form-item" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ibu', $ibu->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td>Alamat</td>
                                        <td><x-input-textarea name="alamat_ibu" class="ibu-input form-item" rows="4" cols="23" :value="old('alamat_ibu', $ibu->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td>Nomor HP</td>
                                        <td><x-input type="tel" name="nomor_hp_ibu" class="ibu-input form-item" :value="old('nomor_hp_ibu', $ibu->nomor_hp ?? '' )"/></td></tr>
                                </table>
                            </div>
                            <div class="padding-10" id="dataWali">
                                <b>Data Wali</b>
                                <table>
                                    <tr><td width="180px">Nama</td>
                                        <td><x-input type="text" class="wali-input form-item" name="nama_wali" :value="old('nama_wali', $wali->nama ?? '' )"/></td></tr>
                                    <tr><td>Pendidikan</td>
                                        <td><x-input-select class="wali-input form-item" name="pendidikan_wali" :options="config('form-options.pendidikan')" :value="old('pendidikan_wali', $wali->pendidikan ?? '' )"/></td></tr>
                                    <tr><td>Pekerjaan</td>
                                        <td><x-input-select class="wali-input form-item" name="pekerjaan_wali" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_wali', $wali->pekerjaan ?? '' )"/></td></tr>
                                    <tr><td>Alamat</td>
                                        <td><x-input-textarea class="wali-input form-item" name="alamat_wali" rows="4" cols="23" :value="old('alamat_wali', $wali->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                    <tr><td>Nomor HP</td>
                                        <td><x-input type="tel" class="wali-input form-item" name="nomor_hp_wali" :value="old('nomor_hp_wali', $wali->nomor_hp ?? '' )"/></td></tr>
                                </table>
                            </div>
                            {{-- Form Dokumen --}}
                            @foreach ($syaratDokumen as $syarat)
                                @php $dokumen = $dokumenPersyaratan->firstWhere('tipe_dokumen_id', $syarat->tipe_dokumen_id); @endphp
                                <div class="">
                                    <x-inputbox-file
                                        :label="$syarat->tipeDokumen->tipe"
                                        :isWajib="$syarat->is_wajib"
                                        keterangan="{{ $syarat->keterangan }}"
                                        fileType="dokumen"
                                        :dokumen="$dokumen"
                                    />
                                </div>
                            @endforeach
                            {{-- Form Bukti Bayar --}}
                            <div class="">
                                <x-inputbox-file
                                    label="Bukti Bayar"
                                    isWajib="true"
                                    fileType="pelengkap"
                                    keterangan="Unggah bukti pembayaran Anda disini"
                                    :dokumen="$buktiBayar"
                                />
                            </div>
                        </div>
                        <div class="margin-vertical text-align-center">
                            <input type="submit" class="tombol-besar tombol-netral" value="Simpan"/>
                        </div>
                        <x-scripts.submit-button form="mainForm"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
