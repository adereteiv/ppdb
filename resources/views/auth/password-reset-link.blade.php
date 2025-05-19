<x-layouts.home-layout :hideHeader='true' :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <x-partials.app-content-title :backLink="route('admin.ppdb.aktif.edit', $pendaftaran->id)">
            <x-slot:title><h6>Link dan PIN Ganti Kata Sandi</h6></x-slot:title>
        </x-partials.app-content-title>
        <hr style="border: 1px solid rgba(0, 0, 0, .15); margin: 0 1rem;">
        <div class="content-padding-side-rem margin-vertical">
            <p><strong>Link:</strong></p>
            <p>{{ $link }}</p>
            <p><strong>PIN Konfirmasi:</strong> {{ $data['pin'] }}</p>
            <br>
            <p><strong>Link dan PIN akan kedaluwarsa ketika pendaftar berhasil mengganti kata sandi atau masa aktif token sudah habis.</strong></p>
            <x-flash-message class="bg-blue">
            <p>Masa aktif token (menit): <x-scripts.live-timer :expiry="now()->diffInSeconds($data['ttl'])"/></p>
            </x-flash-message>
        </div>
    </div>
</section>
</x-layouts.home-layout>
