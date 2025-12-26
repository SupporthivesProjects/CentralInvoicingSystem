<div class="d-flex justify-content-center mt-3" id="customize-pagination">
    <nav aria-label="Page navigation">
        <ul class="pagination mb-0">
            <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                <a class="page-link"
                   href="javascript:void(0);"
                   onclick="customizeProducts('onload', {{ $currentPage - 1 }})"
                   aria-label="Previous">
                    <span aria-hidden="true"><i class="bi bi-caret-left"></i></span>
                </a>
            </li>

            @foreach ($paginationPages as $page)
                @if ($page === '...')
                    <li class="page-item disabled"><a class="page-link">...</a></li>
                @else
                    <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                        <a class="page-link"
                           href="javascript:void(0);"
                           onclick="customizeProducts('onload', {{ $page }})">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endforeach

            <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                <a class="page-link"
                   href="javascript:void(0);"
                   onclick="customizeProducts('onload', {{ $currentPage + 1 }})"
                   aria-label="Next">
                    <span aria-hidden="true"><i class="bi bi-caret-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
</div>