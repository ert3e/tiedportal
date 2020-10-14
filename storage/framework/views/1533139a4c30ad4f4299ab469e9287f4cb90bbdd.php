<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div id="edit-cost-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit cost</h4>
    <div class="custom-modal-text text-left">
        <?php echo Form::open(['route' => ['projects.costs.update', $project->id, $cost->id]]); ?>


        <?php echo e(csrf_field()); ?>


        <?php if( is_object($cost->supplier) ): ?>
            <?php echo app("blade.helpers")->text( 'Supplier', $cost->supplier->name); ?>
        <?php else: ?>
            <?php echo app("blade.helpers")->typeahead_title( 'supplier_id', route('suppliers.autocomplete'), 'Supplier', false); ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo app("blade.helpers")->currency_title( 'value', 'Value (to client)', true, $cost->value); ?>
            </div>
            <div class="col-md-6">
                <?php echo app("blade.helpers")->currency_title( 'cost', 'Cost (to us)', true, $cost->cost); ?>
            </div>
        </div>
        <?php echo app("blade.helpers")->textarea_title( 'description', 'Description', true, $cost->description); ?>

        <button type="submit" class="btn btn-default waves-effect waves-light"><?php echo e(trans('global.save')); ?></button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10"><?php echo e(trans('global.cancel')); ?></button>

        <?php echo Form::close(); ?>

    </div>
</div>
