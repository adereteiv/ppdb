<x-layouts.home-layout :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h2>Masuk</h2>
            </div>
            @if (session()->has('loginDulu'))
            <x-flash-message button flash="blue">{{ session('loginDulu') }}</x-flash-message>
            @endif

            {{-- Moved to view('auth.cred')
            @if (session()->has('success'))
            <x-flash-message button flash="green">
                {{ session('success') }}
            </x-flash-message>
            <x-flash-message flash="blue">
                <h6>Perhatian!</h6>
                <hr>
                <p><small>Harap untuk tidak me-<em>refresh</em> halaman untuk menyalin ID Pengguna dan Kata Sandi Anda demi keperluan login!</small></p>
                <p>ID Pengguna:
                    <strong>
                        <span id="userId" class="text-center">{{ session('user_id') }}</span>
                        <button id="copyButton" class="tombol-none tooltip inline-block" tooltip="right">
                            <span id="tooltiptext" class="tooltiptext">Salin</span>
                            <i class="bi bi-copy"></i>
                        </button>
                    </strong>
                </p>
                <p>Nomor HP:
                    <strong>{{ session('nomor_hp') }}</strong>
                </p>
                <p>Kata Sandi:
                    <strong>{{ session('password') }}</strong>
                </p>
                <br>
            </x-flash-message>
            @endif --}}

            @if (session()->has('error'))
            <x-flash-message button flash>{{ session('error') }}
                @if (session()->has('ttl'))
                    <x-scripts.live-timer :expiry="session('ttl')"/>.
                @endif
            </x-flash-message>
            @endif

            <form method="POST" action="{{ route('loginPendaftar') }}">@csrf
                <div>
                    <div class="margin-vertical">
                        Nomor HP/WA atau ID Pengguna
                        <x-input type="text" name="id" placeholder="Sesuai yang didaftarkan" autofocus required/>
                    </div>
                    <div class="margin-vertical">
                        Kata Sandi
                        <x-input type="password" name="password" placeholder="Masukkan kata sandi" required/>
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
