<?php $__env->startSection('title'); ?>
    Login
<?php $__env->stopSection(); ?>

<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('body'); ?>

    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div class=" card-box">
            <div class="panel-heading">
                <div class="text-center">
                    <?php /* <H1>Tienda.digital</H1> */ ?>
                    <img src="/img/logo-blue.png" alt="<?php echo Config::get('system.name.plain'); ?>" />
                </div>
                <h3 class="text-center"> Sign in to <?php echo Config::get('system.name.html'); ?></h3>
            </div>


            <div class="panel-body">

                <?php echo app("blade.helpers")->errors(); ?>

                <?php echo Form::open(['route' => 'login.post', 'class' => 'form-horizontal m-t-20']); ?>


                    <div class="form-group ">
                        <div class="col-xs-12">
                            <?php echo app("blade.helpers")->text( 'username', null, ['class' => 'form-control', 'placeholder' => 'Username'], '<i class="fa fa-user"></i>'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php echo app("blade.helpers")->password( 'password', ['class' => 'form-control', 'placeholder' => 'Password'], '<i class="fa fa-lock"></i>'); ?>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <?php echo app("blade.helpers")->checkbox( 'remember', 'Remember Me'); ?>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="<?php echo route('forgot'); ?>" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>

                <?php echo Form::close(); ?>


            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>