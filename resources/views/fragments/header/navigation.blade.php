<ul class="navigation-menu">
    <li class="text-muted menu-title">Navigation</li>
    <li>
        <a @if( Request::is('home*') ) class="active" @endif href="{!! route('home.index') !!}"><i class="fa fa-dashboard"></i>{{ trans('dashboard.title') }}</a>
    </li>
    @if( Auth::user()->type == 'user' )
        @include('fragments.header.navigation.user')
    @elseif( Auth::user()->type == 'supplier' )
        @include('fragments.header.navigation.supplier')
    @elseif( Auth::user()->type == 'customer' )
        @include('fragments.header.navigation.customer')
    @endif
</ul>
