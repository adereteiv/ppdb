@props(['jadwal' => null, 'judul' => null, 'keterangan' => null, 'file' => null])

<div class="text-align-start">
    <div class="content-padding-vertical content-padding-side-rem">
        <h5>{{ $judul }}</h5>
        <p class="teks-netral"><i>{{ $jadwal }}</i><span class="subtext"> •</span></p>
    </div>
    <div class="justify-list content-padding-side-rem content-padding-bottom-rem">
        <div>{!! $keterangan !!}</div>
        @if ($file)
            <div class="margin-vertical"><strong>Lampiran :</strong>
                @foreach ($file as $lampiran)
                    {{-- <a href="{{ asset('storage/' . $lampiran) }}" target="_blank" rel="noopener">{{ $lampiran }}</a> --}}
                    <p><a href="{{ asset('storage/' . $lampiran) }}" target="_blank" rel="noopener" style="text-decoration: none; color: var(--blue);">{{ basename($lampiran) }}</a></p>
                @endforeach
            </div>
        @endif
    </div>
</div>
{{-- <x-pengumuman-preview :jadwal="" judul="" :keterangan="" :file=""/> --}}
