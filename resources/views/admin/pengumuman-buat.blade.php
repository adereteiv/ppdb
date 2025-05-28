<x-layouts.app-layout>
<div id="admin-pengumuman-buat" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title>
            <x-slot:backLink>{{ route('admin.pengumuman.index') }}</x-slot:backLink>
            <x-slot:title><h6>Buat Pengumuman</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        {{-- <div class="content-title margin-vertical">Buat Pengumuman</div> --}}
        <div class="content-padding-rem">
            <div class="constrict">
                <div class="content-margin">
                    <x-flash-message flash='blue'>
                        Tipe, Judul, dan Keterangan Pengumuman wajib dicantumkan.
                    </x-flash-message>
                </div>
                <form method="POST" action="{{ route('admin.pengumuman.store') }}" enctype="multipart/form-data">@csrf
                    <div>
                        <x-inputbox class="padding-10" for="tipe_pengumuman">
                            <x-slot:label><b>Tipe Pengumuman</b><sup class="subtext" style="color:#FF0000;">*</sup></x-slot>
                            <x-input-radio id="tipe_pengumuman" type="text" name="tipe_pengumuman" :options="config('form-options.tipe_pengumuman')" required/>
                        </x-inputbox>
                        <x-inputbox class="padding-10" for="judul">
                            <x-slot:label><b>Judul Pengumuman</b><sup class="subtext" style="color:#FF0000;">*</sup></x-slot>
                            <x-input type="text" id="judul" name="judul" required/>
                        </x-inputbox>
                        <x-inputbox class="padding-10" for="editor">
                            <x-slot:label><b>Keterangan Pengumuman</b><sup class="subtext" style="color:#FF0000;">*</sup></x-slot:label>
                            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
                            <x-input-textarea id="editor" name="keterangan" placeholder=""/>
                            <script>
                                ClassicEditor.create(document.querySelector('#editor'));
                            </script>
                        </x-inpubox>
                        <x-inputbox-file label="Lampiran" fileType="lampiran" multiple/>
                        <x-inputbox class="padding-10" for="jadwal">
                            <x-slot:label><b>Jadwalkan<sup class="subtext" style="color:#2962ff">(opsional)</sup></b></x-slot:label>
                            <x-input type="datetime-local" id="jadwal" name="jadwal_posting" placeholder=""/>
                        </x-inputbox>
                    </div>
                    <div class="content-padding-vertical text-align-center">
                        <input class="tombol-besar tombol-netral" type="submit" value="Buat Pengumuman">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layouts.app-layout>
