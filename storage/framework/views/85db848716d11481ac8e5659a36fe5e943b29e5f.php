<h4 class="page-title m-b-20">Financial Statistics</h4>


<div class="row">

    <div class="col-lg-12">
        <div class="card-box">

            <?php echo $__env->make('finance.fragments.overview.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('finance.fragments.overview.calculations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('finance.fragments.overview.chart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('finance.fragments.overview.table', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php /* <?php echo $__env->make('finance.fragments.overview.months_compare', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>

        </div>
    </div>
</div>
