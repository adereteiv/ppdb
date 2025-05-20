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
            <p><b>Screenshot bila perlu, Anda tidak akan melihat pesan ini lagi!</b></p>
            <br>
            <table class="alternate">
                <tr class="copyCred">
                    <td width="1rem"><strong>User ID</strong></td>
                    <td> {{ $user_id }}</td>
                </tr>
                <tr class="copyCred">
                    <td><strong>Nomor HP</strong></td>
                    <td> {{ $nomor_hp }}</td>
                </tr>
                <tr x-data="{ show: false }">
                    <td><strong>Password: </strong></td>
                    <td class="flex justify-between">
                        <span x-text="show ? '{{ $password }}' : '{{ str_repeat('*', strlen($password)) }}'"></span>
                        <button @click="show = !show" type="button" class="tombol-none">
                            <i x-show="!show" x-cloak class="bi bi-eye"></i>
                            <i x-show="show" x-cloak class="bi bi-eye-slash"></i>
                        </button>
                    </td>
                </tr>
            </table>
            <p class="copyCred" style="display: none;"><strong>Password:</strong> {{ $password }}</p>
            <button class="content-margin-top inline-block text-align-left copyButton tombol-mini tombol-netral tooltip" data-target=".copyCred" data-tooltip="#tooltip1" data-label="Grup 1: " tooltip="bottom">
                <span id="tooltip1" class="tooltiptext">Salin</span>
                <span>Salin</span>
                <i class="bi bi-copy"></i>
            </button>
            <br>
            <x-flash-message flash="red" icon="warn">
                <p><strong>Halaman ini akan hilang dalam: <x-scripts.live-timer :expiry="now()->diffInSeconds($ttl)"/></strong></p>
            </x-flash-message>
            <div class="margin-vertical">
                <a class="tombol-besar tombol-netral" href="/login">Lanjut ke Halaman Log In</a>
            </div>
        </div>
    </div>
</section>
</x-layouts.home-layout>
