@extends('layout.html')

@section('body')

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo hidden-xs">
                <a href="{!! route('home.index') !!}" class="logo"><img src="/img/tienda-logo.png" alt="{!! Config::get('system.name.plain') !!}" /></a>
            </div>
            <div class="logo visible-xs">
                <a href="{!! route('home.index') !!}" class="logo"><img src="/img/tienda-logo.png" alt="{!! Config::get('system.name.plain') !!}" /></a>
            </div>
            <!-- End Logo container-->

            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle button-menu-mobile open-left waves-effect open">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
                @include('fragments.header.profile')
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            @include('fragments.header.navigation')
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div id="pjax-container">
                @yield('content')
                <script type="application/javascript">
                    window.pageSetup = function() {
                        @yield('script')
                    }
                </script>
            </div>
        </div>
    </div>
</div>

@endsection
