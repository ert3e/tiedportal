@macrodef('errors', $message = 'An error occurred while processing your request:')
    @if( Session::has('errors') )
        <div class="alert alert-danger">
            <p>{!! $message !!}</p>
            <ul>
                @foreach( Session('errors')->all() as $error )
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if( Session::has('error') )
        <div class="alert alert-danger">
            <p>{!! Session::get('error') !!}</p>
        </div>
    @endif
@endmacro

@macrodef('messages')
@if( Session::has('info') )
    <div class="alert alert-info">
        <p>{!! Session::get('info') !!}</p>
    </div>
@endif
@if( Session::has('success') )
    <div class="alert alert-success">
        <p>{!! Session::get('success') !!}</p>
    </div>
@endif
@if( Session::has('status') )
    <div class="alert alert-success">
        <p>{!! Session::get('status') !!}</p>
    </div>
@endif
@endmacro