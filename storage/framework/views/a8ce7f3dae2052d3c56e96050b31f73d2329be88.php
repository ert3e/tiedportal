<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('settings', 'create') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-setting-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add <?php echo e(str_singular($title)); ?></a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <p><?php echo e($title); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">

                        <?php if( count($items) ): ?>
                            <table class="table table-hover m-0 table table-actions-bar">
                                <thead>
                                <tr>
                                    <?php
app('blade.helpers')->get('loop')->newLoop( $fields);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $field ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                        <th><?php echo e($field['name']); ?></th>
                                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                    <th style="width: 105px">Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                    <?php
app('blade.helpers')->get('loop')->newLoop( $items);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $item ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                        <tr id="#item-<?php echo e($item->id); ?>">
                                            <?php
app('blade.helpers')->get('loop')->newLoop( $fields);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $key => $field ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <?php if( $field['type'] == 'image' ): ?>
                                                    <td style="width: 100px;">
                                                    <?php if( is_object($item->$key) ): ?>
                                                        <img src="<?php echo route('media.get', [$item->$key->id, 100, 100]); ?>" class="img-circle thumb-sm" />
                                                    <?php endif; ?>
                                                    </td>
                                                <?php elseif( $field['type'] == 'text' ): ?>
                                                    <td><?php echo e($item->$key); ?></td>
                                                <?php elseif( $field['type'] == 'colour' ): ?>
                                                    <td style="width: 80px"><div class="colour-display" style="background: #<?php echo e($item->$key); ?>;"></div></td>
                                                <?php elseif( $field['type'] == 'textarea' ): ?>
                                                    <td><?php echo e($item->$key); ?></td>
                                                <?php elseif( $field['type'] == 'select' ): ?>
                                                    <td><?php echo e($item->{$field['value']}()); ?></td>
                                                <?php endif; ?>
                                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                            <td>
                                                <button title="Delete" data-title="Delete <?php echo e(str_singular($title)); ?>" data-message="Are you sure you want to delete this <?php echo e(strtolower(str_singular($title))); ?>? This action cannot be undone!" data-confirm="<?php echo e(strtolower(str_singular($title))); ?> deleted!" data-element="#item-<?php echo e($item->id); ?>" data-href="<?php echo e(route('settings.delete', ['type' => $type, 'id' => $item->id, '_token' => csrf_token()])); ?>" class="btn btn-danger delete-button waves-effect waves-light"><i class="fa fa-trash"></i></button>
                                                <button href="<?php echo e(route('settings.edit', [$type, $item->id])); ?>" title="Edit" class="btn btn-default waves-effect waves-light" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                                                   data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i></button>
                                            </td>
                                        </tr>
                                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

                                </tbody>
                            </table>
                        <?php else: ?>
                            <p><em>No <?php echo e(strtolower($title)); ?> found.</em></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-setting-modal', 'route' => ['settings.store', $type], 'files' => false, 'title' => 'Add ' . str_singular($title), 'button' => trans('global.save')]); ?>


    <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embeddcec5a362684dc20fb5eea031138bce05b8ce674eb08a'

        <?php $__env->startSection('content'); ?>

            <?php
app('blade.helpers')->get('loop')->newLoop( $fields);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $key => $field ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>

                <?php if( $field['type'] == 'text' ): ?>
                    <?php echo app("blade.helpers")->text_title( $key, $field['name']); ?>
                <?php elseif( $field['type'] == 'textarea' ): ?>
                    <?php echo app("blade.helpers")->textarea_title( $key, $field['name']); ?>
                <?php elseif( $field['type'] == 'colour' ): ?>
                    <?php echo app("blade.helpers")->colour_title( $key, $field['name']); ?>
                <?php elseif( $field['type'] == 'image' ): ?>
                    <?php echo app("blade.helpers")->image_title( $key, $field['name']); ?>
                <?php elseif( $field['type'] == 'select' ): ?>
                    <?php echo app("blade.helpers")->select_title( $key, $field['values'], $field['name']); ?>
                <?php endif; ?>

            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

        <?php $__env->stopSection(); ?>
    
EOT_embeddcec5a362684dc20fb5eea031138bce05b8ce674eb08a
); ?>


    <?php app('blade.helpers')->get('embed')->end(); ?>

    <div id="modal-container" class="modal-demo"></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>