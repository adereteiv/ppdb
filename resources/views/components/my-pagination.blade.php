@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $start = max(1, $currentPage - 2);
    $end = min($lastPage, $currentPage + 2);
@endphp

{{-- Last and First Page belum --}}

@if ($paginator->hasPages())
    <nav class="pagination">
        @if ($currentPage > 1)
            <a class="flex flex-center page-link num-link tooltip" tooltip="top" href="{{ $paginator->previousPageUrl() }}" data-page="{{ $paginator->currentPage() - 1 }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                </svg>
                <span class="tooltiptext">Prev</span>
            </a>
        @else
            <span class="flex flex-center page-link disabled tooltip" tooltip="top">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                </svg>
                <span class="tooltiptext">Prev</span>
            </span>
        @endif

        {{--  --}}
        @if ($start > 1)
            <span>...</span>
        @endif

        {{-- Page Numbers --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page === $currentPage)
                <span class="flex flex-center page-link num-link current">{{ $page }}</span>
            @else
                <a class="flex flex-center page-link num-link" href="{{ $paginator->url($page) }}" data-page="{{ $page }}">{{ $page }}</a>
            @endif
        @endfor

        {{-- @foreach ($elements as $element)
            @if (is_string($element))
                <span>...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page === $paginator->currentPage())
                        <span class="flex flex-center page-link num-link current">{{ $page }}</span>
                    @else
                        <a class="flex flex-center page-link num-link" href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach --}}

        {{--  --}}
        @if ($end < $lastPage)
            <span>...</span>
        @endif

        @if ($currentPage < $lastPage)
            <a class="flex flex-center page-link num-link tooltip" tooltip="top" href="{{ $paginator->nextPageUrl() }}" data-page="{{ $paginator->currentPage() + 1 }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                <span class="tooltiptext">Next</span>
            </a>
        @else
            <span class="flex flex-center page-link disabled tooltip" tooltip="top">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                <span class="tooltiptext">Next</span>
            </span>
        @endif
    </nav>
@endif
