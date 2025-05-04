<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- refer to syaratDokumen.js --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard @auth{{ Auth::user()->role_id == 1 ? 'Admin' : 'Pendaftar' }}@endauth -  PPDB TK Negeri Pembina Sungai Kakap</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer type="module" src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="app-layout">
        <x-partials.app-navbar/>

        <div class="app-content-area scrollable" class="">
            <x-partials.app-header/>
            <main>
                <div class="container">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <x-modal id="data-modal" class="scrollable"/>
</body>
</html>
