<?php $input_id = uniqid('typeahead'); $__data['input_id'] = uniqid('typeahead'); ?>
<div class="form-group supplier-block" data-add-url="<?php echo e($add_url); ?>" data-remove-url="<?php echo e($remove_url); ?>" data-token="<?php echo e(csrf_token()); ?>">
    <label for="company">Supplier(s)</label>
    <p>
    <ul style="overflow: hidden;" class="list-unstyled supplier-list nicescroll" tabindex="5001">
        <?php
app('blade.helpers')->get('loop')->newLoop( $object->suppliers);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $supplier ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <?php echo $__env->make('fragments.suppliers.supplier', ['supplier' => $supplier], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    </ul>

        <div class="input-group">
            <?php echo Form::hidden('supplier_id', null, ['id' => $input_id, 'class' => 'supplier-id']); ?>

            <?php echo Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing supplier...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => route('suppliers.autocomplete')]); ?>


            <span class="input-group-btn">
                <button class="btn btn-default add" data-loading-text="Adding..." type="button">Add</button>
            </span>
        </div>
    </p>
</div>
<?php unset($input_id); ?>
