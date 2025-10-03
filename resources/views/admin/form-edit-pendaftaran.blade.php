<x-layouts.app-layout>

<div id="admin-ppdb-entry" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>{{ route('admin.ppdb.aktif.index') }}</x-slot:backLink>
            <x-slot:title><h6>Edit Pendaftaran</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding content-padding-side-rem">
            <div class="content-margin content-padding-side-rem">
                <x-flash-message flash='blue' class="cursor-pointer">
                    <div data-toggle-target="#petunjukPengisian" class="flex justify-between">
                        <p><b>Petunjuk Pengeditan</b></p>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                    </div>
                    <ul id="petunjukPengisian" class="overflow-hidden vertical-dropdown">
                        <li class="subtext">Sebelum melakukan perubahan data, Admin diharapkan untuk terlebih dahulu mengonfirmasi dengan orang tua atau wali pendaftar mengenai informasi mana saja yang perlu diperbarui.</li>
                        <li class="subtext">Perlu diketahui bahwa perubahan pada Status Pendaftaran dan Catatan Admin akan otomatis tersimpan (autosave) tanpa perlu menekan tombol "Simpan".</li>
                        <li class="subtext">Pastikan data yang diisi sudah selengkap mungkin. Bila orang tua belum memberikan info lengkap, silakan ditanyakan agar datanya bisa dilengkapi.</li>
                        <li class="subtext">Apabila orang tua atau wali ingin mengganti kata sandi, tekan tombol 'Buat Tautan dan PIN' untuk membuat tautan dan PIN pengaturan ulang kata sandi yang berlaku selama 30 menit. Mohon segera informasikan tautan dan PIN tersebut ke orang tua agar segera melakukan penggantian kata sandi.</li>
                    </ul>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const arrow = document.querySelector(".arrow");
                            const target = document.querySelector("#petunjukPengisian");
                            target

                            if (!arrow || !target) return;

                            // Link `arrow` to `target` and update `arrow` based on .open/.close on `target`
                            const updateArrow = () => {
                                const isOpen = target.classList.contains("open");
                                arrow.style.transform = isOpen ? "rotate(0deg)" : "rotate(-90deg)";
                                arrow.style.transition = "transform 0.2s";
                            };
                            // Reflects the initial state of `target` on page load
                            updateArrow();

                            // Watch for DOM changes (specifically class attribute changes) on the `target` element.
                            const observer = new MutationObserver(() => {
                                updateArrow();
                            });
                            observer.observe(target, { attributes: true, attributeFilter: ["class"] });
                        });
                    </script>
                </x-flash-message>
            </div>
            <div class="biodata scrollable">
                <form id="patchForm" action="{{ route('admin.ppdb.aktif.patch', $pendaftaran->id) }}" method="POST">@csrf @method('PATCH')
                    <div class="padding-10">
                        <div class="content-padding-side-rem">
                            <b class="padding-10">Data Pengguna</b>
                        </div>
                        <div class="flex">
                            <div class="flex-1 content-padding-side-rem">
                                <div class="padding-side-10">
                                    <table>
                                        <tr><td>ID Pengguna<p>{{ $pendaftaran->user->id }}</p></td></tr>
                                        <tr><td>ID Pendaftaran<p>{{ $pendaftaran->id }}</p></td></tr>
                                        <tr><td>Mendaftar Pada<p>{{ ($pendaftaran->created_at)->translatedFormat('l, d F Y') }}</p></td></tr>
                                        <tr><td>Nomor HP/WA<p>{{ $pendaftaran->user->nomor_hp }}</p></td></tr>
                                        <tr><td>Email<p>
                                            @if ($pendaftaran->user->email)
                                                {{ $pendaftaran->user->email }}
                                            @else
                                                <i class="teks-netral">Data tidak ditemukan</i>
                                            @endif
                                            </p></td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="flex-1 content-padding-side-rem">
                                <div class="padding-side-10">
                                    <table>
                                        <tr><td><p>Ubah Kata Sandi Pengguna</p>
                                            <p><a class="badge round tombol-netral" style="text-decoration: none;" href="{{ route('admin.ppdb.aktif.password_reset.set_token', $pendaftaran->user->id) }}" onclick="this.style.pointerEvents='none'">Buat Tautan dan PIN</a></p>
                                        </td></tr>
                                        <tr><td>Status Pendaftaran <span style="color:#2962ff">(klik status untuk mengubah)</span>
                                                @if ($pendaftaran->status == 'Mengisi' || !$pendaftaran->infoAnak->buktiBayar->first())
                                                    <p><x-status-pendaftaran :value="$pendaftaran->status"/></p>
                                                @else
                                                    <input id="statusInput" type="hidden" name="status" value="{{ $pendaftaran->status }}"/>
                                                    <x-dropdown class="wrapper gap padding-10 left-0">
                                                        <x-slot:clicker>
                                                            <div class="flex">
                                                                <x-status-pendaftaran id="status" :value="$pendaftaran->status" @click="open = !open" @click.outside="open = false"/>
                                                                @if ($pendaftaran->status === 'Menunggu' && $pendaftaran->infoAnak->buktiBayar->first())
                                                                    <span style="color:green;">(✔)</span>
                                                                @endif
                                                                </div>
                                                        </x-slot:clicker>
                                                        <div class="text-align-center">Status Pendaftaran</div>
                                                        <hr style="border: 1px solid rgba(0, 0, 0, .15);">
                                                        @if ($pendaftaran->infoAnak->buktiBayar->first())
                                                            @if ($pendaftaran->status == 'Menunggu')
                                                                <x-status-pendaftaran class="text-align-center" id="statusMengisi" value="Mengisi"/>
                                                            @elseif ($pendaftaran->status == 'Lengkap' || $pendaftaran->status == 'Terverifikasi')
                                                                <x-status-pendaftaran class="text-align-center" id="statusLengkap" value="Lengkap"/>
                                                                <x-status-pendaftaran class="text-align-center" id="statusTerverifikasi" value="Terverifikasi"/>
                                                            @endif
                                                        @endif
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
                                                            const statusMengisi = document.getElementById('statusMengisi')
                                                            if (statusMengisi) {
                                                                statusMengisi.addEventListener('click', () => {
                                                                    input.value = 'Mengisi';
                                                                    display.textContent = 'Mengisi';
                                                                    removeTombolClasses(display);
                                                                    display.classList.add('tombol-yellowdark');
                                                                });
                                                            }

                                                            const statusLengkap = document.getElementById('statusLengkap');
                                                            const statusTerverifikasi = document.getElementById('statusTerverifikasi');
                                                            if (statusLengkap && statusTerverifikasi) {
                                                                statusLengkap.addEventListener('click', () => {
                                                                    input.value = 'Lengkap';
                                                                    display.textContent = 'Lengkap';
                                                                    removeTombolClasses(display);
                                                                    display.classList.add('tombol-positif');
                                                                });

                                                                statusTerverifikasi.addEventListener('click', () => {
                                                                    input.value = 'Terverifikasi';
                                                                    display.textContent = 'Terverifikasi';
                                                                    removeTombolClasses(display);
                                                                    display.classList.add('tombol-netral');
                                                                });
                                                            }
                                                        });
                                                    </script>
                                                @endif
                                        </td></tr>
                                        <tr><td>Catatan Admin <span style="color:#2962ff">(Perbarui catatan)</span>
                                                <x-input-textarea class="form-item" name="catatan_admin" rows="4" cols="23" :value="old('catatan_admin', $pendaftaran->catatan_admin ?? '')" placeholder="Catatan mengenai pendaftaran ini, contoh: 'Berkas kurang jelas', 'Segera hubungi orang tua', dsb. "/>
                                        </td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="padding-10">
                    <div class="content-padding-side-rem">
                        <hr style="border: 1px solid rgba(0, 0, 0, .15);">
                    </div>
                </div>
                <form id="mainForm" method="POST" action="{{ route('admin.ppdb.aktif.update', $pendaftaran->id) }}" enctype="multipart/form-data">@csrf @method('PUT')
                    {{-- Form Bukti Bayar --}}
                    <div class="padding-10">
                        <div class="content-padding-side-rem">
                            <x-inputbox-file
                                label="Bukti Bayar"
                                isWajib="true"
                                fileType="pelengkap"
                                keterangan="Unggah bukti pembayaran Anda disini"
                                :dokumen="$buktiBayar"
                            />
                        </div>
                    </div>
                    {{-- Form Pendaftaran --}}
                    <div class="padding-10">
                        <div class="flex">
                            <div class="flex-1 content-padding-side-rem">
                                <div class="padding-10">
                                    <b>Data Anak</b>
                                    <table>
                                        <tr><td>Nama<x-input type="text" class="form-item" name="nama_anak" :value="old('nama_anak', $infoAnak->nama_anak ?? '')" placeholder="Nama Anak"/></td></tr>
                                        <tr><td>Nama Panggilan<x-input type="text" class="form-item" name="panggilan_anak" :value="old('panggilan_anak', $infoAnak->panggilan_anak ?? '')" placeholder="Nama Panggilan Anak"/></td></tr>
                                        <tr><td>Tempat Lahir<x-input type="text" class="form-item" name="tempat_lahir" :value="old('tempat_lahir', $infoAnak->tempat_lahir ?? '')" placeholder="Tempat Lahir Anak"/></td></tr>
                                        <tr><td>Tanggal Lahir<x-input type="date" class="form-item" name="tanggal_lahir" :value="old('tanggal_lahir', $infoAnak->tanggal_lahir ?? '')"/></td></tr>
                                        <tr><td>Jarak Tempuh (km)<x-input type="number" name="jarak_tempuh" class="form-item" :value="old('jarak_tempuh', $infoAnak->jarak_tempuh ?? '')"/></td></tr>
                                        <tr><td>Alamat<x-input-textarea class="form-item" name="alamat_anak" rows="4" cols="23" :value="old('alamat_anak', $infoAnak->alamat_anak ?? '')" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td>Jenis Kelamin<x-input-radio id="jk" name="jenis_kelamin" :options="config('form-options.jenis_kelamin')" :value="$infoAnak->jenis_kelamin ?? '' "/></td></tr>
                                        <tr><td>Kewarganegaraan<x-input-radio id="kwn" name="kewarganegaraan" :options="config('form-options.kewarganegaraan')" :value="$infoAnak->kewarganegaraan ?? '' "/></td></tr>
                                        <tr><td>Bahasa di Rumah<x-input-select class="form-item" name="bahasa_di_rumah" :options="config('form-options.bahasa_di_rumah')" :value="$infoAnak->bahasa_di_rumah ?? '' "/></td></tr>
                                        <tr><td>Agama<x-input-select class="form-item" name="agama" :options="config('form-options.agama')" :value="$infoAnak->agama ?? '' "/></td></tr>
                                        <tr><td>Status Tinggal<x-input-select class="form-item" name="status_tinggal" :options="config('form-options.status_tinggal')" :value="$infoAnak->status_tinggal ?? '' "/></td></tr>
                                        <tr><td>Yang Mendaftarkan<x-input-radio id="yang_mendaftarkan" name="yang_mendaftarkan" :options="config('form-options.yang_mendaftarkan')" :value="$infoAnak->yang_mendaftarkan ?? '' "/></td></tr>
                                        <tr><td>Status Anak<x-input-select class="form-item" name="status_anak" :options="config('form-options.status_anak')" :value="$infoAnak->status_anak ?? '' "/></td></tr>
                                        <tr><td>Anak Ke-<x-input type="number" class="form-item" name="anak_ke" min="1" :value="old('anak_ke', $infoAnak->anak_ke ?? '')"/></td></tr>
                                        <tr><td>Saudara Kandung<x-input type="number" class="form-item" name="saudara_kandung" min="0" :value="old('saudara_kandung', $infoAnak->saudara_kandung ?? '')"/></td></tr>
                                        <tr><td>Saudara Tiri<x-input type="number" class="form-item" name="saudara_tiri" min="0" :value="old('saudara_tiri', $infoAnak->saudara_tiri ?? '')"/></td></tr>
                                        <tr><td>Saudara Angkat<x-input type="number" class="form-item" name="saudara_angkat" min="0" :value="old('saudara_angkat', $infoAnak->saudara_angkat ?? '')"/></td></tr>
                                        <tr><td>Berat Badan (kg)<x-input type="number" class="form-item" name="berat_badan" :value="old('berat_badan', $infoAnak->berat_badan ?? '')"/></td></tr>
                                        <tr><td>Tinggi Badan (cm)<x-input type="number" class="form-item" name="tinggi_badan" :value="old('tinggi_badan', $infoAnak->tinggi_badan ?? '')"/></td></tr>
                                        <tr><td>Ukuran Baju<x-input-select name="ukuran_baju" class="form-item" :options="config('form-options.ukuran_baju')" :value="$infoAnak->ukuran_baju ?? '' "/></td></tr>
                                        <tr><td>Golongan Darah<x-input-select class="form-item" name="golongan_darah" :options="config('form-options.golongan_darah')" :value="$infoAnak->golongan_darah ?? '' "/></td></tr>
                                        <tr><td>Riwayat Penyakit<x-input-textarea class="form-item" name="riwayat_penyakit" rows="4" cols="23" :value="old('riwayat_penyakit', $infoAnak->riwayat_penyakit ?? '')" placeholder="Silakan diisi bila ada" /></td></tr>
                                        <tr><td>Mendaftar Sebagai<x-input-radio id="mendaftar_sebagai" name="mendaftar_sebagai" :options="config('form-options.mendaftar_sebagai')" :value="$infoAnak->mendaftar_sebagai ?? '' "/></td></tr>
                                        {{-- JS for If, daftar_sebagai has option value=2 selected, display the part below, else don't show --}}
                                        <tbody id="pindahanBit" style="display:none;">
                                        <tr><td>Sekolah Lama<x-input class="pindahan-input form-item" type="text" name="sekolah_lama" :value="old('sekolah_lama', $infoAnak->sekolah_lama ?? '')"/></td></tr>
                                        <tr><td>Tanggal Pindah<x-input class="pindahan-input form-item" type="date" name="tanggal_pindah" :value="old('tanggal_pindah', $infoAnak->tanggal_pindah ?? '')"/></td></tr>
                                        <tr><td>Dari Kelompok<x-input-select class="pindahan-input form-item" name="dari_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->dari_kelompok ?? '' "/></td></tr>
                                        {{-- <tr><td>Tanggal Diterima<x-input class="pindahan-input form-item" type="date" name="tanggal_diterima" :value="old('tanggal_diterima', $infoAnak->tanggal_diterima ?? '')"/></td></tr> --}}
                                        <tr><td>Ke Kelompok<x-input-select class="pindahan-input form-item" name="ke_kelompok" :options="config('form-options.kelompok_umur')" :value="$infoAnak->ke_kelompok ?? '' "/></td></tr>
                                        </tbody>
                                        {{-- until here --}}
                                    </table>
                                </div>
                            </div>
                            <div class="flex-1 content-padding-side-rem">
                                <div class="padding-10" id="dataAyah">
                                    <b>Data Ayah</b>
                                    <table>
                                        <tr><td><label for="nama_ayah">Nama</label><x-input type="text" id="nama_ayah" name="nama_ayah" class="ayah-input form-item" :value="old('nama_ayah', $ayah->nama ?? '')"/></td></tr>
                                        <tr><td><label for="pendidikan_ayah">Pendidikan</label><x-input-select id="pendidikan_ayah" name="pendidikan_ayah" class="ayah-input form-item" :options="config('form-options.pendidikan')" :value="old('pendidikan_ayah',$ayah->pendidikan ?? '' )"/></td></tr>
                                        <tr><td><label for="pekerjaan_ayah">Pekerjaan</label><x-input-select id="pekerjaan_ayah" name="pekerjaan_ayah" class="ayah-input form-item" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ayah',$ayah->pekerjaan ?? '' )"/></td></tr>
                                        <tr><td><label for="penghasilan_ayah">Penghasilan</label><x-input-select id="penghasilan_ayah" name="penghasilan_ayah" class="ayah-input form-item" :options="config('form-options.penghasilan')" :value="old('penghasilan_ayah',$ayah->penghasilan ?? '' )"/></td></tr>
                                        <tr><td><label for="alamat_ayah">Alamat</label><x-input-textarea id="alamat_ayah" name="alamat_ayah" class="ayah-input form-item" rows="4" cols="23" :value="old('alamat_ayah', $ayah->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td><label for="nomor_hp_ayah">Nomor HP</label><x-input type="tel" id="nomor_hp_ayah" name="nomor_hp_ayah" class="ayah-input form-item" :value="old('nomor_hp_ayah', $ayah->nomor_hp ?? '' )"/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataIbu">
                                    <b>Data Ibu</b>
                                    <table>
                                        <tr><td><label for="nama_ibu">Nama</label><x-input type="text" id="nama_ibu" name="nama_ibu" class="ibu-input form-item" :value="old('nama_ibu', $ibu->nama ?? '' )"/></td></tr>
                                        <tr><td><label for="pendidikan_ibu">Pendidikan</label><x-input-select id="pendidikan_ibu" name="pendidikan_ibu" class="ibu-input form-item" :options="config('form-options.pendidikan')" :value="old('pendidikan_ibu', $ibu->pendidikan ?? '' )"/></td></tr>
                                        <tr><td><label for="pekerjaan_ibu">Pekerjaan</label><x-input-select id="pekerjaan_ibu" name="pekerjaan_ibu" class="ibu-input form-item" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_ibu', $ibu->pekerjaan ?? '' )"/></td></tr>
                                        <tr><td><label for="penghasilan_ibu">Penghasilan</label><x-input-select id="penghasilan_ibu" name="penghasilan_ibu" class="ibu-input form-item" :options="config('form-options.penghasilan')" :value="old('penghasilan_ibu', $ibu->penghasilan ?? '' )"/></td></tr>
                                        <tr><td><label for="alamat_ibu">Alamat</label><x-input-textarea id="alamat_ibu" name="alamat_ibu" class="ibu-input form-item" rows="4" cols="23" :value="old('alamat_ibu', $ibu->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td><label for="nomor_hp_ibu">Nomor HP</label><x-input type="tel" id="nomor_hp_ibu" name="nomor_hp_ibu" class="ibu-input form-item" :value="old('nomor_hp_ibu', $ibu->nomor_hp ?? '' )"/></td></tr>
                                    </table>
                                </div>
                                <div class="padding-10" id="dataWali">
                                    <b>Data Wali</b>
                                    <table>
                                        <tr><td><label for="nama_wali">Nama</label><x-input type="text" id="nama_wali" name="nama_wali" class="wali-input form-item" :value="old('nama_wali', $wali->nama ?? '' )"/></td></tr>
                                        <tr><td><label for="pendidikan_wali">Pendidikan</label><x-input-select id="pendidikan_wali" name="pendidikan_wali" class="wali-input form-item" :options="config('form-options.pendidikan')" :value="old('pendidikan_wali', $wali->pendidikan ?? '' )"/></td></tr>
                                        <tr><td><label for="pekerjaan_wali">Pekerjaan</label><x-input-select id="pekerjaan_wali" name="pekerjaan_wali" class="wali-input form-item" :options="config('form-options.pekerjaan')" :value="old('pekerjaan_wali', $wali->pekerjaan ?? '' )"/></td></tr>
                                        <tr><td><label for="penghasilan_wali">Penghasilan</label><x-input-select id="penghasilan_wali" name="penghasilan_wali" class="wali-input form-item" :options="config('form-options.penghasilan')" :value="old('penghasilan_wali', $wali->penghasilan ?? '' )"/></td></tr>
                                        <tr><td><label for="alamat_wali">Alamat</label><x-input-textarea id="alamat_wali" name="alamat_wali" class="wali-input form-item" rows="4" cols="23" :value="old('alamat_wali', $wali->alamat ?? '' )" placeholder="Silakan tulis alamat disini"/></td></tr>
                                        <tr><td><label for="nomor_hp_wali">Nomor HP</label><x-input type="tel" id="nomor_hp_wali" name="nomor_hp_wali" class="wali-input form-item" :value="old('nomor_hp_wali', $wali->nomor_hp ?? '' )"/></td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Form Dokumen --}}
                    <div class="padding-10">
                        <div class="flex">
                            @php
                                $chunks = collect($syaratDokumen)->chunk(ceil($syaratDokumen->count() / 2));
                            @endphp
                            @foreach ( $chunks as $chunk )
                                <div class="flex-1 content-padding-side-rem">
                                    @foreach ($chunk as $syarat)
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
                                </div>
                            @endforeach
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

</x-layouts.app-layout>
