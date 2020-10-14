@include('macros.form')
<div id="edit-setting-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add {{ str_singular($component_type->name) }}</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => ['projects.components.store', $object->id, $component_type->id], 'files' => true]) !!}

        {{ csrf_field() }}

        @foreach( $component_type->fields as $field )

            @if( $field->type == 'text' )
                @macro('text_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'password' )
                @macro('text_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'longtext' )
                @macro('textarea_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'number' )
                @macro('number_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'decimal' )
                @macro('decimal_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'date' )
                @macro('date_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'time' )
                @macro('time_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'datetime' )
                @macro('datetime_title', 'fields[' . $field->id . ']', $field->name, false)
            @elseif( $field->type == 'file' )
                @macro('file_title', 'fields[' . $field->id . ']', $field->name, false)
            @endif

        @endforeach

        <button type="submit" class="btn btn-default waves-effect waves-light">{{ trans('global.save') }}</button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">{{ trans('global.cancel') }}</button>

        {!! Form::close() !!}
    </div>
</div>