@section('title', $title)

<div class="row">
    <div class="col-sm-12">
        @yield('controls')
        <h4 class="page-title">{{ $title }}</h4>
        <ol class="breadcrumb">
            @foreach( $breadcrumbs as $breadcrumb )
                <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
            @endforeach
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
</div>