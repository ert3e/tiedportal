<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>

    <?php if( $tasks->count() ): ?>
        <div class="row">
            <div class="col-lg-12">

                <div class="portlet"><!-- /primary heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark text-uppercase">
                            My Tasks
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet2" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="empty-note-priority">Title</th>
                                        <th class="hidden-xs">Project</th>
                                        <th class="hidden-xs">Customer</th>
                                        <th class="hidden-xs">Due Date</th>
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
                                                <?php if( is_object($task->project) && is_object($task->project->customer) ): ?>
                                                    <a href="<?php echo e(route('customers.details', $task->project->customer->id)); ?>"><?php echo e($task->project->customer->name); ?></a>
                                                <?php else: ?>
                                                    None
                                                <?php endif; ?>
                                            </td>
                                            <td class="hidden-xs">
                                                <?php if( is_object($task->project) ): ?>
                                                    <a href="<?php echo e(route('projects.details', $task->project->id)); ?>"><?php echo e($task->project->name); ?></a>
                                                <?php else: ?>
                                                    None
                                                <?php endif; ?>
                                            </td>
                                            <td class="hidden-xs">
                                                <?php echo e(FieldRenderer::formatDate($task->due_date)); ?> <?php echo FieldRenderer::projectDue($task); ?>

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
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if( $tasks->hasMorePages() ): ?>
                                        <a href="<?php echo e(route('tasks.index')); ?>">View all tasks</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Current Projects
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="empty-prospect-status">Project Name</th>
                                    <th class="hidden-xs">Customer</th>
                                    <th class="hidden-xs">Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
app('blade.helpers')->get('loop')->newLoop( $projects);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <?php /* <?php echo e(dump($project)); ?> */ ?>
                                    <tr title="<?php echo e(ucfirst($project->status)); ?>">
                                        <td class="<?php echo e(strtolower($project->status)); ?>-prospect-status">
                                            <a href="<?php echo route('projects.details', $project->id); ?>"><?php echo e($project->name); ?></a></td>
                                        <td class="hidden-xs"><a href="<?php echo route('customers.details', $project->customer->id); ?>"><?php echo e($project->customer->name); ?></a></td>
                                        <td class="hidden-xs"><?php echo e(FieldRenderer::formatDate($project->start_date)); ?></td>
                                        <td><?php echo e(FieldRenderer::formatDate($project->due_date)); ?> <?php echo FieldRenderer::projectDue($project); ?></td>
                                        <td><?php echo FieldRenderer::projectStatus($project); ?></td>
                                    </tr>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php if( $projects->hasMorePages() ): ?>
                                    <a href="<?php echo e(route('projects.index', ['active'])); ?>">View all projects</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <?php if( $events ): ?>
    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Activity Feed
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="p-20">
                            <div class="timeline-2">
                                <?php
app('blade.helpers')->get('loop')->newLoop( $events);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $event ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <div class="time-item">
                                        <div class="item-info">
                                            <div class="text-muted"><?php echo TimelineRenderer::time($event); ?></div>
                                            <p>
                                                <?php echo TimelineRenderer::user($event); ?> <?php echo TimelineRenderer::description($event); ?>

                                                <?php if( TimelineRenderer::url($event) ): ?>
                                                <a href="<?php echo e(TimelineRenderer::url($event)); ?>">view</a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>