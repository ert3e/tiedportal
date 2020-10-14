@if( $project->children()->count() )
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
                @foreach( $project->children as $subproject )
                    <tr>
                        <td>
                            <a href="{!! route('projects.details', $subproject->id) !!}">
                                {{ $subproject->name }}
                            @if( $subproject->children()->count() )
                                <span class="badge badge-default">{{ $subproject->children()->count() }}</span>
                            @endif
                            </a>
                        </td>
                        <td>
                            @foreach( $subproject->types as $project_type )
                                <span class="label label-default">{{ $project_type->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif