@include('macros.form')
<div id="edit-cost-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit cost</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => ['projects.costs.update', $project->id, $cost->id]]) !!}

        {{ csrf_field() }}

        @if( is_object($cost->supplier) )
            @macro('text', 'Supplier', $cost->supplier->name)
        @else
            @macro('typeahead_title', 'supplier_id', route('suppliers.autocomplete'), 'Supplier', false)
        @endif
        <div class="row">
            <div class="col-md-6">
                @macro('currency_title', 'value', 'Value (to client)', true, $cost->value)
            </div>
            <div class="col-md-6">
                @macro('currency_title', 'cost', 'Cost (to us)', true, $cost->cost)
            </div>
        </div>
        @macro('textarea_title', 'description', 'Description', true, $cost->description)

        <button type="submit" class="btn btn-default waves-effect waves-light">{{ trans('global.save') }}</button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">{{ trans('global.cancel') }}</button>

        {!! Form::close() !!}
    </div>
</div>
