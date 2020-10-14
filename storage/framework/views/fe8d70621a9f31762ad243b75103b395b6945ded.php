<li>
    <img src="<?php echo $supplier->imageUrl(60, 60); ?>" alt="<?php echo e($supplier->name); ?>" title="<?php echo e($supplier->name); ?>" class="thumb-sm" />
    <span class="tran-text"><a href="<?php echo e(route('suppliers.details', $supplier->id)); ?>"><?php echo e($supplier->name); ?></a></span>
    <span class="pull-right">
        <button class="btn btn-sm fa fa-trash btn-danger delete-supplier" data-id="<?php echo e($supplier->id); ?>"></button></span>
    <span class="clearfix"></span>
</li>