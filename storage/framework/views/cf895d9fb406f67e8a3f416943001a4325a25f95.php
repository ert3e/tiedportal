<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('permissions', 'create') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-role-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Role</a>
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
            <p><?php echo e(trans('roles.welcome')); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Description</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $roles);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $role ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <?php echo $role->name; ?>

                                    </td>

                                    <td>
                                        <?php echo $role->description; ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo route('roles.details', $role->id); ?>" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <?php if( Permissions::has('permissions', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-role-modal', 'route' => 'roles.store', 'files' => false, 'title' => 'Add Role', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed11fa3cf2b0cbccf08a76e4c2cfa7c4165e6108ef99bfd'

            <?php $__env->startSection('content'); ?>

                <?php echo app("blade.helpers")->text_title( 'name', 'Role name'); ?>
                <?php echo app("blade.helpers")->textarea_title( 'description', 'Role description'); ?>

            <?php $__env->stopSection(); ?>

        
EOT_embed11fa3cf2b0cbccf08a76e4c2cfa7c4165e6108ef99bfd
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>