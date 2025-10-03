<x-layouts.home-layout :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h2>Masuk</h2>
            </div>
            @if (session()->has('loginDulu'))
                <x-flash-message button flash="blue">{{ session('loginDulu') }}</x-flash-message>
            @elseif (session()->has('success'))
                <x-flash-message mode="flash success">{{ session('success') }}</x-flash-message>
            @elseif (session()->has('error'))
                <x-flash-message button flash>{{ session('error') }}
                    @if (session()->has('ttl'))
                        <x-scripts.live-timer :expiry="session('ttl')"/>.
                    @endif
                </x-flash-message>
            @endif

            <form method="POST" action="{{ route('login.send') }}">@csrf
                <div>
                    <div class="margin-vertical">
                        ID Pengguna atau Nomor HP/WA
                        <x-input type="text" name="id" placeholder="" autocomplete="username" autofocus required/>
                    </div>
                    <div class="margin-vertical">
                        Kata Sandi
                        <x-input-password name="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required/>
                    </div>
                    <div class="margin-vertical">
                        {{-- js to prevent double submission by clicking too fast --}}
                        <button type="submit" class="tombol-besar tombol-netral" onclick="this.disabled=true; this.form.submit();">Log In</button>
                    </div>
                </div>
            </form>
            <div class="margin-vertical">
                <p class="text-align-center">Buat Akun baru? <a href="/daftar">Silakan daftar</a></p>
            </div>
        </div>
    </div>
</section>
</x-layouts.home-layout>
