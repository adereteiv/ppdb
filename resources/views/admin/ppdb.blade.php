<x-layouts.app-layout>

<div class="app-content
{{-- height-100 flex flex-center --}}
">
    <div class="
    {{-- wrapper --}}
    content-padding-side-rem content-padding">
        <div class="flex-1 flex flex-col justify-around {{-- justify-center --}} text-align-center">
            <div class="flex flex-col gap content-padding-vertical">
                <h5>Arsip PPDB</h5>
                <div>
                    @if ($arsipPPDB->isNotEmpty())
                        <form action="{{ route('admin.ppdb.arsipKey') }}" method="POST" class="flex flex-col gap">@csrf
                            <div>
                                <x-input-select name="periode" :options="$arsipOptions" :value="request()->cookie('arsip_key')"/>
                            </div>
                            <div><button type="submit" class="tombol-besar tombol-netral">Akses Arsip</button></div>
                        </form>
                    @else
                        <button class="tombol-besar tombol-netral">Rekam arsip PPDB tidak ditemukan</button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap content-padding-vertical">
                <h5>PPDB Aktif</h5>
                <div>
                    @if ($aktifPPDB)
                        <a href="{{ route('admin.ppdb.aktif.index') }}" class="tombol-besar tombol-netral">Periode {{ $aktifPPDB->tahun_ajaran }} - Gel. {{ $aktifPPDB->gelombang }}</a>
                    @else
                        <button class="tombol-besar tombol-netral">Rekam PPDB aktif tidak ditemukan</button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap content-padding-vertical">
                <h5>Buka PPDB Baru</h5>
                <div>
                    <a href="{{ route('admin.ppdb.buat.index') }}" class="tombol-besar tombol-netral">Buat Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
