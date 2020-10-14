<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <p><?php echo e(trans('settings.welcome')); ?></p>
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
                                <th>Setting</th>
                                <th>Description</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $settings);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $setting ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <?php echo $setting['name']; ?>

                                    </td>

                                    <td>
                                        <?php echo $setting['description']; ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo $setting['url']; ?>" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>