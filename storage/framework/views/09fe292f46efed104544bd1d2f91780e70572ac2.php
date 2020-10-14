<?php
app('blade.helpers')->get('loop')->newLoop( $notes);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $note ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
    <?php echo $__env->make('fragments.notes.note', ['note' => $note], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
