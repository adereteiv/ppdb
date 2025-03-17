<x-layouts.app-layout>
<div id="admin-ppdb" class="app-content wrapper ">
    <div class="content-title margin-vertical">Kelola PPDB</div>
    <div class="flex-1 flex flex-col
    justify-around
    {{-- justify-center --}}
    text-align-center">
        <div class="flex flex-col gap content-padding-vertical">
            <h3>Arsip PPDB</h3>
            <div>
                @if ($arsipPPDB->isNotEmpty())
                    <form action="admin/ppdb/arsip" methode="get" class="flex flex-col gap"> @csrf
                        <div>
                            <x-input-select name="periode" :options="$arsipOptions" required/>
                        </div>
                        <div><button href="/admin/ppdb/arsip" class="tombol-besar tombol-netral">Akses Arsip</button></div>
                    </form>
                @else
                    <span class="reminder bg-blue">Rekam arsip PPDB tidak ditemukan</span>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap content-padding-vertical">
            <h3>PPDB Aktif</h3>
            <div>
                @if ($aktifPPDB)
                    <a href="/admin/ppdb/aktif" class="tombol-besar tombol-netral">Periode {{ $aktifPPDB->tahun_ajaran }} - Gel. {{ $aktifPPDB->gelombang }} </a>
                @else
                    <span class="reminder bg-blue">Rekam PPDB aktif tidak ditemukan</span>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap content-padding-vertical">
            <h3>Buka PPDB Baru</h3>
            <div>
                <a href="/admin/ppdb/buat" class="tombol-besar tombol-netral">Buat Baru</a>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
