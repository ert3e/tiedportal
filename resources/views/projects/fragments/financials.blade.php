<div class="row">
    <div class="col-md-9">
        <div class="card-box">
            @if( Permissions::has('finance', 'create') )
                <div class="btn-group pull-right">
                    <a href="#add-cost-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a" class="btn btn-default waves-effect waves-light">Add <span class="m-l-5"><i class="fa fa-plus"></i></span></a>
                </div>
            @endif
            <h4 class="m-t-0 m-b-30 header-title"><b>Costs</b></h4>
            @if( $costs->count() )
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Invoiced</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Value</th>
                            <th style="width: 90px"></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="3">Total Costs</th>
                            <th class="text-right">&pound;{{ number_format($total_costs, 2) }}</th>
                            <th class="text-right">&pound;{{ number_format($total_value, 2) }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @foreach( $costs as $cost )
                            <tr>
                                <td>{{ $cost->description }}</td>
                                <td>
                                    @if( is_object($cost->supplier) )
                                        <a href="{!! route('suppliers.details', $cost->supplier->id) !!}">{{ $cost->supplier->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {{{ $cost->invoiced ? 'Yes' : 'No' }}}
                                </td>
                                <td class="text-right">&pound;{{ number_format($cost->cost, 2) }}</td>
                                <td class="text-right">&pound;{{ number_format($cost->value, 2) }}</td>
                                <td style="width: 90px; text-align:right;">
                                    <a href="{{ route('projects.costs.edit', [$project->id, $cost->id]) }}" class="btn btn-sm btn-default" title="Edit" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                                       data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i></a>
                                    <a href="#" title="Delete" data-title="Delete Cost" data-message="Are you sure you want to delete this cost? This action cannot be undone!" data-confirm="Cost deleted!" data-redirect="{{ route('projects.details', [$project->id, '#finance']) }}" data-href="{{ route('projects.costs.delete', ['id' => $project->id, 'cost' => $cost->id, '_token' => csrf_token()]) }}" class="btn btn-danger btn-sm delete-button"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p><em>Nothing to show</em></p>
            @endif
        </div>

        <div class="card-box">
            @if( Permissions::has('finance', 'create') )
                <div class="btn-group pull-right">
                    <a href="#add-bill-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a" class="btn btn-default waves-effect waves-light">Add <span class="m-l-5"><i class="fa fa-plus"></i></span></a>
                </div>
            @endif
            <h4 class="m-t-0 m-b-30 header-title"><b>Bills</b></h4>
            @if( $bills->count() )
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Reference</th>
                            <th>Paid</th>
                            <th>Attachment</th>
                            <th class="text-right">Cost</th>
                            <th style="width:34px"></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="5">Total Bills</th>
                            <th class="text-right">&pound;{{ number_format($bill_total, 2) }}</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @foreach( $bills as $bill )
                            <tr>
                                <td>
                                    {{ $bill->date->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{!! route('suppliers.details', $bill->supplier->id) !!}">{{ $bill->supplier->name }}</a>
                                </td>
                                <td>
                                    {{ $bill->reference }}
                                </td>
                                <td>
                                    {{{ is_null($bill->paid_date) ? 'Unpaid' : $bill->paid_date->format('d/m/Y') }}}
                                </td>
                                <td>
                                    <a href="{{ route('media.download', $bill->media->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-cloud-download"></i> Download</a>
                                </td>
                                <td class="text-right">&pound;{{ number_format($bill->amount, 2) }}</td>
                                <td style="width: 34px">
                                    <a href="{{ route('projects.bills.edit', [$project->id, $bill->id]) }}" class="btn btn-sm btn-default" title="Edit" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                                       data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p><em>Nothing to show</em></p>
            @endif
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Quotes</b></h4>
            @if( $quotes->count() )
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Reference</th>
                            <th class="text-right">Cost</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $quotes as $quote )
                            <tr>
                                <td>
                                    <a href="{{ route('quotes.details', $quote->id) }}">{{ $quote->created_at->format('d/m/Y') }}</a>
                                </td>
                                <td>
                                    <a href="{!! route('suppliers.details', $quote->supplier->id) !!}">{{ $quote->supplier->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('quotes.details', $quote->id) }}">{{ $quote->reference }}</a>
                                </td>
                                <td class="text-right">&pound;{{ number_format($quote->cost, 2) }} ({{{ $quote->includes_vat ? 'inc. VAT' : 'ex. VAT' }}})</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p><em>Nothing to show</em></p>
            @endif
        </div>

    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Project Value</b></h4>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Value</label>
                    <p>&pound;{{ number_format($total_value, 2) }}</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Cost</label>
                    <p>&pound;{{ number_format($total_costs, 2) }}</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Profit</label>
                    <p>&pound;{{ number_format($profit, 2) }} ({{ number_format($profit_percent, 0) }}%)</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Quote Requests</b></h4>
            @if( $quote_requests->count() )
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $quote_requests as $quote_request )
                            <tr>
                                <td>
                                    <a href="{!! route('suppliers.details', $quote_request->supplier->id) !!}">{{ $quote_request->supplier->name }}</a>
                                </td>
                                <td>
                                    {{ ucwords($quote_request->status) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p><em>Nothing to show</em></p>
            @endif

            @if( Permissions::has('quotes', 'create') )
                <div class="row">
                    <div class="btn-group btn-group-block m-t-10">
                        <a href="{{ route('quotes.request', $project->id) }}" class="btn btn-sm btn-primary col-sm-12"><i class="fa fa-share"></i> Request Quote</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@embed('fragments.page.modal', ['id' => 'add-cost-modal', 'route' => ['projects.costs.create', $project->id], 'files' => false, 'title' => 'Add Cost', 'button' => trans('global.save')])

    @section('content')

        @macro('typeahead_title', 'supplier_id', route('suppliers.autocomplete'), 'Supplier', false)
        <div class="row">
            <div class="col-md-6">
                @macro('currency_title', 'value', 'Value (to client)', true, '0')
            </div>
            <div class="col-md-6">
                @macro('currency_title', 'cost', 'Cost (to us)', true, '0')
            </div>
        </div>
        @macro('textarea_title', 'description', 'Description', false)

    @endsection

@endembed

@embed('fragments.page.modal', ['id' => 'add-bill-modal', 'route' => ['projects.bills.create', $project->id], 'files' => true, 'title' => 'Add Bill', 'button' => trans('global.save')])

    @section('content')

        @macro('typeahead_title', 'supplier_id', route('suppliers.autocomplete'), 'Supplier', false)
        <div class="row">
            <div class="col-md-6">
                @macro('text_title', 'reference', 'Reference', true)
            </div>
            <div class="col-md-6">
                @macro('currency_title', 'amount', 'Amount', true, '0')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @macro('date_title', 'date', 'Date', true)
            </div>
            <div class="col-md-6">
                @macro('date_title', 'due_date', 'Due date', true)
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @macro('date_title', 'paid_date', 'Paid date', false)
            </div>
            <div class="col-md-6">
                @macro('file_title', 'file', 'Upload', true)
            </div>
        </div>

    @endsection

@endembed