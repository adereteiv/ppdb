<x-layouts.home-layout :hideHeader='true' :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h2>{{ $title }}</h2>
            </div>
            <x-flash-message flash="blue">
                <p>Hai, <b>{{ $nama }}</b>!</p>
            </x-flash-message>
            <p><b>Simpan data berikut untuk keperluan log in!</b></p>
            <br>
            <p><strong>User ID:</strong> {{ $user_id }}</p>
            <p><strong>Nomor HP:</strong> {{ $nomor_hp }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <x-flash-message flash="red" icon="warn">
                <p><b>Screenshot bila perlu, Anda tidak akan melihat pesan ini lagi!</b></p>
                <p><strong>Halaman ini akan hilang dalam: <x-scripts.live-timer :expiry="now()->diffInSeconds($ttl)"/></strong></p>
            </x-flash-message>
            <div class="margin-vertical">
                <a class="tombol-besar tombol-netral" href="/login">Lanjut ke Halaman Log In</a>
            </div>
        </div>
    </div>
</section>
</x-layouts.home-layout>
