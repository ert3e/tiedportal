<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('projects', 'create') || Permissions::has('projects', 'delete') || Permissions::has('projects', 'edit') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <?php if( Permissions::has('projects', 'create') ): ?>
                    <li>
                        <a href="#add-subproject-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add subproject</a>
                    </li>
                <?php endif; ?>
                <?php if( Permissions::has('projects', 'edit') ): ?>
                    <li>
                        <a href="#" title="Complete" data-title="Complete Project" data-message="Are you sure you want to mark this project as complete?" data-confirm="Project completed!" data-href="<?php echo e(route('projects.complete', ['id' => $project->id, '_token' => csrf_token()])); ?>" class="success confirm-button"><i class="md md-check"></i> Complete project</a>
                    </li>
                <?php endif; ?>
                <?php if( Permissions::has('projects', 'delete') ): ?>
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Project" data-message="Are you sure you want to delete this project? This action cannot be undone!" data-confirm="Project deleted!" data-redirect="<?php echo e(route('projects.index')); ?>" data-href="<?php echo e(route('projects.delete', ['id' => $project->id, '_token' => csrf_token()])); ?>" class="btn-danger delete-button"><i class="fa fa-trash"></i> Delete project</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>
    <?php echo app("blade.helpers")->messages(); ?>

    <div class="row filedrop" data-attach-url="<?php echo e(route('projects.attachments.attach', $project->id)); ?>" data-detach-url="<?php echo e(route('projects.attachments.detach', $project->id)); ?>" data-token="<?php echo e(csrf_token()); ?>">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                <li class="active tab">
                    <a href="#details" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Details</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tasks" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-check-square-o"></i></span>
                        <span class="hidden-xs">Tasks</span>
                    </a>
                </li>
                <?php if($project->scope == 'external'): ?>
                <li class="tab">
                    <a href="#components" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-cubes"></i></span>
                        <span class="hidden-xs">Components</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if( (Permissions::has('finance', 'view') || Permissions::has('finance', 'create')) && $project->scope == 'external' ): ?>
                    <li class="tab">
                        <a href="#finance" data-toggle="tab" aria-expanded="true">
                            <span><i class="fa fa-pie-chart"></i></span>
                            <span class="hidden-xs">Financials</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if( Permissions::has('timeline', 'view') ): ?>
                    <li class="tab">
                        <a href="#timeline" data-toggle="tab" aria-expanded="false">
                            <span><i class="fa fa-clock-o"></i></span>
                            <span class="hidden-xs">Activity</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <div id="details" class="tab-pane active">
                    <?php echo $__env->make('projects.fragments.details', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="tasks" class="tab-pane">
                    <?php echo $__env->make('fragments.tasks.tasks', ['object' => $project, 'route' => ['projects.tasks.create', $project->id]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <?php if( Permissions::has('finance', 'view') || Permissions::has('finance', 'create') ): ?>
                    <div id="finance" class="tab-pane" style="display: none;">
                        <?php echo $__env->make('projects.fragments.financials', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                <?php endif; ?>
                <div id="components" class="tab-pane" style="display: none;">
                    <?php echo $__env->make('projects.fragments.components', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <?php if( Permissions::has('timeline', 'view') ): ?>
                    <div id="timeline" class="tab-pane" style="display: none;">
                        <div class="card-box">
                            <?php echo $__env->make('fragments.timeline.index', ['object' => $project], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if( Permissions::has('projects', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-subproject-modal', 'route' => 'projects.store', 'files' => false, 'title' => 'Add subproject', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1'

            <?php $__env->startSection('content'); ?>
                <?php echo Form::hidden('status', $project->status); ?>

                <?php echo Form::hidden('parent_id', $project->id); ?>

                <?php echo Form::hidden('customer_id', $project->customer_id); ?>

                <?php echo app("blade.helpers")->text_title( 'name', 'Subproject name', true); ?>
                <?php echo app("blade.helpers")->textarea_title( 'description', 'Subproject description'); ?>
            <?php $__env->stopSection(); ?>

        
EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

    <?php if( $project->status == 'prospect' && Permissions::has('leads', 'edit') ): ?>

        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'convert-lead-modal', 'route' => ['projects.convert', $project->id], 'files' => false, 'title' => 'Convert lead', 'button' => trans('global.save')]); ?>


        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1'

            <?php $__env->startSection('content'); ?>
                <?php echo Form::hidden('status', 'active'); ?>

                <?php if( $project->children()->count() ): ?>
                    <p><strong>WARNING: This will update all subprojects!</strong></p>
                <?php endif; ?>
                <?php echo app("blade.helpers")->select_title( 'conversion_reason_id', $conversion_reasons, 'Conversion reason', true); ?>
            <?php $__env->stopSection(); ?>

        
EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1
); ?>


        <?php app('blade.helpers')->get('embed')->end(); ?>

        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'lost-lead-modal', 'route' => ['projects.convert', $project->id], 'files' => false, 'title' => 'Lost lead', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1'

            <?php $__env->startSection('content'); ?>
                <?php echo Form::hidden('status', 'lost'); ?>

                <?php if( $project->children()->count() ): ?>
                    <p><strong>WARNING: This will update all subprojects!</strong></p>
                <?php endif; ?>
                <?php echo app("blade.helpers")->select_title( 'conversion_reason_id', $loss_reasons, 'Lost reason', true); ?>
            <?php $__env->stopSection(); ?>

        
EOT_embed6ab9cca3e2cb9ee930233c047b25e2e85b88008e6eda1
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>