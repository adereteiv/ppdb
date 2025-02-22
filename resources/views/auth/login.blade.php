<x-layouts.home-layout :hideFooter='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="text-align-center margin-vertical">
            <h2>Masuk</h2>
        </div>
        <div class="form-login margin-vertical">

            @if(session()->has('loginDulu'))
            <x-flash-message flash="blue">{{ session('loginDulu') }}</x-flash-message>
            @endif

            @if(session()->has('registrasiAkunBerhasil'))
            <x-flash-message flash="green">
                {{ session('registrasiAkunBerhasil') }}
            </x-flash-message>
            <x-flash-message flash>
                <h6>Perhatian!</h6>
                <p><strong class="text-center">ID Pengguna : {{ session('user_id') }}</strong></p>
                <br>
                <p><small>Salin dan simpan ID Pengguna Anda untuk keperluan login! Anda tidak akan melihat pesan ini lagi.</small></p>
            </x-flash-message>
            @endif

            @if(session()->has('loginError'))
            <x-flash-message flash="red">{{ session('loginError') }}</x-flash-message>
            @endif

            {{--
            @error('id')
            <div class="form-login_item flex justify-between reminder bg-red teks-putih margin-vertical" x-data="{ show: true }" x-show="show" >
                <span class="flex-1 align-self-center">{{ $message }}</span>
                <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
            </div>
            @enderror

            @error('password')
            <div class="form-login_item flex justify-between reminder bg-red teks-putih margin-vertical" x-data="{ show: true }" x-show="show" >
                <span class="flex-1 align-self-center">{{ $message }}</span>
                <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
            </div>
            @enderror
            --}}

            <form method="post" action="/login">@csrf
                <div class="gap">
                    <input type="text" name="id" class="form-login_item" placeholder="ID Pengguna" value="{{old('id')}}" autofocus required>
                </div>
                <div class="gap">
                    <input type="password" name="password" class="form-login_item" placeholder="Kata Sandi" required>
                </div>
                <div class="margin-vertical">
                    <button type="submit" class="form-login_item tombol-besar tombol-netral">Log In</button>
                </div>
            </form>

            <p class="form-login_item text-align-center">Belum punya Akun? <a href="/daftar">Silakan daftar</a></p>
        </div>
    </div>
</section>
</x-layouts.home-layout>
