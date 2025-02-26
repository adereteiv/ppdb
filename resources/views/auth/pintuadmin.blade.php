<x-layouts.home-layout :hideHeader='true' :hideFooter='true'>
<section id="section-login" class="">
    <div class="text-align-center margin-vertical">
        <h1>Login Admin</h1>
    </div>
    <div class="container">
        <div class="form-login margin-vertical">

            @if(session()->has('error'))
            <x-flash-message flash="red">{{ session('error') }}</x-flash-message>
            @endif

            @error('email')
            <x-flash-message flash="red">{{ $message }}</x-flash-message>
            @enderror
            {{--

            @error('password')
            <div class="form-login_item flex justify-between reminder bg-red teks-putih margin-vertical" x-data="{ show: true }" x-show="show" >
                <span class="flex-1 align-self-center">{{ $message }}</span>
                <div><button class="tombol tombol-negatif" @click="show = false"><i class="bi bi-x-lg"></i></button></div>
            </div>
            @enderror
            --}}

            <form method="POST" action="/pintuadmin">@csrf
                <div class="gap">
                    <x-input type="email" name="email" class="form-login_item" placeholder="Email Admin" autofocus required/>
                    {{-- <input type="email" name="email" class="form-login_item"  placeholder="Email Admin" value="{{ old('email') }}" autofocus required> --}}
                </div>
                <div class="gap">
                    <x-input type="password" name="password" class="form-login_item" placeholder="Kata sandi" required/>
                    {{-- <input type="password" name="password" class="form-login_item" placeholder="Kata Sandi" required> --}}
                </div>
                <div class="margin-vertical">
                    <button type="submit" class="form-login_item tombol-besar tombol-netral">Log In</button>
                </div>
            </form>
        </div>
    </div>
</section>
</x-layouts.home-layout>
