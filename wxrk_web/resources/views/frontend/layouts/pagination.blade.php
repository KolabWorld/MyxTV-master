<div class="pagination_rounded pr-4">
    @if ($paginator->hasPages())
        <ul>
            @if ($paginator->onFirstPage())
                <li>
                    <a href="#" class="prev"> 
                        <i class="fa fa-chevron-left"></i> 
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="prev"> 
                        <i class="fa fa-chevron-left"></i> 
                    </a>
                </li>
            @endif
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="visible-xs">
                        <a href="#">{{ $element }}</a> 
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="hidden-xs active">
                                <a href="#" class="active">
                                    {{ $page }}
                                </a> 
                            </li>
                        @else
                            <li class="hidden-xs d-none d-sm-inline-block">
                                <a href="{{ $url }}">{{ $page }}</a> 
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="prev next"> 
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </a>
                </li>
            @else
                <li>
                    <a href="#" class="prev next"> 
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </a>
                </li>
            @endif
        </ul>
    @endif
</div>
