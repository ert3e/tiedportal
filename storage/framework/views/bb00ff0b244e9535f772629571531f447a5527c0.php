<?php $__env->startSection('content'); ?>

    <p><?php echo TimelineRenderer::user($event); ?> <?php echo EventRenderer::title($event); ?></p>
    <?php if( EventRenderer::description($event) ): ?>
        <p><?php echo EventRenderer::description($event); ?></p>
    <?php endif; ?>
    <?php if( TimelineRenderer::url($event) ): ?>
        <p>View: <a href="<?php echo e(TimelineRenderer::url($event)); ?>"><?php echo e(TimelineRenderer::url($event)); ?></a></p>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.email', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>