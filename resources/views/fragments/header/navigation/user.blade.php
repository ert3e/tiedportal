@if( Permissions::has('customers', 'view') || Permissions::has('leads', 'view') )
    <li class="text-muted menu-title">Customers</li>
@endif
@if( Permissions::has('customers', 'view') )
    <li>
        <a @if( Request::is('customers*') ) class="active" @endif href="{!! route('customers.index') !!}"><i class="fa fa-users"></i>{{ trans('customers.title') }}</a>
    </li>
@endif
@if( Permissions::has('leads', 'view') )
    <li>
        <a @if( Request::is('leads*') ) class="active" @endif href="{!! route('leads.index') !!}"><i class="fa fa-crosshairs"></i>{{ trans('leads.title') }}</a>
    </li>
@endif
@if( Permissions::has('contacts', 'view') )
    <li>
        <a @if( Request::is('contacts*') ) class="active" @endif href="{!! route('contacts.index') !!}"><i class="fa fa-user"></i>{{ trans('contacts.title') }}</a>
    </li>
@endif
@if( Permissions::has('tasks', 'view') )
    <li class="text-muted menu-title">Tasks</li>
    <li>
        <a @if( Request::is('tasks*') ) class="active" @endif href="{!! route('tasks.index') !!}"><i class="fa fa-check-square-o"></i>{{ trans('tasks.title') }}</a>
    </li>
@endif
@if( Permissions::has('projects', 'view') )
    <li class="text-muted menu-title">Projects</li>
    <li>
        <a @if( Request::is('projects*') && Request::get('type', 'project') == 'prospects' ) class="active" @endif href="{!! route('projects.index', 'prospects') !!}"><i class="fa fa-star-o"></i>{{ trans('projects.prospects') }}</a>
    </li>
    <li>
        <a @if( Request::is('projects*') && Request::get('type', 'project') == 'active' ) class="active" @endif href="{!! route('projects.index', 'active') !!}"><i class="fa fa-file-code-o"></i>{{ trans('projects.active') }}</a>
    </li>
    <li>
        <a @if( Request::is('projects*') && Request::get('type', 'project') == 'complete' ) class="active" @endif href="{!! route('projects.index', 'complete') !!}"><i class="fa fa-thumbs-up"></i>{{ trans('projects.complete') }}</a>
    </li>
    <li>
        <a @if( Request::is('projects*') && Request::get('type', 'project') == 'lost' ) class="active" @endif href="{!! route('projects.index', 'lost') !!}"><i class="fa fa-thumbs-down"></i>{{ trans('projects.lost') }}</a>
    </li>
@endif
@if( Permissions::has('finance', 'view') )
    <li class="text-muted menu-title">Finance</li>
    <li>
        <a @if( Request::is('finance*') ) class="active" @endif href="{!! route('finance.index') !!}"><i class="fa fa-line-chart"></i>{{ trans('finance.title') }}</a>
    </li>
@endif
@if( Permissions::has('suppliers', 'view') )
    <li class="text-muted menu-title">Suppliers</li>
    <li>
        <a @if( Request::is('suppliers*') ) class="active" @endif href="{!! route('suppliers.index') !!}"><i class="fa fa-truck"></i>{{ trans('suppliers.title') }}</a>
    </li>
@endif
@if( Permissions::has('settings', 'view') )
    <li class="text-muted menu-title">Settings</li>
    <li class="hidden-xs hidden-sm">
        <a @if( Request::is('settings*') ) class="active" @endif href="{!! route('settings.index') !!}"><i class="fa fa-cog"></i>{{ trans('settings.title') }}</a>
    </li>
@endif