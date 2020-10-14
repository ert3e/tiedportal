@set('input_id', uniqid('typeahead'))
<div class="form-group assignee-block" data-add-url="{{ $add_url }}" data-remove-url="{{ $remove_url }}" data-token="{{ csrf_token() }}">
    <label for="company">Assignee(s)</label>
    <p>
    <ul style="overflow: hidden;" class="list-unstyled assignee-list nicescroll" tabindex="5001">
        @foreach( $object->assignees as $user )
            @include('fragments.users.assignee', ['assignee' => $user])
        @endforeach
    </ul>

        <div class="input-group">
            {!! Form::hidden('assignee_id', null, ['id' => $input_id, 'class' => 'user-id']) !!}
            {!! Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing user...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => route('users.autocomplete')]) !!}

            <span class="input-group-btn">
                <button class="btn btn-default add" data-loading-text="Adding..." type="button">Add</button>
            </span>
        </div>
    </p>
</div>
@unset('input_id')
