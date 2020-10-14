<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Bills</b></h4>
            @if( $bills->count() )
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Supplier</th>
                            <th>Due Date</th>
                            <th>Paid</th>
                            <th class="text-right">Amount</th>
                            <th style="width: 34px"></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th class="text-right">&pound;{{ number_format($total_bills, 2) }}</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @foreach( $bills as $bill )
                            <tr>
                                <td>{{ $bill->project->name }}</td>
                                <td>
                                    @if( is_object($bill->supplier) )
                                        <a href="{!! route('suppliers.details', $bill->supplier->id) !!}">{{ $bill->supplier->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {!! FieldRenderer::dueDate($bill->due_date) !!}
                                </td>
                                <td>
                                    {{{ is_null($bill->paid_date) ? 'Unpaid' : $bill->paid_date->format('d/m/Y') }}}
                                </td>
                                <td class="text-right">&pound;{{ number_format($bill->amount, 2) }}</td>
                                <td style="width: 34px">
                                    <a href="{{ route('projects.bills.edit', [$bill->project->id, $bill->id]) }}" class="btn btn-sm btn-default" title="Edit" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
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
    </div>
</div>