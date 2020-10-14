@if( $note->user_id == Auth::user()->id )
    <div class="time-item note" data-delete-url="{{ route('notes.delete', $note->id) }}" data-update-url="{{ route('notes.update', $note->id) }}" data-id="{{$note->id}}">
        <div class="item-info">
            <div class="pull-right actions">
                <button class="delete-note btn btn-sm btn-danger fa fa-trash"></button>
            </div>
            <div class="text-muted">{{ $note->created_at->diffForHumans() }}</div>
            <div><strong>{!! FieldRenderer::user($note->user) !!}</strong> <span class="label label-primary">{{$note->type}}</span><br/>
                <div class="note-content note-content-editable" data-contenteditable="true">
                    <p>
                        {!! FieldRenderer::longtext($note->content) !!}
                    </p>
                    <span class="pull-right actions update-note-holder">
                        <button class="update-note btn btn-sm btn-info fa fa-save"> Save</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

@else
    <div class="time-item note">
        <div class="item-info">
            <div class="text-muted">{{ $note->created_at->diffForHumans() }}</div>
            <div><strong>{!! FieldRenderer::user($note->user) !!}</strong> {{$note->type}}<br/>
                <p class="note-content">
                    {!! FieldRenderer::longtext($note->content) !!}
                </p>
            </div>
        </div>
    </div>
@endif
