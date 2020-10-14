<?php if( Permissions::has('customers', 'view') || Permissions::has('leads', 'view') ): ?>
    <li class="text-muted menu-title">Customers</li>
<?php endif; ?>
<?php if( Permissions::has('customers', 'view') ): ?>
    <li>
        <a <?php if( Request::is('customers*') ): ?> class="active" <?php endif; ?> href="<?php echo route('customers.index'); ?>"><i class="fa fa-users"></i><?php echo e(trans('customers.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('leads', 'view') ): ?>
    <li>
        <a <?php if( Request::is('leads*') ): ?> class="active" <?php endif; ?> href="<?php echo route('leads.index'); ?>"><i class="fa fa-crosshairs"></i><?php echo e(trans('leads.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('contacts', 'view') ): ?>
    <li>
        <a <?php if( Request::is('contacts*') ): ?> class="active" <?php endif; ?> href="<?php echo route('contacts.index'); ?>"><i class="fa fa-user"></i><?php echo e(trans('contacts.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('tasks', 'view') ): ?>
    <li class="text-muted menu-title">Tasks</li>
    <li>
        <a <?php if( Request::is('tasks*') ): ?> class="active" <?php endif; ?> href="<?php echo route('tasks.index'); ?>"><i class="fa fa-check-square-o"></i><?php echo e(trans('tasks.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('projects', 'view') ): ?>
    <li class="text-muted menu-title">Projects</li>
    <li>
        <a <?php if( Request::is('projects*') && Request::get('type', 'project') == 'prospects' ): ?> class="active" <?php endif; ?> href="<?php echo route('projects.index', 'prospects'); ?>"><i class="fa fa-star-o"></i><?php echo e(trans('projects.prospects')); ?></a>
    </li>
    <li>
        <a <?php if( Request::is('projects*') && Request::get('type', 'project') == 'active' ): ?> class="active" <?php endif; ?> href="<?php echo route('projects.index', 'active'); ?>"><i class="fa fa-file-code-o"></i><?php echo e(trans('projects.active')); ?></a>
    </li>
    <li>
        <a <?php if( Request::is('projects*') && Request::get('type', 'project') == 'complete' ): ?> class="active" <?php endif; ?> href="<?php echo route('projects.index', 'complete'); ?>"><i class="fa fa-thumbs-up"></i><?php echo e(trans('projects.complete')); ?></a>
    </li>
    <li>
        <a <?php if( Request::is('projects*') && Request::get('type', 'project') == 'lost' ): ?> class="active" <?php endif; ?> href="<?php echo route('projects.index', 'lost'); ?>"><i class="fa fa-thumbs-down"></i><?php echo e(trans('projects.lost')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('finance', 'view') ): ?>
    <li class="text-muted menu-title">Finance</li>
    <li>
        <a <?php if( Request::is('finance*') ): ?> class="active" <?php endif; ?> href="<?php echo route('finance.index'); ?>"><i class="fa fa-line-chart"></i><?php echo e(trans('finance.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('suppliers', 'view') ): ?>
    <li class="text-muted menu-title">Suppliers</li>
    <li>
        <a <?php if( Request::is('suppliers*') ): ?> class="active" <?php endif; ?> href="<?php echo route('suppliers.index'); ?>"><i class="fa fa-truck"></i><?php echo e(trans('suppliers.title')); ?></a>
    </li>
<?php endif; ?>
<?php if( Permissions::has('settings', 'view') ): ?>
    <li class="text-muted menu-title">Settings</li>
    <li class="hidden-xs hidden-sm">
        <a <?php if( Request::is('settings*') ): ?> class="active" <?php endif; ?> href="<?php echo route('settings.index'); ?>"><i class="fa fa-cog"></i><?php echo e(trans('settings.title')); ?></a>
    </li>
<?php endif; ?>