<x-layouts.app-layout>
<div id="admin-pengumuman-buat" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>/admin/pengumuman</x-slot:backLink>
            <x-slot:title><h6>Buat Pengumuman</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        {{-- <div class="content-title margin-vertical">Buat Pengumuman</div> --}}
        <div class="content-padding-rem">
            <div class="constrict">
                <form method="POST" action="/admin/pengumuman/buat">@csrf
                    <div>
                        <x-inputbox class="padding-10" for="judul">
                            <x-slot:label><h6 class="flex">Judul Pengumuman</h6></x-slot>
                            <x-input type="text" name="judul" required/>
                        </x-inputbox>

                        <x-inputbox class="padding-10" for="keterangan">
                            <x-slot:label><h6 class="flex">Keterangan Pengumuman</h6></x-slot:label>
                            <x-input-textarea name="keterangan" rows="5" placeholder="" required/>
                        </x-inpubox>

                        <x-inputbox-file label="Dokumen Pelengkap" fileType="pelengkap"/>

                        <x-inputbox class="padding-10" for="jadwal_pengumuman">
                            <x-slot:label><h6 class="flex">Jadwalkan<font class="subtext" color="#FF6D00">(opsional)</font>
                            </h6></x-slot:label>
                            <x-input type="datetime-local" name="jadwal_pengumuman" placeholder=""/>
                        </x-inputbox>
                    </div>
                    <div class="content-padding-vertical text-align-center">
                        <input id="" class="tombol-besar tombol-netral" type="submit" value="Buat Pengumuman">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
