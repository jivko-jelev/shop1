@if($products->total() > $products->perPage())
    <nav aria-label="Page navigation example" id="pagination">
        <ul class="pagination">
            <li class="page-item{{ $products->currentPage() == 1 ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $products->path() . "?{$products->getOptions()['pageName']}=" . ($products->currentPage() - 1) }}"
                   data-page="{{ $products->currentPage() - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @for($i=1; $i<=$products->lastPage(); $i++)
                <li class="page-item{{ $products->currentPage()==$i ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $products->path() . "?{$products->getOptions()['pageName']}=$i" }}"
                       data-page="{{ $i }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item{{ $products->currentPage() == $products->lastPage() ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $products->path() . "?{$products->getOptions()['pageName']}=" . ($products->currentPage() + 1) }}"
                   data-page="{{ $products->currentPage() + 1 }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
@endif