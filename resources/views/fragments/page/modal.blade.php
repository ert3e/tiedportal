<div id="{{ $id }}" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">{{ $title }}</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => $route, 'files' => $files]) !!}

            @yield('content')

            <button type="submit" class="btn btn-default waves-effect waves-light">{{ $button }}</button>
            <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
        {!! Form::close() !!}
    </div>
</div>