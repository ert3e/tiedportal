<?php $input_id = uniqid('typeahead'); $__data['input_id'] = uniqid('typeahead'); ?>
<div class="form-group assignee-block" data-add-url="<?php echo e($add_url); ?>" data-remove-url="<?php echo e($remove_url); ?>" data-token="<?php echo e(csrf_token()); ?>">
    <label for="company">Assignee(s)</label>
    <p>
    <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">
        <?php
app('blade.helpers')->get('loop')->newLoop( $object->assignees);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $user ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <?php echo $__env->make('fragments.users.assignee', ['assignee' => $user], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    </ul>

        <div class="input-group">
            <?php echo Form::hidden('assignee_id', null, ['id' => $input_id, 'class' => 'user-id']); ?>

            <?php echo Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing user...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => route('users.autocomplete')]); ?>


            <span class="input-group-btn">
                <button class="btn btn-default add" data-loading-text="Adding..." type="button">Add</button>
            </span>
        </div>
    </p>
</div>
<?php unset($input_id); ?>
