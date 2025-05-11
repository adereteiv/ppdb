<div class="content-padding">
    <x-partials.app-content-title :hideBackLink="true"><h6>Rincian Pengumuman</h6></x-partials.app-content-title>
    <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
    <div class="constrict">
        <div>
            <h6 class="margin-vertical">Data Pengumuman</h6>
            <table class="alternate fixed detail">
                <tr>
                    <td width="25%">Posted By</td>
                    <td width="5%">:</td>
                    <td>{{ $pengumuman->user->name }} {{ $pengumuman->user->id }}</td>
                </tr>
                <tr>
                    <td>ID Pengumuman</td>
                    <td>:</td>
                    <td>
                        @if ($pengumuman)
                            {{ $pengumuman->id }}
                        @else
                            <i class="teks-netral">Data tidak ditemukan</i>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Dibuat Pada</td>
                    <td>:</td>
                    <td>
                        {{ ($pengumuman->jadwal_posting)->translatedFormat('l, d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td>Judul</td>
                    <td>:</td>
                    <td>{{ $pengumuman->judul }}</td>
                </tr>
                <tr>
                    <td>Isi Pengumuman</td>
                    <td>:</td>
                    <td>
                        {!! $pengumuman->keterangan !!}
                    </td>
                </tr>
                <tr>
                    <td>Dibuat Pada</td>
                    <td>:</td>
                    <td>
                        {{ ($pengumuman->created_at)->translatedFormat('l, d F Y') }}
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <h6 class="margin-vertical">Pratinjau Pengumuman</h6>
            <div class="frame flex justify-flex-start">
                <x-pengumuman-preview
                    :jadwal="$pengumuman->jadwal_posting"
                    :judul="$pengumuman->judul"
                    :keterangan="$pengumuman->keterangan"
                    :file="$pengumuman->file_paths"
                />
            </div>
        </div>
    </div>
</div>
