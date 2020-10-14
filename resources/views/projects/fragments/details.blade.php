<div class="row">

    <div class="col-lg-3 col-lg-push-9">
        @if( $project->status == 'prospect' && Permissions::has('leads', 'edit') )
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Lead Tools</b></h4>
                <div class="row">
                    <div class="btn-group btn-group-block" role="group">
                        <a href="#convert-lead-modal" class="btn btn-lg btn-success col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-up"></i> Won</a>
                        <a href="#lost-lead-modal" class="btn btn-lg btn-danger col-sm-6" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-thumbs-down"></i> Lost</a>
                    </div>
                </div>
            </div>
        @endif

            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Email</b></h4>
                @macro('label_title', 'Email address', sprintf('<a href="mailto:%s">%s</a>', $incoming_address, $incoming_address))
            </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>People</b></h4>
            <div class="form-group">
                <label for="name">
                    Creator
                </label>
                <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">
                    <li>
                        <img src="{!! $project->user->imageUrl(60, 60) !!}" alt="{{ FieldRenderer::userDisplay($project->user) }}" title="{{ FieldRenderer::userDisplay($project->user) }}" class="thumb-sm" />
                        <span class="tran-text">{!! FieldRenderer::user($project->user) !!}</span>
                    </li>
                </ul>
            </div>
            @include('fragments.users.assignees', ['object' => $project, 'add_url' => route('projects.assignees.add', $project->id), 'remove_url' => route('projects.assignees.remove', $project->id)])
        </div>

        @if( Permissions::has('suppliers', 'view') )
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Supplier</b></h4>
                @include('fragments.suppliers.suppliers', ['object' => $project, 'add_url' => route('projects.suppliers.add', $project->id), 'remove_url' => route('projects.suppliers.remove', $project->id)])
            </div>
        @endif

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Contact</b></h4>
            @macro('editable_select', $permission_group, 'contact_id', $project->customer->contacts, 'Project contact', $project->contact, route('projects.update', $project->id))
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Lead</b></h4>
            @macro('editable_select', $permission_group, 'lead_source_id', $lead_sources, 'Lead Source', $project->leadSource, route('projects.update', $project->id))
            @macro('editable_text', $permission_group, 'lead_source_details', 'Details', $project->lead_source_details, route('projects.update', $project->id))
        </div>

    </div>

    <div class="col-lg-9 col-lg-pull-3">

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Dates</b></h4>
            <div class="col-lg-3">
                @macro('editable_date', 'tasks', 'start_date', 'Start Date', $project->start_date, route('projects.update', $project->id))
            </div>
            <div class="col-lg-3">
                @macro('editable_date', 'tasks', 'due_date', 'Due Date', $project->due_date, route('projects.update', $project->id))
            </div>

            <div class="col-lg-3">
                @macro('label_title', 'Created', FieldRenderer::formatDate($project->created_at, true))
            </div>
            <div class="col-lg-3">
                @macro('label_title', 'Updated', FieldRenderer::formatDate($project->updated_at, true))
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
            <div class="col-lg-6">
                @macro('editable_text', $permission_group, 'name', 'Name', $project->name, route('projects.update', $project->id))
                @if( $project->scope == 'external' )
                        <span class="label label-info">EXTERNAL</span>
                @else
                        <span class="label label-warning">INTERNAL</span>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="company">Company</label>
                    <div class="editable-container">
                        <span class="edit-parent-span"><a href="{!! route('customers.details', $project->customer->id) !!}">{{ $project->customer->name }}</a></span>
                    </div>
                </div>
            </div>
            @if( $project->status == 'prospect' )
                <div class="col-lg-6">
                    @macro('editable_select', $permission_group, 'prospect_status_id', $prospect_statuses, 'Status', $project->prospectStatus, route('projects.update', $project->id))
                </div>
            @endif
            @if( $project->status == 'active' )
                <div class="col-lg-6">
                    @macro('editable_select', $permission_group, 'project_status_id', $project_statuses, 'Status', $project->projectStatus, route('projects.update', $project->id))
                </div>
            @endif
            <div class="col-lg-12">
                @macro('editable_multiselect', $permission_group, 'types', $project_types, 'Project Type(s)', $project->types, route('projects.update', $project->id))
            </div>
            <div class="col-lg-12">
                @macro('editable_textarea', $permission_group, 'description', 'Description', $project->description, route('projects.update', $project->id))
            </div>
            <div class="clearfix"></div>
        </div>

        @include('projects.fragments.subprojects')

        @include('fragments.media.attachments', ['object' => $project])

        @include('fragments.notes.notes', ['route' => ['projects.notes.add', $project->id], 'search_route' => ['projects.notes.search', $project->id]])

    </div>

</div>
