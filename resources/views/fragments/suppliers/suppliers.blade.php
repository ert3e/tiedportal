@set('input_id', uniqid('typeahead'))
<div class="form-group supplier-block" data-add-url="{{ $add_url }}" data-remove-url="{{ $remove_url }}" data-token="{{ csrf_token() }}">
    <label for="company">Supplier(s)</label>
    <p>
    <ul style="overflow: hidden;" class="list-unstyled supplier-list nicescroll" tabindex="5001">
        @foreach( $object->suppliers as $supplier )
            @include('fragments.suppliers.supplier', ['supplier' => $supplier])
        @endforeach
    </ul>

        <div class="input-group">
            {!! Form::hidden('supplier_id', null, ['id' => $input_id, 'class' => 'supplier-id']) !!}
            {!! Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing supplier...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => route('suppliers.autocomplete')]) !!}

            <span class="input-group-btn">
                <button class="btn btn-default add" data-loading-text="Adding..." type="button">Add</button>
            </span>
        </div>
    </p>
</div>
@unset('input_id')
