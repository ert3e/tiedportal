<?php $__env->startSection('title', $title); ?>

<div class="row">
    <div class="col-sm-12">
        <?php echo $__env->yieldContent('controls'); ?>
        <h4 class="page-title"><?php echo e($title); ?></h4>
        <ol class="breadcrumb">
            <?php
app('blade.helpers')->get('loop')->newLoop( $breadcrumbs);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $breadcrumb ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <li><a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['name']); ?></a></li>
            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            <li class="active"><?php echo e($title); ?></li>
        </ol>
    </div>
</div>