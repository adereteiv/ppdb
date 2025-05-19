<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PPDB TK Negeri Pembina Sungai Kakap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Commit 15 - Used Vite bundling, limiting js exposure based on role --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="home-layout">
        @php
            // Checks for active batch, if exists then enables daftar and login menu on header, based on isOpen
            use App\Models\BatchPPDB;
            $periodeAktif = BatchPPDB::where('status', true)->exists();
        @endphp
        @if (empty($hideHeader)) {{-- Enables hiding header, works for mobile header as well --}}
            <x-partials.home-header :isOpen="$periodeAktif"/>
        @endif
        <main class="home-main flex-1 flex flex-col">
            @if (empty($hideHeader))
                <x-partials.home-header-mobile :isOpen="$periodeAktif"/>
            @endif
            {{ $slot }}
        </main>
        @if (empty($hideContact))  {{-- Enables hiding `contact` overlay --}}
            <a class="whatsapp" href="https://wa.me/+62NO-HP-DISINI?text=Selamat%20Pagi/%20Siang/%20Sore%20Admin,%20saya%20butuh%20bantuan%20tentang%20pendaftaran%20murid%20baru%20ke%20TK%20Negeri%20Pembina%20Sungai%20Kakap.%20Apakah%20bisa%20dibantu?%20Terima%20kasih." target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 800 800" width="72" height="72">
                    <defs><clipPath id="_clipPath_A3g8G5hPEGG2L0B6hFCxamU4cc8rfqzQ"><rect width="800" height="800"/></clipPath></defs>
                    <g clip-path="url(#_clipPath_A3g8G5hPEGG2L0B6hFCxamU4cc8rfqzQ)">
                        <g>
                            <circle cx="400" cy="400" r="400" style="fill:var(--green)"/>
                            <g><path d=" M 508.558 450.429 C 502.67 447.483 473.723 433.24 468.325 431.273 C 462.929 429.308 459.003 428.328 455.078 434.22 C 451.153 440.114 439.869 453.377 436.434 457.307 C 433 461.236 429.565 461.729 423.677 458.78 C 417.79 455.834 398.818 449.617 376.328 429.556 C 358.825 413.943 347.008 394.663 343.574 388.768 C 340.139 382.873 343.207 379.687 346.155 376.752 C 348.804 374.113 352.044 369.874 354.987 366.436 C 357.931 362.999 358.912 360.541 360.875 356.614 C 362.837 352.683 361.857 349.246 360.383 346.299 C 358.912 343.352 347.136 314.369 342.231 302.579 C 337.451 291.099 332.597 292.654 328.983 292.472 C 325.552 292.301 321.622 292.265 317.698 292.265 C 313.773 292.265 307.394 293.739 301.996 299.632 C 296.6 305.527 281.389 319.772 281.389 348.752 C 281.389 377.735 302.487 405.731 305.431 409.661 C 308.376 413.592 346.949 473.062 406.015 498.566 C 420.062 504.634 431.03 508.256 439.581 510.969 C 453.685 515.451 466.521 514.818 476.666 513.302 C 487.978 511.613 511.502 499.06 516.409 485.307 C 521.315 471.55 521.315 459.762 519.842 457.307 C 518.371 454.851 514.446 453.377 508.558 450.429 Z  M 401.126 597.117 L 401.047 597.117 C 365.902 597.104 331.431 587.661 301.36 569.817 L 294.208 565.572 L 220.08 585.017 L 239.866 512.743 L 235.21 505.332 C 215.604 474.149 205.248 438.108 205.264 401.1 C 205.307 293.113 293.17 205.257 401.204 205.257 C 453.518 205.275 502.693 225.674 539.673 262.696 C 576.651 299.716 597.004 348.925 596.983 401.258 C 596.939 509.254 509.078 597.117 401.126 597.117 Z  M 567.816 234.565 C 523.327 190.024 464.161 165.484 401.124 165.458 C 271.24 165.458 165.529 271.161 165.477 401.085 C 165.46 442.617 176.311 483.154 196.932 518.892 L 163.502 641 L 288.421 608.232 C 322.839 627.005 361.591 636.901 401.03 636.913 L 401.126 636.913 L 401.127 636.913 C 530.998 636.913 636.717 531.2 636.77 401.274 C 636.794 338.309 612.306 279.105 567.816 234.565" fill-rule="evenodd" fill="rgb(255,255,255)"/>
                        </g>
                    </g>
                </svg>
            </a>
        @endif
        @if (empty($hideFooter))  {{-- Enables hiding footer --}}
            <x-partials.home-footer/>
        @endif
    </div>
    <x-modal id="data-modal" class="scrollable"/>
</body>
</html>
