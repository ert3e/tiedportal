<h4 class="m-t-0 header-title"><b>Activity</b></h4>
<div class="p-20">
    <div class="timeline-2">
        <?php
app('blade.helpers')->get('loop')->newLoop( $object->events->take(10));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $event ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <div class="time-item">
                <div class="item-info">
                    <div class="text-muted"><?php echo TimelineRenderer::time($event); ?></div>
                    <p><?php echo TimelineRenderer::user($event); ?> <?php echo TimelineRenderer::description($event); ?></p>
                </div>
            </div>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    </div>
</div>