<x-layouts.home-layout :hideHeader='true' :hideFooter='true'>
<section id="section-login" class="content-padding-side-rem">
    <div class="text-align-center margin-vertical">
        <h1>403</h1>
        <h2>Akses Ditolak</h2>
        <a href="{{ $previous }}" class="margin-vertical tombol tombol-netral">Kembali ke Dashboard</a>
        <a href="{{ $redirect }}" class="margin-vertical tombol tombol-netral">Halaman Login</a>
    </div>
</section>
</x-layouts.home-layout>
