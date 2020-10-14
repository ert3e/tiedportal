<div class="card-box">
    @if( Permissions::has('projects', 'edit') )
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                @foreach( $component_types as $component_type )
                    <li>
                        <a href="{{ route('projects.components.create', [$project->id, $component_type->id]) }}" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add {{ $component_type->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <h4 class="m-t-0 m-b-30 header-title"><b>Components</b></h4>
    @if( $project->components()->count() )
        @foreach( $project->components as $component )
            @include('fragments.page.component', ['component' => $component])
        @endforeach
        <div style="clear: both;"></div>
    @else
        <p><em>Nothing to show</em></p>
    @endif
</div>