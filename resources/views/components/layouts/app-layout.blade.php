<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - PPDB TK Negeri Pembina Sungai Kakap</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div class="app-layout">
    <x-partials.app-sidenav></x-partials.app-sidenav>

    <div class="app-content-area">
        <main class="app-main scrollable content-padding">
            {{ $slot }}
        </main>
    </div>
</div>
</head>
</body>
</html>
