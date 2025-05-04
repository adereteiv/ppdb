<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PPDB TK Negeri Pembina Sungai Kakap</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer type="module" src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="home-layout">
        @if (empty($hideHeader))
            <x-partials.home-header/>
        @endif

        <main class="flex-1 flex flex-col">
            @if (empty($hideHeader))
                <x-partials.home-header-mobile/>
            @endif
            {{ $slot }}
        </main>

        @if (empty($hideFooter))
            <x-partials.home-footer/>
        @endif
    </div>
</body>
</html>
