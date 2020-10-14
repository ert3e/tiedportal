<?php app("blade.helpers")->macro("errors", function( $message = 'An error occurred while processing your request:'){ ?>
    <?php if( Session::has('errors') ): ?>
        <div class="alert alert-danger">
            <p><?php echo $message; ?></p>
            <ul>
                <?php
app('blade.helpers')->get('loop')->newLoop( Session('errors')->all());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $error ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <li><?php echo $error; ?></li>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if( Session::has('error') ): ?>
        <div class="alert alert-danger">
            <p><?php echo Session::get('error'); ?></p>
        </div>
    <?php endif; ?>
<?php }); ?>

<?php app("blade.helpers")->macro("messages", function(){ ?>
<?php if( Session::has('info') ): ?>
    <div class="alert alert-info">
        <p><?php echo Session::get('info'); ?></p>
    </div>
<?php endif; ?>
<?php if( Session::has('success') ): ?>
    <div class="alert alert-success">
        <p><?php echo Session::get('success'); ?></p>
    </div>
<?php endif; ?>
<?php if( Session::has('status') ): ?>
    <div class="alert alert-success">
        <p><?php echo Session::get('status'); ?></p>
    </div>
<?php endif; ?>
<?php }); ?>