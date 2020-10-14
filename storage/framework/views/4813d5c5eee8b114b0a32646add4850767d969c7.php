<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-md-11 col-sm-10">
                        <?php echo $__env->make('fragments.page.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                    <div class="col-md-1 col-sm-2 text-right">
                        <form action="" method="post">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="download" value="1" />
                            <button title="Download contacts" class="btn btn-default"><i class="fa fa-download"></i></button>
                        </form>
                    </div>
                </div>
                <?php /* <div class="contacts-download-holder row">
                    <div class="col-md-6">
                        <?php echo e(dd($types)); ?>

                        <select class="form-control">
                          <option value="-1">All</option>
                          <option value="0">Unasigned</option>
                          <?php foreach: ?>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                    </div>
                </div> */ ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Type</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop( $contacts);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $contact ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <?php if( is_object($contact->contactType) ): ?>
                                <tr style="border-left: solid 6px #<?php echo e($contact->contactType->colour); ?>;">
                            <?php else: ?>
                                <tr>
                            <?php endif; ?>
                                <td>
                                    <img src="<?php echo $contact->imageUrl(100, 100); ?>" alt="<?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?>" title="<?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?>" class="img-circle thumb-sm" />
                                </td>

                                <td>
                                    <a href="<?php echo route('contacts.details', $contact->id); ?>"><?php echo $contact->first_name; ?> <?php echo $contact->last_name; ?></a>
                                </td>

                                <td>
                                    <?php if( is_object($contact->customer) ): ?>
                                        <a href="<?php echo e(route('customers.details', $contact->customer->id)); ?>"><?php echo $contact->customer->name; ?></a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if( is_object($contact->type) ): ?>
                                        <?php echo ucwords($contact->type->name); ?>

                                    <?php else: ?>
                                        None
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                    <?php echo $contacts->links(); ?>

                </div>
            </div>
        </div> <!-- end col -->

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>