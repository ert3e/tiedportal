<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                <li class="active tab">
                    <a href="#overview" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-line-chart"></i></span>
                        <span class="hidden-xs">Overview</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#invoices" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-money"></i></span>
                        <span class="hidden-xs">Costs</span>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane active">
                    <?php echo $__env->make('finance.fragments.overview', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="invoices" class="tab-pane">
                    <?php echo $__env->make('finance.fragments.invoices', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>