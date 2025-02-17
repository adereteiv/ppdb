<x-layouts.home-layout :hideHeader='true' :hideFooter='true'>
<section id="section-login" class="">
    <div class="text-align-center margin-vertical">
        <a href="{{ url()->previous() }}" class="margin-vertical tombol tombol-netral"></a>
        <h1>403</h1>
        <h2>Akses Ditolak</h2>
        <a href="{{ $redirect }}" class="margin-vertical tombol tombol-netral">Login terlebih dahulu</a>
    </div>
</section>
</x-layouts.home-layout>
