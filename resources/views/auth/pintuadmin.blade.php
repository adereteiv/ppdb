<x-layouts.home-layout :hideHeader='true' :hideFooter='true' :hideContact='true'>
<section id="section-login" class="home-section">
    <div class="container">
        <div class="content-padding-side-rem">
            <div class="text-align-center margin-vertical">
                <h1>Login Admin</h1>
            </div>
            @if (session()->has('success'))
                <x-flash-message mode="flash success">{{ session('success') }}</x-flash-message>
            @elseif (session()->has('error'))
                <x-flash-message button flash>{{ session('error') }}
                    @if (session()->has('ttl'))
                        <x-scripts.live-timer :expiry="session('ttl')"/>.
                    @endif
                </x-flash-message>
            @endif

            <form method="POST" action="{{ route('loginAdmin') }}">@csrf
                <div>
                    <div class="margin-vertical">
                        <x-input type="email" name="email" placeholder="Email Admin" autofocus required/>
                    </div>
                    <div class="margin-vertical">
                        <x-input type="password" name="password" placeholder="Kata sandi" required/>
                    </div>
                    <div class="margin-vertical">
                        <button type="submit" class="tombol-besar tombol-netral">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</x-layouts.home-layout>
