<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('users', 'create') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-user-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add User</a>
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
            <p><?php echo e(trans('users.welcome')); ?></p>
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
                                <th style="width: 100px"></th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th >Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $users);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $user ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $user->imageUrl(100, 100); ?>" alt="<?php echo e(FieldRenderer::userDisplay($user)); ?>" title="<?php echo e(FieldRenderer::userDisplay($user)); ?>" class="thumb-sm" />
                                    </td>
                                    <td>
                                        <?php echo $user->username; ?>

                                    </td>
                                    <td>
                                        <?php echo e(FieldRenderer::userDisplay($user)); ?>

                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
                                    </td>
                                    <td>
                                        <?php if( is_object($user->role) ): ?>
                                            <?php echo e($user->role->name); ?>

                                        <?php else: ?>
                                            None
                                        <?php endif; ?>
                                    </td>
                                    <td width="100px">
                                        <a href="<?php echo route('users.details', $user->id); ?>" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                        <a href="#" title="Delete" data-title="Delete user" data-message="Are you sure you want to delete this user? This action cannot be undone!" data-confirm="User deleted!"  data-href="<?php echo e(route('users.delete', ['user' => $user->id, '_token' => csrf_token()])); ?>" class="btn btn-danger delete-button"><i class="fa fa-trash"></i></a>
                                        <?php /* <form action="<?php echo e(route('users.delete', $user->id)); ?>" method="post" class="inline-block">
                                            <?php echo e(csrf_field()); ?>

                                            <input type='hidden' name='_method' value="delete">
                                            {{-- <button  onclick="return confirm('Are you sure?')" class="btn btn-danger">
                                            <button data-title="Remove user" data-message="Are you sure you want to remove this user?" data-confirm="User removed!" data-href="" class="btn btn-danger confirm-button">
                                            {{-- <button  class="btn btn-danger confirm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> */ ?>

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

    <?php if( Permissions::has('users', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-user-modal', 'route' => 'users.store', 'files' => false, 'title' => 'Add User', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embeda0fc2a875b23336890c88f3bedad4c105c5804ec1d834'

            <?php $__env->startSection('content'); ?>

                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'username', 'Username', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'email', 'Email address', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'first_name', 'First name', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'last_name', 'Last name', true); ?>
                </div>
                <div class="col-sm-12">
                    <?php echo app("blade.helpers")->checkbox( 'generate_password', 'Generate password and email user', true); ?>
                </div>

            <?php $__env->stopSection(); ?>

        
EOT_embeda0fc2a875b23336890c88f3bedad4c105c5804ec1d834
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>