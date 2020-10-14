<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('projects', 'create') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-project-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add <?php echo e(ucwords($type)); ?></a>
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
                        <div class="col-sm-6">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="<?php echo e($term); ?>">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <?php echo Form::select('owner', $owner_options, $owner, ['class' => 'form-control autosubmit']); ?>

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
                            <th>Name</th>
                            <th class="hidden-xs">Company</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th class="hidden-xs">Type(s)</th>
                            <?php if( Permissions::has('finance', 'view') ): ?>
                                <th class="hidden-xs text-right">Value</th>
                            <?php endif; ?>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop( $projects);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <tr>
                                <td>
                                    <a href="<?php echo route('projects.details', $project->id); ?>"><?php echo e($project->name); ?>

                                    <?php if( $project->children()->count() ): ?>
                                        <span class="badge badge-default"><?php echo e($project->children()->count()); ?></span>
                                    <?php endif; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs">
                                    <?php if( is_object($project->customer) ): ?>
                                        <a href="<?php echo route('customers.details', $project->customer->id); ?>"><?php echo e($project->customer->name); ?></a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if( $project->scope == 'external' ): ?>
                                            <span class="label label-info">EXTERNAL</span>
                                    <?php else: ?>
                                            <span class="label label-warning">INTERNAL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="hidden-xs">
                                    <?php if( $project->status == 'prospect' || $project->status == 'lost' ): ?>
                                        <?php if( is_object($project->prospectStatus) ): ?>
                                            <span class="label" style="background-color:#<?php echo e($project->prospectStatus->colour); ?>"><?php echo e($project->prospectStatus->name); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger">None</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if( is_object($project->projectStatus) ): ?>
                                            <span class="label" style="background-color:#<?php echo e($project->projectStatus->colour); ?>"><?php echo e($project->projectStatus->name); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger">None</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="hidden-xs">
                                    <?php
app('blade.helpers')->get('loop')->newLoop( $project->types);
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
                                <?php if( Permissions::has('finance', 'view') ): ?>
                                    <td class="hidden-xs text-right">
                                        <?php echo e(FieldRenderer::formatCurrency($project->costs()->sum('value'))); ?>

                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                    <?php echo $projects->links(); ?>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <?php if( Permissions::has('projects', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-project-modal', 'route' => 'projects.store', 'files' => false, 'title' => 'Add ' . ucwords($type), 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedc2ed6f013477b916f4dabfd53b0f1c265b87ffb59a744'

            <?php $__env->startSection('content'); ?>
                <?php echo Form::hidden('status', $type); ?>

                <?php echo app("blade.helpers")->typeahead_title( 'customer_id', route('customers.autocomplete'), 'Company', true); ?>
                <?php echo app("blade.helpers")->text_title( 'name', ucwords($type) . ' name', true); ?>
                <?php echo app("blade.helpers")->select_title( 'lead_source_id', $lead_sources, ucwords($type) . ' source', true); ?>
                <?php echo app("blade.helpers")->select_title( 'scope', ['external' => 'external', 'internal' => 'internal'], ucwords($type) . ' scope', true); ?>
                <?php echo app("blade.helpers")->textarea_title( 'description', ucwords($type) . ' description'); ?>
            <?php $__env->stopSection(); ?>

        
EOT_embedc2ed6f013477b916f4dabfd53b0f1c265b87ffb59a744
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>