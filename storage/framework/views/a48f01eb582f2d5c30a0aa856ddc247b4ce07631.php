<div class="card-box">
    <?php if( Permissions::has('projects', 'edit') ): ?>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <?php
app('blade.helpers')->get('loop')->newLoop( $component_types);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $component_type ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <li>
                        <a href="<?php echo e(route('projects.components.create', [$project->id, $component_type->id])); ?>" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add <?php echo e($component_type->name); ?></a>
                    </li>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            </ul>
        </div>
    <?php endif; ?>
    <h4 class="m-t-0 m-b-30 header-title"><b>Components</b></h4>
    <?php if( $project->components()->count() ): ?>
        <?php
app('blade.helpers')->get('loop')->newLoop( $project->components);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $component ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
            <?php echo $__env->make('fragments.page.component', ['component' => $component], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
        <div style="clear: both;"></div>
    <?php else: ?>
        <p><em>Nothing to show</em></p>
    <?php endif; ?>
</div>