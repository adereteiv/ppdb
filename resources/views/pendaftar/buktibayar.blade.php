<x-layouts.app-layout>

<div id="pendaftar-buktibayar" class="app-content">
    <div class="wrapper">
        <x-partials.app-content-title :hideBackLink="true"><h6>Unggah Bukti Pembayaran</h6></x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding-side-rem constrict">
            <div class="content-margin">
                @if ($pendaftaran->status == 'Menunggu' && $buktiBayar)
                    <x-flash-message flash='yellow'>
                        Menunggu verifikasi pembayaran dari admin.
                    </x-flash-message>
                @elseif ($pendaftaran->status !== 'Menunggu' && $buktiBayar)
                    <x-flash-message flash='green'>
                        Pembayaran terverifikasi.
                    </x-flash-message>
                @endif
                <x-flash-message flash='blue'>
                    <ul>
                        <li>Harap mengunggah bukti pembayaran Anda.</li>
                        <li>Pembayaran dapat dilakukan ke rekening XXXX-XXXX.</li>
                        <li>Informasi lebih lengkap dapat dilihat pada menu Beranda, atau hubungi operator.</li>
                    </ul>
                </x-flash-message>
            </div>
            <form id="payForm" method="POST" action="{{ route('pendaftar.bukti_bayar.update') }}" enctype="multipart/form-data"> @method('PUT') @csrf
                <div class="margin-vertical">
                    <x-inputbox-file
                        label="Bukti Bayar"
                        isWajib="true"
                        fileType="bukti_bayar"
                        keterangan="Unggah bukti pembayaran Anda disini"
                        :dokumen="$buktiBayar"/>
                </div>

                <div class="margin-vertical flex flex-center text-align-center content-padding-vertical">
                    <input class="tombol-besar tombol-netral" type="submit" value="Simpan">
                </div>
                <x-scripts.submit-button form="payForm"/>
            </form>
        </div>
    </div>
</div>

</x-layouts.app-layout>
