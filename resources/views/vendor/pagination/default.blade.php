@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" tabindex="-1" aria-disabled="true">&lsaquo;</a>
                </li>
            @else
                <li>
                    <a class="page-link" aria-hidden="true" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item"><a class="page-link" href="{{ $element }}" >{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-hidden="true">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" aria-disabled="true" tabindex="-1">&rsaquo;</a>
                </li>
            @endif
        </ul>
    </nav>
    Элементов на странице
    <form method="get" action={{url('dish')}} >
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="perpage" style="margin-top: 10px">
            <option value="2" @if($paginator -> perPage() == 2) selected @endif >2</option>
            <option value="4" @if($paginator -> perPage() == 4) selected @endif >4</option>
            <option value="6" @if($paginator -> perPage() == 6) selected @endif >6</option>
            <option value="8" @if($paginator -> perPage() == 8) selected @endif >8</option>
            <option value="10" @if($paginator -> perPage() == 10) selected @endif >10</option>
        </select>
        <input type="submit" value="Изменить" style="margin-top: 10px; margin-bottom: 20px">
    </form>
@endif
