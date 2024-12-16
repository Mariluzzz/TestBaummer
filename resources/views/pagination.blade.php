@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Botão de Página Anterior --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span><i class="material-icons">chevron_left</i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="material-icons">chevron_left</i></a></li>
        @endif

        {{-- Links das páginas --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @elseif (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botão de Próxima Página --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="material-icons">chevron_right</i></a></li>
        @else
            <li class="disabled"><span><i class="material-icons">chevron_right</i></span></li>
        @endif
    </ul>
@endif
