@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif
        <?php
        $pagesCount = ceil($paginator->total()/$paginator->perPage());
        $halfLen = 2;
        $maxLen = 5;
        $startPage = 1;
        $currentPage = $paginator->currentPage();
        if ($currentPage > $halfLen) {
            if ($pagesCount - $currentPage < $maxLen - $halfLen) {
                $startPage = $pagesCount - $maxLen + 1;
                if ($startPage <= 0) {
                    $startPage = 1;
                }
            } else {
                $startPage = $currentPage - $halfLen;
            }
        }
        $rangeLen = $startPage + $maxLen - 1;
        if ($rangeLen > $pagesCount) {
            $rangeLen = $pagesCount;
        }
        $pagesRange = range($startPage, $rangeLen);
        ?>
        @foreach ($pagesRange as $pageId)
            @if ($pageId == $currentPage)
                <li class="page-item active" aria-current="page"><span class="page-link">{{ $pageId }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($pageId) }}">{{ $pageId }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
