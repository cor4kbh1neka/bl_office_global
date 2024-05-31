@if ($paginator->hasPages())
<div class="grouppagination">
    <div style="margin-right: auto;">
        @php
            $x = $paginator->currentPage();
            $y = $paginator->perPage();
            $z = $paginator->total();

            $awal = min(($x - 1) * $y + 1, $z);
            $akhir = min($x * $y, $z);
            echo "Show data $awal to $akhir from $z results.";
        @endphp
    </div>
    <div class="grouppaginationcc">
        <!-- Go to First Page -->
        {{-- @if ($paginator->onFirstPage())
            <div class="trigger left disabled">
                <span aria-label="Go to First Page" style="pointer-events: none; opacity: 0.5;">
                    First
                </span>
            </div>
        @else
            <div class="trigger left">
                <a href="{{ $paginator->url(1) }}" aria-label="Go to First Page">
                    First
                </a>
            </div>
        @endif --}}

        @if ($paginator->onFirstPage())
            <div class="trigger left">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <g fill="none" fill-rule="evenodd">
                        <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"></path>
                        <path fill="currentColor" d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z"></path>
                    </g>
                </svg>
            </div>
        @else
            <div class="trigger left">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <g fill="none" fill-rule="evenodd">
                        <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"></path>
                        <path fill="currentColor" d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z"></path>
                    </g>
                </svg></a>
            </div>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="numberpage disabled" aria-disabled="true"><span>{{ $element }}</span></span>
            @endif
            @if (is_array($element))
                @php
                    $startPage = max($paginator->currentPage() - 2, 1);
                    $endPage = min($startPage + 4, $paginator->lastPage());
                @endphp
                @foreach ($element as $page => $url)
                    @if ($page >= $startPage && $page <= $endPage)
                        @if ($page == $paginator->currentPage())
                            <span class="numberpage active" aria-current="page"><span>{{ $page }}</span></span>
                        @else
                            <a href="{{ $url }}"><span class="numberpage">{{ $page }}</span></a>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->currentPage() == $paginator->lastPage())
            <div class="trigger right disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <g fill="none" fill-rule="evenodd">
                        <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"></path>
                        <path fill="currentColor" d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z"></path>
                    </g>
                </svg>
            </div>
        @else
            <div class="trigger right">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"></path>
                            <path fill="currentColor" d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z"></path>
                        </g>
                    </svg>
                </a>
            </div>
        @endif

        <!-- Go to Last Page -->
        {{-- @if ($paginator->currentPage() == $paginator->lastPage())
            <div class="trigger right disabled">
                <span aria-label="Go to Last Page" style="pointer-events: none; opacity: 0.5;">
                    Last
                </span>
            </div>
        @else
            <div class="trigger right">
                <a href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Go to Last Page">
                    Last
                </a>
            </div>
        @endif --}}
    </div>
</div>
@endif
