<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- refer to form1.js --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard @auth{{ Auth::user()->role_id == 1 ? 'Admin' : 'Pendaftar' }}@endauth -  PPDB TK Negeri Pembina Sungai Kakap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Commit 15 - Used Vite bundling, limiting js exposure based on role --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(auth()->check() && auth()->user()->role_id == 1)
        @vite('resources/js/admin.js')
    @endif
    <script> //  Immediately Invoked Function Expression (IIFE), solely for #appNavbar.
        (function () {
            const navbarId = "appNavbar";

            document.addEventListener("DOMContentLoaded", () => {
                const navbar = document.getElementById(navbarId);
                if (!navbar) return;

                // Restore saved class
                const stored = sessionStorage.getItem("navbarClasses");
                if (stored) {
                    navbar.className = stored;
                }

                // Save on any class change
                new MutationObserver(() => {
                    sessionStorage.setItem("navbarClasses", navbar.className);
                }).observe(navbar, { attributes: true, attributeFilter: ["class"] });
            });
        })();
    </script>
</head>
<body>
    <div class="app-layout">
        {{-- Centralized session messages handling --}}
        @if (session()->has('success'))
        <x-flash-message class='shadow' mode='alert success'>{{ session('success') }}</x-flash-message>
        @endif

        @if (session()->has('error'))
        <x-flash-message class='shadow' mode='alert error'>{{ session('error') }}</x-flash-message>
        @endif

        @if (session()->has('warn'))
        <x-flash-message class='shadow' mode='alert warn'>{{ session('warn') }}</x-flash-message>
        @endif

        @if (session()->has('check'))
        <x-flash-message class='shadow' alert="blue" icon="success">{{ session('check') }}</x-flash-message>
        @endif

        <x-partials.app-navbar/> {{-- Normal navbar --}}
        <x-modal id="appNavMobile"> {{-- Mobile navbar, use static modal --}}
            <x-slot:button-data-attributes>data-toggle-target="#appNavMobile" data-toggle-mode="close"</x-slot:button-data-attributes>
            <x-partials.app-navbar-mobile/>
        </x-modal>
        <div class="app-content-area scrollable" class="">
            <x-partials.app-header/> {{-- Header --}}
            <main>
                <div class="container">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    {{-- Modal for data-url, refer to modal.js --}}
    <x-modal id="data-modal" class="scrollable"/>
</body>
</html>
