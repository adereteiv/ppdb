<x-layouts.app-layout>

<div id="pendaftar-biodata" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Profil Pendaftar</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="flex content-padding-rem">
            <div class="constrict">
                <div class="flex gap justify-center">
                    <div class="scrollable">
                        <img class="biodata-brief" alt="Foto Anak"
                        src="{{ $dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1)
                        ? Storage::url($dokumenPersyaratan->firstWhere('tipe_dokumen_id', 1)->file_path)
                        : asset('static/user.png') }}"
                        {{-- : 'https://placehold.co/188x120?text=No+Image' }}" --}}
                        >
                    </div>
                    <div class="flex-1">
                        <h6 class="content-padding-bottom-rem">Data Pendaftar</h6>
                        <table class="alternate fixed detail">
                            <tr>
                                <td width="25%">ID Pengguna</td>
                                <td width="8%">:</td>
                                <td>{{ $user->id }}</td>
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
                                        {{ ($pendaftaran->created_at)->translatedFormat('l, d F Y, H:m:i') }}
                                    @else
                                        <i class="teks-netral">Data tidak ditemukan</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Status Pendaftaran</td>
                                <td>:</td>
                                <td>
                                    @if ($pendaftaran)
                                        <x-status-pendaftaran :value="$pendaftaran->status ?? null"/>
                                    @else
                                        <i class="teks-netral">Data tidak ditemukan</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Nomor HP/WA</td>
                                <td>:</td>
                                <td>{{ $user->nomor_hp }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="margin-vertical" x-data="{ activeTab: 'tabA' }">
                    <div class="flex">
                        <span class="tab-head" :class="{ 'active' : activeTab === 'tabA' }" @click="activeTab = 'tabA'">Data Formulir</span>
                        <span class="tab-head" :class="{ 'active' : activeTab === 'tabB' }" @click="activeTab = 'tabB'">Dokumen Unggahan</span>
                        <span class="tab-head" :class="{ 'active' : activeTab === 'tabC' }" @click="activeTab = 'tabC'">Bukti Pembayaran</span>
                    </div>
                    <div class="biodata frame scrollable content-padding-rem">
                        <div class="tab-panel" x-show="{ activeTab: 'tabA' }" :class="{ 'show' : activeTab === 'tabA' }">
                            <div class="">
                                <h6 class="">Data Anak</h6>
                                <table class="alternate fixed detail margin-vertical">
                                    @forelse ($infoAnak?->getAttributes() ?? [] as $key=>$value)
                                        @if (!in_array($key, ['id', 'pendaftaran_id', 'created_at', 'updated_at']) && ($infoAnak->mendaftar_sebagai == 'Pindahan' || !in_array($key, ['sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'ke_kelompok'])))
                                            <tr>
                                                <td width="25%">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td width="8%">:</td><td>{!! $value ?? '<i class="teks-netral">Data tidak ditemukan</i>' !!}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td><i class="teks-netral">Data tidak ditemukan</i></td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                            @foreach ($orangTuaWali->groupBy('relasi') as $relasi => $dataOrangTua)
                                <div class="">
                                    <h6 class="">Data {{ ucfirst($relasi) }}</h6>
                                    <table class="alternate fixed detail margin-vertical">
                                        @foreach ( $dataOrangTua as $data )
                                            @foreach ( $data->getAttributes() as $key=>$value)
                                                @if (!in_array($key, ['id', 'anak_id', 'relasi', 'created_at', 'updated_at']))
                                                    <tr><td width="25%">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td width="8%">:</td><td>{{ $value ?? '-' }}</td></tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-panel" x-show="{ activeTab: 'tabB' }" :class="{ 'show' : activeTab === 'tabB' }">
                            <h6 class="">Dokumen Unggahan</h6>
                            <table class="alternate fixed detail margin-vertical">
                                @forelse ( $syaratDokumen as $syarat)
                                    @php $dokumen = $dokumenPersyaratan->firstWhere('tipe_dokumen_id', $syarat->tipe_dokumen_id); @endphp
                                    <tr>
                                        <td width="25%">{{ $syarat->tipeDokumen->tipe }}</>
                                        <td width="8%">:</td>
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
                        <div class="tab-panel" x-show="{ activeTab: 'tabC' }" :class="{ 'show' : activeTab === 'tabC' }">
                            <h6 class="">Bukti Pembayaran</h6>
                            <table class="alternate fixed detail margin-vertical">
                                <tr>
                                    @if ($buktiBayar && isset($buktiBayar->file_path))
                                        <td width="25%">Bukti Pembayaran</td>
                                        <td width="8%">:</td>
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

</x-layouts.app-layout>
