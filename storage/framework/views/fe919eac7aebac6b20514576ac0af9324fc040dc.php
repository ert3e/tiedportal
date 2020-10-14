<?php app("blade.helpers")->macro("text", function( $name, $value = "", $opts = ['class' => 'form-control'], $addon = ''){ ?>
<div class="input-group">
    <span class="input-group-addon"><?php echo $addon; ?></span>
    <?php echo Form::text($name, $value, $opts); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("email", function( $name, $value = "", $opts = ['class' => 'form-control'], $addon = '@'){ ?>
<div class="input-group">
    <span class="input-group-addon"><?php echo $addon; ?></span>
    <?php echo Form::email($name, $value, $opts); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("password", function( $name, $opts = ['class' => 'form-control'], $addon = ''){ ?>
<div class="input-group">
    <span class="input-group-addon"><?php echo $addon; ?></span>
    <?php echo Form::password($name, $opts); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("checkbox", function( $name, $text = '', $checked = false, $value = 'on'){ ?>
<?php $id = uniqid($name); $__data['id'] = uniqid($name); ?>
<div class="checkbox checkbox-primary">
    <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php echo e($value); ?>" type="checkbox" <?php if( $checked ): ?> checked="checked" <?php endif; ?>>
    <label for="<?php echo $id; ?>">
        <?php echo $text; ?>

    </label>
</div>
<?php unset($id); ?>
<?php }); ?>

<?php app("blade.helpers")->macro("text_display", function( $name, $value, $url = false){ ?>
<div class="form-group">
    <label for="company"><?php echo e($name); ?></label>
    <div>
        <?php if( $url ): ?>
            <a href="<?php echo e($url); ?>"><?php echo e($value); ?></a>
        <?php else: ?>
            <?php echo e($value); ?>

        <?php endif; ?>
    </div>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("text_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::text($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("checkbox_title", function( $name, $title, $checked = false, $value = null, $label = ''){ ?>
<?php $id = uniqid($name); $__data['id'] = uniqid($name); ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

    </label>
    <div class="checkbox checkbox-primary">
        <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php echo e($value); ?>" type="checkbox" <?php if( $checked ): ?> checked="checked" <?php endif; ?>>
        <label for="<?php echo $id; ?>">
            <?php echo ($label != '') ? $label : $title; ?>

        </label>
    </div>
</div>
<?php unset($id); ?>
<?php }); ?>

<?php app("blade.helpers")->macro("textarea_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::textarea($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("number_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::number($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("currency_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="input-group">
        <span class="input-group-addon">&pound;</span>
        <?php echo Form::number($name, $value, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

    </div>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("decimal_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::number($name, $value, ['class' => 'form-control', 'step' => 'any', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("datetime_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="row">
        <div class="col-sm-6">
            <div class="input-group">
                <input name="<?php echo e($name); ?>[date]" value="<?php echo e($value); ?>" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
            </div><!-- input-group -->
        </div>
        <div class="col-sm-6">
            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                <input name="<?php echo e($name); ?>[time]" type="text" class="form-control" value="<?php echo e($value); ?>">
                <span class="input-group-addon bg-custom b-0 text-white"> <span class="glyphicon glyphicon-time"></span> </span>
            </div>
        </div>
    </div>
</div>
<?php }); ?>


<?php app("blade.helpers")->macro("date_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="input-group">
        <input name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
    </div><!-- input-group -->
</div>
<?php }); ?>


<?php app("blade.helpers")->macro("time_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
        <input name="<?php echo e($name); ?>" type="text" class="form-control" value="<?php echo e($value); ?>">
        <span class="input-group-addon bg-custom b-0 text-white"> <span class="glyphicon glyphicon-time"></span> </span>
    </div>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("colour_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <select name="<?php echo e($name); ?>" class="colorselector">
        <?php
app('blade.helpers')->get('loop')->newLoop( Config::get('colours'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $colour => $title ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <option value="<?php echo e($colour); ?>" data-color="#<?php echo e($colour); ?>" <?php if( $value == $colour ): ?> selected="selected" <?php endif; ?>><?php echo e($title); ?></option>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    </select>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("file_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="form-group">
        <input type="file" name="<?php echo e($name); ?>" class="filestyle" data-iconname="fa fa-cloud-upload">
    </div>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("label_title", function( $title, $value){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

    </label>
    <p><?php echo $value; ?></p>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("select_title", function( $name, $options, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::select($name, $options, $value, ['class' => 'form-control']); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("typeahead_title", function( $name, $url, $title, $required = false){ ?>
<?php $input_id = uniqid('typeahead'); $__data['input_id'] = uniqid('typeahead'); ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::hidden($name, null, ['id' => $input_id]); ?>

    <?php echo Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing ' . strtolower($title) . '...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => $url]); ?>

</div>
<?php unset($input_id); ?>
<?php }); ?>

<?php app("blade.helpers")->macro("textarea_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <?php echo Form::textarea($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]); ?>

</div>
<?php }); ?>

<?php app("blade.helpers")->macro("image_title", function( $name, $title, $required = false, $value = null){ ?>
<div class="form-group">
    <label for="name">
        <?php echo e($title); ?>

        <?php if( $required ): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="form-group">
        <input type="file" name="<?php echo e($name); ?>" class="filestyle" data-iconname="fa fa-cloud-upload">
    </div>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_text", function( $permission_group, $name, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable" data-type="text" id="<?php echo e($name); ?>" data-type="text" data-params='{"_token": "<?php echo e(csrf_token()); ?>"}' data-url="<?php echo e($url); ?>" data-title="Enter <?php echo e(strtolower($title)); ?>"><?php echo FieldRenderer::longtext($value); ?></span>
        </div>
    <?php else: ?>
        <p><?php echo e($value); ?></p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_currency", function( $permission_group, $name, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable" data-type="text" id="<?php echo e($name); ?>" data-type="text" data-prepend="&pound;" data-value="<?php echo e($value); ?>" data-params='{"_token": "<?php echo e(csrf_token()); ?>"}' data-url="<?php echo e($url); ?>" data-title="Enter <?php echo e(strtolower($title)); ?>">&pound;<?php echo e(FieldRenderer::decimal($value)); ?></span>
        </div>
    <?php else: ?>
        <p>&pound;<?php echo e($value); ?></p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_colour", function( $permission_group, $name, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <select name="<?php echo e($name); ?>" class="colorselector" data-token="<?php echo e(csrf_token()); ?>" data-type="autosubmitsubmit" data-url="<?php echo e($url); ?>">
                <?php
app('blade.helpers')->get('loop')->newLoop( Config::get('colours'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $colour => $colour_title ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <option value="<?php echo e($colour); ?>" data-color="#<?php echo e($colour); ?>" <?php if( $value == $colour ): ?> selected="selected" <?php endif; ?>><?php echo e($colour_title); ?></option>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            </select>
        </div>
    <?php else: ?>
        <p><span class="btn-colorselector" style="background-color: #<?php echo e($value); ?>;"></span></p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_select", function( $permission_group, $name, $options, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable"
                  data-type="select"
                  id="<?php echo e($name); ?>"
                  <?php if( is_object($value) ): ?>
                   data-value="<?php echo e($value->id); ?>"
                   <?php endif; ?>
                   data-options="<?php echo Settings::selectValues($options); ?>"
                   data-params='{"_token": "<?php echo e(csrf_token()); ?>"}' data-url="<?php echo e($url); ?>" data-title="Enter <?php echo e(strtolower($title)); ?>">
                    <?php if( is_object($value) ): ?>
                    <?php echo FieldRenderer::display($value, 'None', $options); ?>

                    <?php elseif( is_array($options) && array_key_exists($value, $options)): ?>
                        <?php echo e($options[$value]); ?>

                    <?php else: ?>
                    None
                    <?php endif; ?>
            </span>
        </div>
    <?php else: ?>
        <p><?php echo FieldRenderer::display($value); ?></p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_multiselect", function( $permission_group, $name, $options, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable"
                  id="<?php echo e($name); ?>"
               data-type="multiple"
               data-value="<?php echo Settings::multiSelectValues($value); ?>"
               data-options="<?php echo Settings::selectValues($options, 'value', true); ?>"
               data-params='{"_token": "<?php echo e(csrf_token()); ?>"}'
               data-url="<?php echo e($url); ?>">
                <?php echo Settings::displaySelectValues($value); ?>

            </span>
        </div>
    <?php else: ?>
        <p>
            <?php if( is_array($value) ): ?>
                <?php
app('blade.helpers')->get('loop')->newLoop( $value);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $item ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <span class="select-value"><?php echo e($item->displayName()); ?></span>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            <?php else: ?>
                None
            <?php endif; ?>
        </p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_textarea", function( $permission_group, $name, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable" id="<?php echo e($name); ?>" data-inputclass="form-control" data-type="textArea" data-params='{"_token": "<?php echo e(csrf_token()); ?>"}' data-url="<?php echo e($url); ?>" data-title="Enter username"><?php echo FieldRenderer::longtext($value); ?></span>
        </div>
    <?php else: ?>
        <p><?php echo $value; ?></p>
    <?php endif; ?>
</div>
<?php }); ?>

<?php app("blade.helpers")->macro("editable_image", function( $permission_group, $image_url, $upload_route, $title = 'Upload an image'){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<?php $modal_id = uniqid('image-modal'); $__data['modal_id'] = uniqid('image-modal'); ?>
<div class="editable-image mb-b-10">
    <img src="<?php echo e($image_url); ?>" />
    <?php if( $editable ): ?>
        <div class="options">
            <a href="#<?php echo e($modal_id); ?>" data-animation="fadein" data-plugin="custommodal"
               data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i> Edit picture</a>
        </div>

        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => $modal_id, 'route' => $upload_route, 'files' => true, 'title' => 'Upload Image', 'button' => 'Upload']); ?>


        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedc7e1c1cfeef3f96fa8093e51e5a1962d5b87e6bc7ebb4'

            <?php $__env->startSection('content'); ?>

            <div class="form-group">
                <label class="control-label"><?php echo e($title); ?></label>
                <input type="file" name="media" class="filestyle" data-iconname="fa fa-cloud-upload">
            </div>

            <?php $__env->stopSection(); ?>

        
EOT_embedc7e1c1cfeef3f96fa8093e51e5a1962d5b87e6bc7ebb4
); ?>


        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>
</div>
<?php }); ?>


<?php app("blade.helpers")->macro("editable_password", function( $editable, $name, $title, $url = false){ ?>
<?php $editable = $editable; $__data['editable'] = $editable; ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span href="#" class="editable" id="<?php echo e($name); ?>" data-text="*******" data-type="password" data-params='{"_token": "<?php echo e(csrf_token()); ?>"}' data-url="<?php echo e($url); ?>" data-title="Enter password">********</span>
        </div>
    <?php else: ?>
        <p>*******</p>
    <?php endif; ?>
</div>
<?php }); ?>


<?php app("blade.helpers")->macro("editable_date", function( $permission_group, $name, $title, $value = null, $url = false){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<?php $display_value = FieldRenderer::formatDate($value); $__data['display_value'] = FieldRenderer::formatDate($value); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span href="#" class="editable"
               id="<?php echo e($name); ?>"
               data-pk="1"
               data-type="date"
               data-params='{"_token": "<?php echo e(csrf_token()); ?>"}'
               data-url="<?php echo e($url); ?>"><?php echo $display_value; ?></span>
        </div>
    <?php else: ?>
        <p><?php echo $display_value; ?></p>
    <?php endif; ?>
</div>
<?php }); ?>


<?php app("blade.helpers")->macro("editable_typeahead", function( $permission_group, $name, $title, $value, $lookup_url, $url){ ?>
<?php $editable = Permissions::has($permission_group, 'edit'); $__data['editable'] = Permissions::has($permission_group, 'edit'); ?>
<?php $display_value = FieldRenderer::display($value, ''); $__data['display_value'] = FieldRenderer::display($value, ''); ?>
<div class="form-group">
    <label for="name"><?php echo e($title); ?></label>
    <?php if( $editable ): ?>
        <div class="editable-container">
            <span class="editable"
               id="<?php echo e($name); ?>"
               data-type="typeahead"
               data-source="<?php echo e($lookup_url); ?>"
               data-params='{"_token": "<?php echo e(csrf_token()); ?>"}'
               data-url="<?php echo e($url); ?>"
               data-title="<?php echo e(strtolower($title)); ?>"><?php echo e($display_value); ?></span>
        </div>
    <?php else: ?>
        <p><?php echo $display_value; ?></p>
    <?php endif; ?>
</div>
<?php }); ?>
