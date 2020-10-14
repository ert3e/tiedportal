<?php if( $project->children()->count() ): ?>
    <div class="card-box">
        <h4 class="m-t-0 m-b-30 header-title"><b>Subprojects</b></h4>
        <div class="table-responsive">
            <table class="table table-hover m-0 table table-actions-bar">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type(s)</th>
                </tr>
                </thead>

                <tbody>
                <?php
app('blade.helpers')->get('loop')->newLoop( $project->children);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $subproject ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <tr>
                        <td>
                            <a href="<?php echo route('projects.details', $subproject->id); ?>">
                                <?php echo e($subproject->name); ?>

                            <?php if( $subproject->children()->count() ): ?>
                                <span class="badge badge-default"><?php echo e($subproject->children()->count()); ?></span>
                            <?php endif; ?>
                            </a>
                        </td>
                        <td>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $subproject->types);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project_type ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <span class="label label-default"><?php echo e($project_type->name); ?></span>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </td>
                    </tr>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>