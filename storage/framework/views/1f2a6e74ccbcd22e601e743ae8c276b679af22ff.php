<div class="widget-bg-color-icon card-box" style="border: solid 2px #<?php echo e($component->componentType->colour); ?>">
    <div class="text-left">
        <h5 class="text-dark"><?php echo e($component->name); ?></h5>
        <p class="text-muted">
            <?php
app('blade.helpers')->get('loop')->newLoop( $component->values);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $value ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <?php echo FieldRenderer::render($value); ?><br/>
            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
        </p>
    </div>
    <div class="clearfix"></div>
</div>