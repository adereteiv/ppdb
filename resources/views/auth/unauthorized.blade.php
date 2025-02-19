<x-layouts.home-layout :hideHeader='true' :hideFooter='true'>
<section id="section-login" class="">
    <div class="text-align-center margin-vertical">
        <h1>403</h1>
        <h2>Akses Ditolak</h2>
        <a href="{{ url()->previous() }}" class="margin-vertical tombol tombol-netral">Halaman Sebelumnya</a>
        <a href="{{ $redirect }}" class="margin-vertical tombol tombol-netral">Halaman Login</a>
    </div>
</section>
</x-layouts.home-layout>
