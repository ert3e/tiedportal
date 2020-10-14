<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <div class="btn-group pull-right m-t-15">
        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#add-customer-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add <?php echo e(ucwords($type)); ?></a>
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

                <?php echo $__env->make('fragments.page.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th class="hidden-xs">Category</th>
                            <th class="hidden-xs">Projects</th>
                            <th class="hidden-xs">Creation Date</th>
                        </tr>
                        </thead>

                        <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $customers);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $customer ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <?php if( is_object($customer->type) ): ?>
                                    <tr style="border-left: solid 6px #<?php echo e($customer->type->colour); ?>;">
                                <?php else: ?>
                                    <tr>
                                <?php endif; ?>
                                <td>
                                    <a href="<?php echo route('customers.details', $customer->id); ?>">
                                        <img src="<?php echo $customer->imageUrl(100, 100); ?>" alt="<?php echo e($customer->name); ?>" title="<?php echo e($customer->name); ?>" class="thumb-sm" />
                                    </a>
                                </td>

                                <td>
                                    <a href="<?php echo route('customers.details', $customer->id); ?>"><?php echo $customer->name; ?></a>
                                </td>

                                <td class="hidden-xs">
                                    <?php if( is_object($customer->category) ): ?>
                                        <?php echo $customer->category->name; ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>

                                <td class="hidden-xs">
                                    <?php echo $customer->projects()->count(); ?>

                                </td>

                                <td class="hidden-xs">
                                    <?php echo $customer->created_at->format(Config::get('system.date.short')); ?>

                                </td>
                            </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                    <?php echo $customers->links(); ?>

                </div>
            </div>
        </div>

    </div> <!-- end col -->


    <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-customer-modal', 'route' => 'customers.store', 'files' => false, 'title' => 'Add ' . ucwords($type), 'button' => trans('global.save')]); ?>



    <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed721d19238923ef752dfa179393bc40c55b8ce66b65de2'

        <?php $__env->startSection('content'); ?>

            <?php echo Form::hidden('type', $type); ?>

            <?php echo app("blade.helpers")->select_title( 'category', $customer_types, 'Company category'); ?>
            <?php echo app("blade.helpers")->text_title( 'name', 'Company name'); ?>
            <?php echo app("blade.helpers")->textarea_title( 'description', 'Company description'); ?>

        <?php $__env->stopSection(); ?>

    
EOT_embed721d19238923ef752dfa179393bc40c55b8ce66b65de2
); ?>



    <?php app('blade.helpers')->get('embed')->end(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>