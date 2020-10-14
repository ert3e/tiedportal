<?php $__env->startSection('content'); ?>

    <p>Your username is <?php echo e($user->username); ?>.</p>
    <p>Click here to reset your password: <?php echo e(route('password.reset', [$token])); ?></p>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.email', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>