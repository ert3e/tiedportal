<?php $__env->startSection('content'); ?>

    <p>Welcome <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>,</p>

    <p>Your new account is setup and you username is <strong><?php echo e($user->username); ?></strong>.</p>
    <p>Your password to access the system is <strong><?php echo e($password); ?></strong>. We recommend you change this as soon as possible.</p>

    <p>Click here to reset your password: <?php echo e(route('users.profile')); ?></p>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.email', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>