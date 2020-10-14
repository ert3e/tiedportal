<div class="row">

    <div class="col-lg-3 col-lg-push-9">
        <?php if( $project->status == 'prospect' && Permissions::has('leads', 'edit') ): ?>
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Lead Tools</b></h4>
                <div class="row">
                    <div class="btn-group btn-group-block" role="group">
                        <a href="#convert-lead-modal" class="btn btn-lg btn-success col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-up"></i> Won</a>
                        <a href="#lost-lead-modal" class="btn btn-lg btn-danger col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-down"></i> Lost</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Email</b></h4>
                <?php echo app("blade.helpers")->label_title( 'Email address', sprintf('<a href="mailto:%s">%s</a>', $incoming_address, $incoming_address)); ?>
            </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>People</b></h4>
            <div class="form-group">
                <label for="name">
                    Creator
                </label>
                <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">
                    <li>
                        <img src="<?php echo $project->user->imageUrl(60, 60); ?>" alt="<?php echo e(FieldRenderer::userDisplay($project->user)); ?>" title="<?php echo e(FieldRenderer::userDisplay($project->user)); ?>" class="thumb-sm" />
                        <span class="tran-text"><?php echo FieldRenderer::user($project->user); ?></span>
                    </li>
                </ul>
            </div>
            <?php echo $__env->make('fragments.users.assignees', ['object' => $project, 'add_url' => route('projects.assignees.add', $project->id), 'remove_url' => route('projects.assignees.remove', $project->id)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <?php if( Permissions::has('suppliers', 'view') ): ?>
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Supplier</b></h4>
                <?php echo $__env->make('fragments.suppliers.suppliers', ['object' => $project, 'add_url' => route('projects.suppliers.add', $project->id), 'remove_url' => route('projects.suppliers.remove', $project->id)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        <?php endif; ?>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Contact</b></h4>
            <?php echo app("blade.helpers")->editable_select( $permission_group, 'contact_id', $project->customer->contacts, 'Project contact', $project->contact, route('projects.update', $project->id)); ?>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Lead</b></h4>
            <?php echo app("blade.helpers")->editable_select( $permission_group, 'lead_source_id', $lead_sources, 'Lead Source', $project->leadSource, route('projects.update', $project->id)); ?>
            <?php echo app("blade.helpers")->editable_text( $permission_group, 'lead_source_details', 'Details', $project->lead_source_details, route('projects.update', $project->id)); ?>
        </div>

    </div>

    <div class="col-lg-9 col-lg-pull-3">

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Dates</b></h4>
            <div class="col-lg-3">
                <?php echo app("blade.helpers")->editable_date( 'tasks', 'start_date', 'Start Date', $project->start_date, route('projects.update', $project->id)); ?>
            </div>
            <div class="col-lg-3">
                <?php echo app("blade.helpers")->editable_date( 'tasks', 'due_date', 'Due Date', $project->due_date, route('projects.update', $project->id)); ?>
            </div>

            <div class="col-lg-3">
                <?php echo app("blade.helpers")->label_title( 'Created', FieldRenderer::formatDate($project->created_at, true)); ?>
            </div>
            <div class="col-lg-3">
                <?php echo app("blade.helpers")->label_title( 'Updated', FieldRenderer::formatDate($project->updated_at, true)); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
            <div class="col-lg-6">
                <?php echo app("blade.helpers")->editable_text( $permission_group, 'name', 'Name', $project->name, route('projects.update', $project->id)); ?>
                <?php if( $project->scope == 'external' ): ?>
                        <span class="label label-info">EXTERNAL</span>
                <?php else: ?>
                        <span class="label label-warning">INTERNAL</span>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="company">Company</label>
                    <div class="editable-container">
                        <span class="edit-parent-span"><a href="<?php echo route('customers.details', $project->customer->id); ?>"><?php echo e($project->customer->name); ?></a></span>
                    </div>
                </div>
            </div>
            <?php if( $project->status == 'prospect' ): ?>
                <div class="col-lg-6">
                    <?php echo app("blade.helpers")->editable_select( $permission_group, 'prospect_status_id', $prospect_statuses, 'Status', $project->prospectStatus, route('projects.update', $project->id)); ?>
                </div>
            <?php endif; ?>
            <?php if( $project->status == 'active' ): ?>
                <div class="col-lg-6">
                    <?php echo app("blade.helpers")->editable_select( $permission_group, 'project_status_id', $project_statuses, 'Status', $project->projectStatus, route('projects.update', $project->id)); ?>
                </div>
            <?php endif; ?>
            <div class="col-lg-12">
                <?php echo app("blade.helpers")->editable_multiselect( $permission_group, 'types', $project_types, 'Project Type(s)', $project->types, route('projects.update', $project->id)); ?>
            </div>
            <div class="col-lg-12">
                <?php echo app("blade.helpers")->editable_textarea( $permission_group, 'description', 'Description', $project->description, route('projects.update', $project->id)); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php echo $__env->make('projects.fragments.subprojects', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('fragments.media.attachments', ['object' => $project], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('fragments.notes.notes', ['route' => ['projects.notes.add', $project->id], 'search_route' => ['projects.notes.search', $project->id]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>

</div>
