<x-layouts.home-layout :hideHeader='true' :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h2>Konfirmasi PIN Ganti Kata Sandi</h2>
            </div>
            <form method="POST" action="{{ route('password_reset.pin', $token) }}">@csrf
                <div>
                    <div class="margin-vertical">
                        PIN
                        <x-input type="text" name="pin" placeholder="Masukkan PIN disini"/>
                        @if (session()->has('error'))
                            <br><p class="flex flex-start teks-negatif">{{ session('error') }}</p>
                        @endif
                    </div>
                    <div class="margin-vertical">
                        {{-- js to prevent double submission by clicking too fast --}}
                        <button type="submit" class="tombol-besar tombol-netral" onclick="this.disabled=true; this.form.submit();">Konfimasi PIN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</x-layouts.home-layout>
