@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    <div class="btn-group pull-right m-t-15">
        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#add-customer-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add {{ ucwords($type) }}</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                @include('fragments.page.search')

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th class="hidden-xs">Category</th>
                            <th class="hidden-xs">Projects</th>
                            <th class="hidden-xs">Creation Date</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach( $customers as $customer )
                                @if( is_object($customer->type) )
                                    <tr style="border-left: solid 6px #{{ $customer->type->colour }};">
                                @else
                                    <tr>
                                @endif
                                <td>
                                    <a href="{!! route('customers.details', $customer->id) !!}">
                                        <img src="{!! $customer->imageUrl(100, 100) !!}" alt="{{ $customer->name }}" title="{{ $customer->name }}" class="thumb-sm" />
                                    </a>
                                </td>

                                <td>
                                    <a href="{!! route('customers.details', $customer->id) !!}">{!! $customer->name !!}</a>
                                </td>

                                <td class="hidden-xs">
                                    @if( is_object($customer->category) )
                                        {!! $customer->category->name !!}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td class="hidden-xs">
                                    {!! $customer->projects()->count() !!}
                                </td>

                                <td class="hidden-xs">
                                    {!! $customer->created_at->format(Config::get('system.date.short')) !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $customers->links() !!}
                </div>
            </div>
        </div>

    </div> <!-- end col -->


    @embed('fragments.page.modal', ['id' => 'add-customer-modal', 'route' => 'customers.store', 'files' => false, 'title' => 'Add ' . ucwords($type), 'button' => trans('global.save')])

        @section('content')

            {!! Form::hidden('type', $type) !!}
            @macro('select_title', 'category', $customer_types, 'Company category')
            @macro('text_title', 'name', 'Company name')
            @macro('textarea_title', 'description', 'Company description')

        @endsection

    @endembed

@endsection