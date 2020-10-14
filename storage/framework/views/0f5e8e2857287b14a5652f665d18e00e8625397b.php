<div class="card-box note-container">
    <?php if( Permissions::has('projects', 'edit') && Permissions::has('tasks', 'create') ): ?>
        <div class="btn-group pull-right">
            <a href="#create-task-modal" class="btn btn-default dropdown-toggle waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-target="#modal-container" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Task</a>
        </div>
    <?php endif; ?>
    <h4 class="m-t-0 m-b-30 header-title"><b>Tasks</b></h4>
    <?php if( $object->tasks()->count() ): ?>
        <table class="table table-hover mails m-0 table table-actions-bar">
            <thead>
            <tr>
                <th>Title</th>
                <th class="hidden-xs">Assignee(s)</th>
                <th class="hidden-xs">Type</th>
                <th>Status</th>
                <th>State</th>
                <th style="width: 5%">Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
app('blade.helpers')->get('loop')->newLoop( $object->tasks);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $task ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr title="<?php echo e($task->verbal_priority); ?> priority">
                    <td class="<?php echo e(strtolower($task->verbal_priority)); ?>-note-priority">
                        <?php echo e($task->title); ?>

                        <?php if( $task->children()->count() ): ?>
                            <span class="badge badge-default"><?php echo e($task->children()->count()); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="hidden-xs">
                        <?php echo FieldRenderer::users($task->assignees); ?>

                    </td>
                    <td class="hidden-xs">
                        <?php if( is_object($task->taskType) ): ?>
                            <span class="label label-default" style="background-color: #<?php echo e($task->taskType->colour); ?>"><?php echo e($task->taskType->name); ?></span>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if( is_object($task->taskStatus) ): ?>
                            <span class="label label-default" style="background-color: #<?php echo e($task->taskStatus->colour); ?>"><?php echo e($task->taskStatus->name); ?></span>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e(ucwords($task->status)); ?>

                    </td>
                    <td>
                        <a href="<?php echo route('tasks.details', $task->id); ?>" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            </tbody>
        </table>
    <?php else: ?>
        <p><em>No tasks</em></p>
    <?php endif; ?>
</div>

<?php if( Permissions::has('projects', 'edit') && Permissions::has('tasks', 'create') ): ?>
    <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'create-task-modal', 'route' => $route, 'files' => false, 'title' => 'Add Task', 'button' => trans('global.save')]); ?>

    <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed4dcdde0887f5f045b05b5484156443a95b87e6f7ae256'

        <?php $__env->startSection('content'); ?>
            <?php echo app("blade.helpers")->text_title( 'title', 'Task title', true); ?>
            <?php echo app("blade.helpers")->checkbox_title( 'private', 'Privacy', false, false, 'Set to private (only assigned users will see this task)'); ?>
            <?php echo app("blade.helpers")->select_title( 'type', $task_types, 'Type', false); ?>
            <?php echo app("blade.helpers")->select_title( 'priority', $priorities, 'Priority', false, 2); ?>
            <?php echo app("blade.helpers")->textarea_title( 'description', 'Description', false); ?>
            <?php echo app("blade.helpers")->typeahead_title( 'assignee', route('users.autocomplete'), 'Assignee', false); ?>
        <?php $__env->stopSection(); ?>

    
EOT_embed4dcdde0887f5f045b05b5484156443a95b87e6f7ae256
); ?>

    <?php app('blade.helpers')->get('embed')->end(); ?>
<?php endif; ?>
