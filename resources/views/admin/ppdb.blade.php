<x-layouts.app-layout>
<div id="admin-ppdb" class="app-content wrapper ">
    <div class="content-title margin-vertical">Kelola PPDB</div>
    <div class="text-align-center">
        <div class="flex flex-col gap content-padding-vertical">
            <h3>Arsip PPDB</h3>
            <div class="flex flex-col gap">
                <div>
                    <select title="" id="">
                        <option value="" disabled selected>&nbsp;Pilih Arsip ---</option>
                        {{-- foreach --}}
                        {{-- {{route(from-which-ppdb with-id => selected_id] )}} --}}
                        <option value="">Slot{Periode 2022/2023}</option>
                    </select>
                </div>
                <div><a href="/admin/ppdb/arsip" class="tombol-besar tombol-netral">Akses Arsip</a></div>
            </div>
        </div>

        <div class="flex flex-col gap content-padding-vertical">
            <h3>PPDB Aktif</h3>
            <div>
                <!-- disabled if there's no active ppdb and the slot changes into text "tidak ada ppdb aktif" dan tidak akan prompt kemana mana -->
                <a href="/admin/ppdb/ppdb-aktif" class="tombol-besar tombol-netral">Slot{Periode 20XX/20XX}</a>
            </div>
        </div>

        <div class="flex flex-col gap content-padding-vertical">
            <h3>Buka PPDB Baru</h3>
            <div><a href="/admin/ppdb/buat" class="tombol-besar tombol-netral">Buat Baru</a></div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
