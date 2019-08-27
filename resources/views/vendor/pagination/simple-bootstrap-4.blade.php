<div class="btn-group m-l-20">
    @if ($paginator->onFirstPage())
    <button type="button" disabled class="disabled btn btn-outline-secondary btn-sm"><i class="fa fa-angle-left"></i></button>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-angle-left"></i></a>
    @endif
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-angle-right"></i></a>
    @else
    <button type="button" disabled class="disabled btn btn-outline-secondary btn-sm"><i class="fa fa-angle-right"></i></button>
    @endif
</div>
