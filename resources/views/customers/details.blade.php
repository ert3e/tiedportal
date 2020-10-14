@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('customers', 'edit') || Permissions::has('contacts', 'create') || Permissions::has('customers', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                @if( Permissions::has('customers', 'edit') )
                <li>
                    <a href="#add-address-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Address</a>
                </li>
                @endif
                @if( Permissions::has('contacts', 'create') )
                <li>
                    <a href="#add-contact-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Contact</a>
                </li>
                @endif
                @if( Permissions::has('customers', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Customer" data-message="Are you sure you want to delete this customer? This action cannot be undone!" data-confirm="Customer deleted!" data-redirect="{{ route('customers.index') }}" data-href="{{ route('customers.delete', ['id' => $customer->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Customer</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row filedrop" data-attach-url="{{ route('customers.attachments.attach', $customer->id) }}" data-detach-url="{{ route('customers.attachments.detach', $customer->id) }}" data-token="{{ csrf_token() }}">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    @if( is_object($customer->media) )
                        @macro('editable_image', 'customers', route('media.get', [$customer->media_id, 200, 200]), ['customers.media.upload', $customer->id])
                    @else
                        @macro('editable_image', 'customers', '/img/generic-customer.png', ['customers.media.upload', $customer->id])
                    @endif
                </div>
            </div>

            @if( Permissions::has('contacts', 'view') && $customer->contacts()->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Contacts</b>
                        {{-- <a target="_blank" class="pull-right" href="{{route('customers.contacts.download', $customer->id)}}" title="Download contacts"><i class="fa fa-download"></i></a> --}}
                    </h4>
                    <div class="inbox-widget" style="overflow: hidden;" tabindex="5001">
                        @foreach( $customer->contacts as $contact )
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img alt="" class="img-circle" style="border: solid 2px #{{ $contact->contactType->colour }}" src="{{ $contact->imageUrl() }}"></div>
                                <p class="inbox-item-author">{{ $contact->first_name }} {{ $contact->last_name }}</p>
                                <p class="inbox-item-text">
                                    @if( is_object($contact->contactType) )
                                        {{ $contact->contactType->name }}<br/>
                                    @endif
                                    @if( strlen($contact->telephone) )
                                        <i class="fa fa-mobile-phone"></i> {{ $contact->telephone }}<br/>
                                    @endif
                                    @if( strlen($contact->mobile) )
                                        <i class="fa fa-mobile-telephone"></i> {{ $contact->mobile }}<br/>
                                    @endif
                                    @if( strlen($contact->email) )
                                        <a href="mailto:{{ $contact->email }}"><i class="fa fa-envelope"></i> {{ $contact->email }}</a><br/>
                                    @endif
                                </p>
                                @if( Permissions::has('contacts', 'edit') )
                                    <p class="inbox-item-date">
                                        <a href="{{ route('contacts.details', $contact->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if( Permissions::has('timeline', 'view') )
                <div class="card-box">
                    @include('fragments.timeline.index', ['object' => $customer])
                </div>
            @endif
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        @macro('editable_select', 'customers', 'category_id', $customer_types, 'Type', $customer->category, route('customers.update', $customer->id))
                    </div>
                    <div class="col-md-6">
                        @macro('editable_text', 'customers', 'website', 'Website', $customer->website, route('customers.update', $customer->id))
                    </div>
                </div>
                @macro('editable_text', 'customers', 'name', 'Name', $customer->name, route('customers.update', $customer->id))
                @macro('editable_textarea', 'customers', 'description', 'Description', $customer->description, route('customers.update', $customer->id))
            </div>

            @foreach( $customer->addresses as $address )

                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>{{ $address->name }}</b></h4>
                    <p>{{ $address->asString() }}</p>
                </div>

            @endforeach

            @if( Permissions::has('projects', 'view') && $customer->projects()->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Projects</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="hidden-xs">Type(s)</th>
                                @if( Permissions::has('finance', 'view') )
                                    <th class="hidden-xs text-right">Value</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $customer->projects as $project )
                                <tr>
                                    <td>
                                        <a href="{!! route('projects.details', $project->id) !!}">{{ $project->name }}
                                            @if( $project->children()->count() )
                                                <span class="badge badge-default">{{ $project->children()->count() }}</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        @if( $project->status == 'prospect' || $project->status == 'lost' )
                                            @if( is_object($project->prospectStatus) )
                                                <span class="label" style="background-color:#{{ $project->prospectStatus->colour }}">{{ $project->prospectStatus->name }}</span>
                                            @else
                                                <span class="label label-danger">None</span>
                                            @endif
                                        @else
                                            @if( is_object($project->projectStatus) )
                                                <span class="label" style="background-color:#{{ $project->projectStatus->colour }}">{{ $project->projectStatus->name }}</span>
                                            @else
                                                <span class="label label-danger">None</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="hidden-xs">
                                        @foreach( $project->types as $project_type )
                                            <span class="label label-default">{{ $project_type->name }}</span>
                                        @endforeach
                                    </td>
                                    @if( Permissions::has('finance', 'view') )
                                        <td class="hidden-xs text-right">
                                            {{ FieldRenderer::formatCurrency($project->costs()->sum('value')) }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if( Permissions::has('leads', 'view') && $customer->prospects()->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Prospects</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="hidden-xs">Type(s)</th>
                                @if( Permissions::has('finance', 'view') )
                                    <th class="hidden-xs text-right">Value</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $customer->prospects as $project )
                                <tr>
                                    <td>
                                        <a href="{!! route('projects.details', $project->id) !!}">{{ $project->name }}
                                            @if( $project->children()->count() )
                                                <span class="badge badge-default">{{ $project->children()->count() }}</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        @if( $project->status == 'prospect' || $project->status == 'lost' )
                                            @if( is_object($project->prospectStatus) )
                                                <span class="label" style="background-color:#{{ $project->prospectStatus->colour }}">{{ $project->prospectStatus->name }}</span>
                                            @else
                                                <span class="label label-danger">None</span>
                                            @endif
                                        @else
                                            @if( is_object($project->projectStatus) )
                                                <span class="label" style="background-color:#{{ $project->projectStatus->colour }}">{{ $project->projectStatus->name }}</span>
                                            @else
                                                <span class="label label-danger">None</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="hidden-xs">
                                        @foreach( $project->types as $project_type )
                                            <span class="label label-default">{{ $project_type->name }}</span>
                                        @endforeach
                                    </td>
                                    @if( Permissions::has('finance', 'view') )
                                        <td class="hidden-xs text-right">
                                            {{ FieldRenderer::formatCurrency($project->costs()->sum('value')) }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if( Permissions::has('tasks', 'view') && $tasks->count() )
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Tasks</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th class="hidden-xs">Project</th>
                                <th class="hidden-xs">Assignee(s)</th>
                                <th class="hidden-xs">Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $tasks as $task )
                                <tr>
                                    <td>
                                        <a href="{!! route('tasks.details', $task->id) !!}">{{ $task->title }}
                                            @if( $task->children()->count() )
                                                <span class="badge badge-default">{{ $task->children()->count() }}</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        @if( is_object($task->project) )
                                            <a href="{{ route('projects.details', $task->project->id) }}">{{ $task->project->name }}</a>
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td class="hidden-xs">
                                        {!!  FieldRenderer::users($task->assignees) !!}
                                    </td>
                                    <td class="hidden-xs">
                                        @if( is_object($task->taskType) )
                                            <span class="label label-default" style="background-color: #{{ $task->taskType->colour }}">{{ $task->taskType->name }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ array_get(App\Models\Task::$priorities, $task->priority, 'Default') }}
                                    </td>
                                    <td>
                                        @if( is_object($task->taskStatus) )
                                            <span class="label label-default" style="background-color: #{{ $task->taskStatus->colour }}">{{ $task->taskStatus->name }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @include('fragments.media.attachments', ['object' => $customer])

            @include('fragments.notes.notes', ['route' => ['customers.notes.add', $customer->id], 'search_route' => ['customers.notes.search', $customer->id]])
    </div>

    @if( Permissions::has('customers', 'edit') )
        @embed('fragments.page.modal', ['id' => 'add-address-modal', 'route' => ['customers.address.store', $customer->id], 'files' => false, 'title' => 'Add Address', 'button' => trans('global.save')])

            @section('content')

                @macro('text_title', 'name', 'Address name', true)
                @macro('text_title', 'address1', 'Address line 1', true)
                @macro('text_title', 'address2', 'Address line 2')
                @macro('text_title', 'town', 'Town', true)
                @macro('text_title', 'county', 'County', true)
                @macro('text_title', 'postcode', 'Postcode', true)
                @macro('text_title', 'country', 'Country', true)

            @endsection

        @endembed
    @endif

    @if( Permissions::has('contacts', 'create') )
        @embed('fragments.page.modal', ['id' => 'add-contact-modal', 'route' => ['customers.contact.store', $customer->id], 'files' => true, 'title' => 'Add Contact', 'button' => trans('global.save')])

            @section('content')

                <div class="col-sm-6">
                    @macro('text_title', 'first_name', 'First name', true)
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'last_name', 'Last name', false)
                </div>

                <div class="col-sm-6">
                    @macro('select_title', 'type_id', $contact_types, 'Contact type', true)
                </div>
                <div class="col-sm-6">
                    @macro('image_title', 'media', 'Image')
                </div>

                <div class="col-sm-6">
                    @macro('text_title', 'telephone', 'Telephone')
                </div>
                <div class="col-sm-6">
                    @macro('text_title', 'mobile', 'Mobile')
                </div>
                <div class="col-sm-12">
                    @macro('text_title', 'email', 'Email address')
                </div>
                <div class="col-sm-12">
                    @macro('textarea_title', 'description', 'Description')
                </div>

            @endsection

        @endembed
    @endif
@endsection
