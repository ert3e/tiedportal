<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>
    <?php echo app("blade.helpers")->messages(); ?>

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    <?php echo app("blade.helpers")->editable_image( 'users', $user->imageUrl(200, 200), ['users.media.upload', $user->id]); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->editable_text( 'users', 'first_name', 'First name', $user->contact->first_name, route('contacts.update', $user->contact->id)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->editable_text( 'users', 'last_name', 'Last name', $user->contact->last_name, route('contacts.update', $user->contact->id)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->editable_text( 'users', 'username', 'Username', $user->username, route('users.update', $user->id)); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->editable_text( 'users', 'email', 'Email address', $user->email, route('users.update', $user->id)); ?>
                </div>
                <?php if( $user->type == 'user' ): ?>
                <div class="col-sm-6">
                    <?php if( $user->system_admin ): ?>
                        <div class="form-group">
                            <label for="name">Role</label>
                            <div class="editable-container">
                                <p><label class="text-danger">System Administrator</label></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php echo app("blade.helpers")->editable_select( 'users', 'role_id', $roles, 'Role', $user->role, route('users.update', $user->id)); ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->editable_password( $can_change_password, 'password', 'Change password', route('users.update', $user->id)); ?>
                </div>
                <div style="clear: both"></div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>