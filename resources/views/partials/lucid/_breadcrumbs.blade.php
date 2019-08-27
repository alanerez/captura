<div class="block-header">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> {{ $breadcrumbs->last()->title }}</h2>
             <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                @foreach ($breadcrumbs as $breadcrumb)
                @php 
                @endphp
                @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->title }}</li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
