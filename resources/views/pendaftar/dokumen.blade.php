<x-layouts.app-layout>

@if(session()->has('success'))
<x-flash-message class="alert" flash="green">{{ session('success') }}</x-flash-message>
@endif

<div id="pendaftar-kirim-dokumen" class="app-content wrapper">
    <div class="content-title margin-vertical">Unggah Dokumen Persyaratan</div>
    <div class="scrollable">
        <div class="constrict">
            <form method="post" action="/pendaftar/dokumen" enctype="multipart/form-data"> @method('PUT') @csrf
                @foreach ($syaratDokumen as $syarat)
                    @php
                        $dokumen = $dokumenPersyaratan->where('tipe_dokumen_id', $syarat->tipe_dokumen_id)->first();
                    @endphp
                    <div class="margin-vertical">
                        <x-inputbox
                            :label="$syarat->tipeDokumen->tipe"
                            :isWajib="$syarat->is_wajib"
                            keterangan="{{ $syarat->keterangan }}"
                            :dokumen="$dokumen"
                            fileType="dokumen"
                        />

                        @if ($dokumen)
                        <x-preview class="inputbox" :dokumen="$dokumen"/>
                        @endif
                    </div>
                @endforeach

                <div class="margin-vertical text-align-center">
                    <input type="submit" class="tombol-besar tombol-netral" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<x-modal/>

</x-layouts.app-layout>
