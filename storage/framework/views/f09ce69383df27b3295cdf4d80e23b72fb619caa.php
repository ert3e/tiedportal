<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('permissions', 'delete') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#" title="Delete" data-title="Delete Role" data-message="Are you sure you want to delete this role? This action cannot be undone!" data-confirm="Role deleted!" data-redirect="<?php echo e(route('roles.index')); ?>" data-href="<?php echo e(route('roles.delete', ['id' => $role->id, '_token' => csrf_token()])); ?>" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Role</a>
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
            <p><?php echo e(trans('permissions.title')); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php echo Form::open(['route' => ['roles.update', $role->id]]); ?>

                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-hover mails m-0 table table-actions-bar">
                                    <thead>
                                    <tr>
                                        <th>Permission Type</th>
                                        <?php
app('blade.helpers')->get('loop')->newLoop( $permissions);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $permission ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                            <th class="td-checkbox"><?php echo trans('permissions.'.$permission); ?></th>
                                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
app('blade.helpers')->get('loop')->newLoop( $permissions_groups);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $group => $available_permissions ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                        <tr>
                                            <td>
                                                <?php echo trans('permissiongroups.'.$group); ?>

                                            </td>
                                            <?php
app('blade.helpers')->get('loop')->newLoop( $permissions);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $key => $permission ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <td class="td-checkbox">
                                                    <?php if( in_array($permission, $available_permissions) ): ?>
                                                        <?php echo Form::checkbox('permission['.$group.'][]', $key, $role->has($group, $key), ['class' => 'js-switch', 'data-size' => 'small', 'data-plugin' => 'switchery']); ?>

                                                    <?php else: ?>
                                                        <?php echo Form::checkbox('', '', false, ['class' => 'js-switch', 'data-size' => 'small', 'data-plugin' => 'switchery', 'data-disabled' => 'true']); ?>

                                                    <?php endif; ?>
                                                </td>
                                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
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
                    <div class="row">
                        <div class="col-sm-12 m-t-20">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            <?php echo Form::close(); ?>

        </div> <!-- end col -->
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>