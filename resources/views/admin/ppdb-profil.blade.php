<div class="content-padding constrict">
    <x-partials.app-content-title :hideBackLink="true"><h6>Profil Pendaftar</h6></x-partials.app-content-title>
    <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
    <div class="content-padding">
        <div class="flex gap justify-center">
            <div class="flex-1">
                <div class="scrollable">
                    <img class="preview margin-vertical biodata-brief" src="{{ $dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1) ? Storage::url($dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1)->file_path) : 'https://placehold.co/188x120?text=No+Image' }}" alt="Foto Anak">
                </div>
                <div class="flex-1">
                    <div class="margin-vertical">
                        <h6 class="margin-vertical">Data Pengguna</h6>
                    </div>
                    <div class="">
                        <table class="alternate fixed detail">
                            <tr>
                                <td width="25%">ID Pengguna</td>
                                <td width="5%">:</td>
                                <td>{{ $pendaftaran->user->id }}</td>
                            </tr>
                            <tr>
                                <td>ID Pendaftaran</td>
                                <td>:</td>
                                <td>
                                    @if ($pendaftaran)
                                        {{ $pendaftaran->id }}
                                    @else
                                        <i class="teks-netral">Data tidak ditemukan</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Mendaftar Pada</td>
                                <td>:</td>
                                <td>
                                    @if ($pendaftaran)
                                        {{ ($pendaftaran->created_at)->translatedFormat('l, d F Y') }}
                                    @else
                                        <i class="teks-netral">Data tidak ditemukan</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $pendaftaran->user->email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="flex-1">
                        <h6 class="margin-vertical">Data Anak</h6>
                        <div class="">
                            <table class="alternate fixed detail">
                                @forelse ($pendaftaran->infoAnak?->getAttributes() ?? [] as $key=>$value)
                                    @if (!in_array($key, ['id', 'pendaftaran_id', 'created_at', 'updated_at']) && ($infoAnak->mendaftar_sebagai == 'Pindahan' || !in_array($key, ['sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'ke_kelompok'])))
                                        <tr>
                                            <td width="25%">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td width="5%">:</td><td>{!! $value ?? '<i class="teks-netral">Data tidak ditemukan</i>' !!}</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td><i class="teks-netral">Data tidak ditemukan</i></td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                    <div class="flex-1">
                        @foreach ($orangTuaWali->groupBy('relasi') as $relasi => $dataOrangTua)
                        <h6 class="margin-vertical">Data {{ ucfirst($relasi) }}</h6>
                        <div class="">
                            <table class="alternate fixed detail">
                                @foreach ( $dataOrangTua as $data )
                                    @foreach ( $data->getAttributes() as $key=>$value)
                                        @if (!in_array($key, ['id', 'anak_id', 'relasi', 'created_at', 'updated_at']))
                                            <tr><td width="25%">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td width="5%">:</td><td>{{ $value ?? '-' }}</td></tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h6 class="margin-vertical">Dokumen Unggahan</h6>
                    <div class="flex">
                        <div class="">
                            <table class="alternate fixed detail">
                                @forelse ( $syaratDokumen as $syarat)
                                    @php $dokumen = $dokumenPersyaratan->firstWhere('tipe_dokumen_id', $syarat->tipe_dokumen_id); @endphp
                                    <tr>
                                        <td width="25%">{{ $syarat->tipeDokumen->tipe }}</>
                                        <td width="5%">:</td>
                                        <td>
                                            @if ($dokumen && isset($dokumen->file_path))
                                                <x-preview :dokumen="$dokumen"/>
                                            @else
                                                <i class="teks-netral">Data tidak ditemukan</i>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><i class="teks-netral">Data tidak ditemukan</i></td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                    <h6 class="margin-vertical">Bukti Pembayaran</h6>
                    <div class="flex">
                        <div class="">
                            <table class="alternate fixed detail">
                                <tr>
                                    @if ($buktiBayar && isset($buktiBayar->file_path))
                                        <td width="25%">Bukti Pembayaran</td>
                                        <td width="5%">:</td>
                                        <td><x-preview :dokumen="$buktiBayar"/></td>
                                    @else
                                        <td><i class="teks-netral">Data tidak ditemukan</i></td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
