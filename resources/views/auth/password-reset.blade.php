<x-layouts.home-layout :hideHeader='true' :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h2>Ubah Kata Sandi</h2>
            </div>
            <form method="POST" action="{{ route('password_reset.update', ['token' => $token, 'id' => $id]) }}">@csrf
                <div>
                    <div class="margin-vertical">
                        Kata Sandi Baru
                        <x-input-password name="password" placeholder="Kata sandi, min. 8 karakter"/>
                    </div>
                    <div class="margin-vertical">
                        Konfirmasi Kata Sandi
                        <x-input-password name="password_confirmation" placeholder="Masukkan ulang kata sandi"/>
                    </div>
                    <div class="margin-vertical">
                        {{-- js to prevent double submission by clicking too fast --}}
                        <button type="submit" class="tombol-besar tombol-netral" onclick="this.disabled=true; this.form.submit();">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</x-layouts.home-layout>
