<x-layouts.app-layout>

@if(session()->has('success'))
<x-flash-message class="alert" flash="green">{{ session('success') }}</x-flash-message>
@endif

<div id="pendaftar-buktibayar" class="app-content wrapper">
    <div class="content-title margin-vertical">Unggah Bukti Pembayaran</div>
    <div class="constrict">
        <form method="post" action="/pendaftar/buktibayar" enctype="multipart/form-data"> @method('PUT') @csrf
            <div class="margin-vertical">
                <x-inputbox-file
                label="Bukti Bayar"
                isWajib="true"
                fileType="bukti_bayar"
                keterangan="Unggah bukti pembayaran Anda disini"
                :dokumen="$buktiBayar"/>

                @if ($buktiBayar)
                <x-preview class="inputbox" :dokumen="$buktiBayar"/>
                @endif
            </div>

            <div class="margin-vertical text-align-center">
                <input class="tombol-besar tombol-netral" type="submit" value="Simpan">
            </div>
        </form>
    </div>
</div>

<x-modal/>

</x-layouts.app-layout>
