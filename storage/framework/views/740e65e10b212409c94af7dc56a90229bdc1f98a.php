<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <div class="btn-group pull-right m-t-15">
        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#add-supplier-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Supplier</a>
            </li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <form role="form" method="GET">
                    <div class="row m-b-30">
                        <div class="col-sm-6">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="<?php echo e($term); ?>">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('type', $type_options, $type, ['class' => 'form-control autosubmit']); ?>

                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('status', $statuses, $status, ['class' => 'form-control autosubmit']); ?>

                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Types</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop( $suppliers);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $supplier ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <tr>
                                <td>
                                    <a href="<?php echo route('suppliers.details', $supplier->id); ?>">
                                    <?php if( is_object($supplier->media) ): ?>
                                        <img src="<?php echo route('media.get', [$supplier->media_id, 100, 100]); ?>" alt="<?php echo e($supplier->name); ?>" title="<?php echo e($supplier->name); ?>" class="img-circle thumb-sm" />
                                    <?php else: ?>
                                        <img src="/img/generic-supplier-small.png" alt="<?php echo e($supplier->name); ?>" title="<?php echo e($supplier->name); ?>" class="img-circle thumb-sm" />
                                    <?php endif; ?>
                                    </a>
                                </td>

                                <td>
                                    <a href="<?php echo route('suppliers.details', $supplier->id); ?>">
                                    <?php echo e($supplier->name); ?>

                                    <?php if( $supplier->verified ): ?>
                                        <span class="label label-success"><?php echo e(trans('global.verified')); ?></span>
                                    <?php else: ?>
                                        <span class="label label-danger"><?php echo e(trans('global.unverified')); ?></span>
                                    <?php endif; ?>
                                    </a>
                                </td>

                                <td>
                                    <?php if( is_object($supplier->contacts()->first()) ): ?>
                                        <?php echo e($supplier->contacts()->first()->first_name); ?> <?php echo e($supplier->contacts()->first()->last_name); ?>

                                    <?php else: ?>
                                        None
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
app('blade.helpers')->get('loop')->newLoop( $supplier->projectTypes);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project_type ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                        <span class="label label-default"><?php echo e($project_type->name); ?></span>
                                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                </td>
                            </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                    <?php echo $suppliers->links(); ?>

                </div>
            </div>
        </div>

    </div> <!-- end col -->


    <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-supplier-modal', 'route' => 'suppliers.store', 'files' => false, 'title' => 'Add Supplier', 'button' => trans('global.save')]); ?>



    <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedc027e51d21ef43d727e4b77eea3497f65b87e74fbf10a'

        <?php $__env->startSection('content'); ?>

            <?php echo app("blade.helpers")->text_title( 'name', 'Supplier name'); ?>
            <?php echo app("blade.helpers")->textarea_title( 'description', 'Supplier description'); ?>

        <?php $__env->stopSection(); ?>

    
EOT_embedc027e51d21ef43d727e4b77eea3497f65b87e74fbf10a
); ?>



    <?php app('blade.helpers')->get('embed')->end(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>