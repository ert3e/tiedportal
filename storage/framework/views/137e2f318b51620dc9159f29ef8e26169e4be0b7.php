<li>
    <img src="<?php echo $assignee->imageUrl(60, 60); ?>" alt="<?php echo e(FieldRenderer::userDisplay($assignee)); ?>" title="<?php echo e(FieldRenderer::userDisplay($assignee)); ?>" class="thumb-sm" />
    <span class="tran-text"><?php echo FieldRenderer::user($assignee); ?></span>
    <span class="pull-right">
        <button class="btn btn-sm fa fa-trash btn-danger delete-user" data-id="<?php echo e($assignee->id); ?>"></button></span>
    <span class="clearfix"></span>
</li>