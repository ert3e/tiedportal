<?php $__env->startSection('content'); ?>

    <p><?php echo FieldRenderer::user($sender); ?> added a note to the <?php echo e($object->object_type); ?> <strong><?php echo e($object->displayName()); ?></strong>.</p>
    <p><?php echo FieldRenderer::longtext($note->content); ?></p>
    <?php if( FieldRenderer::url($object) ): ?>
        <p>View: <a href="<?php echo e(FieldRenderer::url($object)); ?>"><?php echo e(FieldRenderer::url($object)); ?></a></p>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.email', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>