<?php $input_id = uniqid('typeahead'); $__data['input_id'] = uniqid('typeahead'); ?>
<div class="form-group assignee-block-once" data-add-url="<?php echo e($add_url); ?>" data-remove-url="<?php echo e($remove_url); ?>" data-token="<?php echo e(csrf_token()); ?>">
    <label for="company">Projects</label>
    <p class="project-place">
    <?php /* <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">

    </ul> */ ?>
        <div class="input-group show-on-hover">
            <?php echo Form::hidden('assignee_id', null, ['id' => 'project_id', 'class' => 'project_id']); ?>

            <?php echo Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing project...', 'autocomplete' => 'off', 'data-field' => '#project_id', 'data-url' => route('projects.autocomplete')]); ?>


            <span class="input-group-btn">
                <button class="btn btn-default add" data-loading-text="Adding..." type="button">Add</button>
            </span>
        </div>
    </p>
</div>
<?php unset($input_id); ?>
