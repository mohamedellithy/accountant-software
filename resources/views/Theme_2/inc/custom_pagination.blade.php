@if ($paginator->hasPages())
    <ul class="pagination pagination-sm justify-content-center mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link"><i class="bx bx-chevron-right"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bx bx-chevron-right"></i></a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            
            // Limit to at most 4 page numbers.
            $start = max(1, $currentPage - 1);
            $end = min($lastPage, $start + 3);
            
            // Adjust start page if range is less than 4
            if ($end - $start < 3) {
                $start = max(1, $end - 3);
            }
        @endphp

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endif
        @endfor

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bx bx-chevron-left"></i></a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link"><i class="bx bx-chevron-left"></i></span>
            </li>
        @endif
    </ul>
@endif
