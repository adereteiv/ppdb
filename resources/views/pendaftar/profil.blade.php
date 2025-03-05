<x-layouts.app-layout>

<div id="pendaftar-biodata" class="app-content wrapper">
    <div class="margin-vertical"><h3>Profil Pendaftar</h3></div>
    <div class="biodata">
        <div class="biodata-brief gap">
            <img class="preview" src="{{ $dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1) ? Storage::url($dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1)->file_path) : 'https://placehold.co/188x120?text=No+Image' }}" alt="Foto Anak">

            <table>
                <tr>
                    <td width="150px">ID Pengguna</td>
                    <td>:</td>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <td>ID Pendaftaran</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->id }}</td>
                </tr>
                <tr>
                    <td>Mendaftar Pada</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->created_at }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $user->email }}</td>
                </tr>
            </table>
        </div>
        <div class="flex-1 biodata-info scrollable">
            <div>
                <h3 class="content-padding-no-top">Data Pendaftar</h3>
                <div class="flex">
                    <div class="flex-1">
                        <div class="content-padding-no-top">
                            <h6>Data Anak</h6>
                            <table>
                                @foreach ($infoAnak->getAttributes() as $key=>$value)
                                    @if (!in_array($key, ['id', 'pendaftaran_id', 'created_at', 'updated_at']) && ($infoAnak->mendaftar_sebagai == 'Pindahan' || !in_array($key, ['sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'ke_kelompok'])))
                                        <tr>
                                            <td width="150px">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td>:</td><td>{{ $value ?? '-' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="flex-1">
                        @foreach ($orangTuaWali->groupBy('relasi') as $relasi => $dataOrangTua)
                        <div class="content-padding-no-top">
                            <h6>Data {{ ucfirst($relasi) }}</h6>
                            <table>
                                @foreach ( $dataOrangTua as $data )
                                    @foreach ( $data->getAttributes() as $key=>$value)
                                        @if (!in_array($key, ['id', 'anak_id', 'relasi', 'created_at', 'updated_at']))
                                            <tr><td width="150px">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td>:</td><td>{{ $value ?? '-' }}</td></tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <h3 class="content-padding-no-top">Dokumen Unggahan</h3>
                <div class="flex">
                    @foreach ( $syaratDokumen as $syarat)
                        @php $dokumen = $dokumenPersyaratan->firstWhere('tipe_dokumen_id', $syarat->tipe_dokumen_id); @endphp
                        <div class="content-padding-no-top">
                            <h6>{{ $syarat->tipeDokumen->tipe }}</h6>
                            <table>
                                <td>
                                    @if ($dokumen && isset($dokumen->file_path))
                                        <x-preview :dokumen="$dokumen"/>
                                    @else
                                        <i class="teks-netral">Dokumen belum diunggah</i>
                                    @endif
                                </td>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="content-padding-no-top">Bukti Pembayaran</h3>
                <div class="flex">
                    <div class="content-padding-no-top">
                        <td>
                            @if ($buktiBayar && isset($buktiBayar->file_path))
                                <x-preview :dokumen="$buktiBayar"/>
                            @else
                                <i class="teks-netral">Dokumen belum diunggah</i>
                            @endif
                        </td>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal/>

</x-layouts.app-layout>
