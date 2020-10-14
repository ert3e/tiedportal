<ul class="navigation-menu">
    <li class="text-muted menu-title">Navigation</li>
    <li>
        <a <?php if( Request::is('home*') ): ?> class="active" <?php endif; ?> href="<?php echo route('home.index'); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('dashboard.title')); ?></a>
    </li>
    <?php if( Auth::user()->type == 'user' ): ?>
        <?php echo $__env->make('fragments.header.navigation.user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php elseif( Auth::user()->type == 'supplier' ): ?>
        <?php echo $__env->make('fragments.header.navigation.supplier', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php elseif( Auth::user()->type == 'customer' ): ?>
        <?php echo $__env->make('fragments.header.navigation.customer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
</ul>
