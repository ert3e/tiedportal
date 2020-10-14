@include('macros.form')
<div id="edit-cost-modal" class="modal-ajax">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit bill</h4>
    <div class="custom-modal-text text-left">
        {!! Form::open(['route' => ['projects.bills.update', $project->id, $bill->id], 'class' => 'refresh']) !!}

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6">
                @macro('text_title', 'reference', 'Reference', true, $bill->reference)
            </div>
            <div class="col-md-6">
                @macro('currency_title', 'amount', 'Amount', true, $bill->amount)
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @macro('date_title', 'date', 'Date', true, $bill->date->format('d/m/Y'))
            </div>
            <div class="col-md-6">
                @macro('date_title', 'due_date', 'Due date', true, $bill->due_date->format('d/m/Y'))
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @macro('date_title', 'paid_date', 'Paid date', false, is_null($bill->paid_date) ? '' : $bill->paid_date->format('d/m/Y'))
            </div>
        </div>

        <button type="submit" class="btn btn-default waves-effect waves-light" data-loading-text="Saving...">{{ trans('global.save') }}</button>
        <button type="button" onclick="Custombox.close();" class="btn btn-danger waves-effect waves-light m-l-10">{{ trans('global.cancel') }}</button>

        {!! Form::close() !!}
    </div>
</div>
