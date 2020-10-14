<?php $__env->startSection('body'); ?>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo hidden-xs">
                <a href="<?php echo route('home.index'); ?>" class="logo"><img src="/img/tienda-logo.png" alt="<?php echo Config::get('system.name.plain'); ?>" /></a>
            </div>
            <div class="logo visible-xs">
                <a href="<?php echo route('home.index'); ?>" class="logo"><img src="/img/tienda-logo.png" alt="<?php echo Config::get('system.name.plain'); ?>" /></a>
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
                <?php echo $__env->make('fragments.header.profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <?php echo $__env->make('fragments.header.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                <?php echo $__env->yieldContent('content'); ?>
                <script type="application/javascript">
                    window.pageSetup = function() {
                        <?php echo $__env->yieldContent('script'); ?>
                    }
                </script>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>