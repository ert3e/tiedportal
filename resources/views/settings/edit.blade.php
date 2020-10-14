@include('macros.form')
<div id="edit-setting-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit {{ str_singular($title) }}</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => ['settings.update', $type, $id]]) !!}

        {{ csrf_field() }}

        @foreach( $fields as $key => $field )

            @if( $field['type'] == 'text' )
                @macro('text_title', $key, $field['name'], false, $item->$key)
            @elseif( $field['type'] == 'textarea' )
                @macro('textarea_title', $key, $field['name'], false, $item->$key)
            @elseif( $field['type'] == 'colour' )
                @macro('colour_title', $key, $field['name'], false, $item->$key)
            @elseif( $field['type'] == 'image' )
                @macro('image_title', $key, $field['name'], false, $item->$key)
            @endif

        @endforeach

        <button type="submit" class="btn btn-default waves-effect waves-light">{{ trans('global.save') }}</button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">{{ trans('global.cancel') }}</button>
        {!! Form::close() !!}
    </div>
</div>