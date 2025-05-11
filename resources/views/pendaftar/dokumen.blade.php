<x-layouts.app-layout>

<div id="pendaftar-kirim-dokumen" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Unggah Dokumen Persyaratan</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="scrollable">
            <div class="content-padding-side-rem constrict">
                <div class="content-padding-side">
                    <x-flash-message flash='blue'>
                        Harap mengunggah dokumen persyaratan sesuai yang tertera pada formulir berikut. Ukuran maksimal berkas sebesar 1MB.
                    </x-flash-message>
                </div>
                <form id="docsForm" method="POST" action="{{ route('pendaftar.dokumen.update') }}" enctype="multipart/form-data"> @method('PUT') @csrf
                    @foreach ($syaratDokumen as $syarat)
                        @php $dokumen = $dokumenPersyaratan?->where('tipe_dokumen_id', $syarat->tipe_dokumen_id)->first(); @endphp
                        <div class="margin-vertical">
                            <x-inputbox-file
                                :label="$syarat->tipeDokumen->tipe"
                                :isWajib="$syarat->is_wajib"
                                keterangan="{{ $syarat->keterangan }}"
                                fileType="dokumen"
                                :dokumen="$dokumen"
                            />
                        </div>
                    @endforeach

                    <div class="margin-vertical text-align-center content-padding-vertical">
                        <input type="submit" class="tombol-besar tombol-netral" value="Simpan">
                    </div>
                    <x-scripts.submit-button form="docsForm"/>
                </form>
            </div>
        </div>
    </div>
</div>

</x-layouts.app-layout>
