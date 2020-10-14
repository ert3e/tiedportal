<div class="card-box attachments-container hidden">
    <h4 class="m-t-0 m-b-30 header-title"><b>Attachments</b></h4>
    <div class="attachments">
        <?php
app('blade.helpers')->get('loop')->newLoop( $object->attachments);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $media ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <?php echo $__env->make('fragments.media.attachment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    </div>
</div>