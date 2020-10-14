<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('tasks', 'create') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-task-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Task</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <form role="form" method="GET">
                    <div class="row m-b-30">
                        <div class="col-sm-12">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="<?php echo e($term); ?>">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('owner', $owner_options, $owner, ['class' => 'form-control autosubmit']); ?>

                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('show', $show_options, $show, ['class' => 'form-control autosubmit']); ?>

                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('type', $types, $type, ['class' => 'form-control autosubmit']); ?>

                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('status', $statuses, $status, ['class' => 'form-control autosubmit']); ?>

                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="empty-note-priority">Title</th>
                            <th class="hidden-xs">Project</th>
                            <th class="hidden-xs">Customer</th>
                            <th class="hidden-xs">Assignee(s)</th>
                            <th class="hidden-xs">Type</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop( $tasks);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $task ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <tr title="<?php echo e($task->verbal_priority); ?> priority">
                                <td class="<?php echo e(strtolower($task->verbal_priority)); ?>-note-priority">
                                    <a href="<?php echo route('tasks.details', $task->id); ?>"><?php echo e($task->title); ?>

                                    <?php if( $task->children()->count() ): ?>
                                        <span class="badge badge-default"><?php echo e($task->children()->count()); ?></span>
                                    <?php endif; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs">
                                    <?php if( is_object($task->project) ): ?>
                                        <a href="<?php echo e(route('projects.details', $task->project->id)); ?>"><?php echo e($task->project->name); ?></a>
                                    <?php else: ?>
                                        None
                                    <?php endif; ?>
                                </td>
                                <td class="hidden-xs">
                                    <?php if( is_object($task->project) && is_object($task->project->customer) ): ?>
                                        <a href="<?php echo e(route('customers.details', $task->project->customer->id)); ?>"><?php echo e($task->project->customer->name); ?></a>
                                    <?php else: ?>
                                        None
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
                                    <?php echo e(array_get(App\Models\Task::$priorities, $task->priority, 'Default')); ?>

                                </td>
                                <td>
                                    <?php if( is_object($task->taskStatus) ): ?>
                                        <span class="label label-default" style="background-color: #<?php echo e($task->taskStatus->colour); ?>"><?php echo e($task->taskStatus->name); ?></span>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                    <?php echo $tasks->links(); ?>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <?php if( Permissions::has('tasks', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-task-modal', 'route' => 'tasks.store', 'files' => false, 'title' => 'Add Task', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedeafaca4051bc04ebc69310b5f9b2a9075b8800312d243'

            <?php $__env->startSection('content'); ?>
                <?php echo app("blade.helpers")->text_title( 'title', 'Task title', true); ?>
                <?php echo app("blade.helpers")->checkbox_title( 'private', 'Privacy', false, false, 'Set to private (only assigned users will see this task)'); ?>
                <?php echo app("blade.helpers")->select_title( 'type', $task_types, 'Type', false); ?>
                <?php echo app("blade.helpers")->select_title( 'priority', $priorities, 'Priority', false, 2); ?>
                <?php echo app("blade.helpers")->textarea_title( 'description', 'Description', false); ?>
                <?php echo app("blade.helpers")->typeahead_title( 'assignee', route('users.autocomplete'), 'Assignee', false); ?>
            <?php $__env->stopSection(); ?>

        
EOT_embedeafaca4051bc04ebc69310b5f9b2a9075b8800312d243
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>