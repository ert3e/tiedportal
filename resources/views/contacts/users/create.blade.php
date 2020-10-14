@include('macros.form')
<div id="create-user-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Create user</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => ['contacts.user.store', $contact->id]]) !!}

        {{ csrf_field() }}

        <p>By creating a user this contact will be able to login to the Blush.Digital system.</p>

        @macro('text_title', 'username', 'Username', true, $username)
        @macro('textarea_title', 'message', 'Message', false)

        <button type="submit" class="btn btn-default waves-effect waves-light">{{ trans('global.save') }}</button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">{{ trans('global.cancel') }}</button>
        {!! Form::close() !!}
    </div>
</div>
