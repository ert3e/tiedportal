@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('finance', 'edit') || Permissions::has('finance', 'delete') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#accept-quote-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-check"></i> Accept Quote</a>
                </li>
                @if( Permissions::has('finance', 'delete') )
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Quote" data-message="Are you sure you want to delete this quote? This action cannot be undone!" data-confirm="Quote deleted!" data-redirect="{{ URL::previous() }}" data-href="{{ route('quotes.delete', ['id' => $quote->id, '_token' => csrf_token()]) }}" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Quote</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    <div class="editable-image mb-b-10">
                        @if( is_object($supplier->media) )
                            <img src="{{ route('media.get', [$supplier->media_id, 200, 200]) }}" alt="{{ $supplier->name }}" />
                        @else
                            <img src="/img/generic-supplier.png" alt="{{ $supplier->name }}" />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Supplier</label>
                            <p><a href="{{ route('suppliers.details', $supplier->id) }}">{{ $supplier->name }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Project</label>
                            <p><a href="{{ route('projects.details', $project->id) }}">{{ $project->name }}</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @macro('text', 'Reference', $quote->reference)
                    </div>
                    <div class="col-md-6">
                        @macro('text', 'Cost', '&pound;' . number_format($quote->cost, 2))
                    </div>
                    <div class="col-md-12">
                        @macro('text', 'Message', nl2br($quote->message))
                    </div>
                </div>

            </div>

        </div>

        @embed('fragments.page.modal', ['id' => 'accept-quote-modal', 'route' => ['quotes.accept', $quote->id], 'files' => false, 'title' => 'Accept Quote', 'button' => trans('global.save')])

            @section('content')

                <div class="row">
                    <div class="col-md-6">
                        @macro('currency_title', 'value', 'Value (to client)', true, '0')
                    </div>
                    <div class="col-md-6">
                        @macro('currency_title', 'cost', 'Cost (to us)', true, number_format($quote->cost, 2))
                    </div>
                </div>
                @macro('textarea_title', 'description', 'Description', false)

            @endsection

        @endembed

@endsection