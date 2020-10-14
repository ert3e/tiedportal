<li>
    <a @if( Request::is('supplier.quotes*') ) class="active" @endif href="{!! route('supplier.quotes.index') !!}"><i class="fa fa-inbox"></i>{{ trans('quotes.title') }}</a>
</li>