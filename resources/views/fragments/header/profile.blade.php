<ul class="nav navbar-nav navbar-right pull-right">

    <li class="dropdown">
        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="{{ Auth::user()->imageUrl(60, 60) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" title="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="img-circle"> </a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('users.profile') }}"><i class="ti-user m-r-5"></i> Profile</a></li>
            <li><a class="not-pjax" href="{{ route('logout') }}"><i class="ti-power-off m-r-5"></i> Logout</a></li>
        </ul>
    </li>
</ul>