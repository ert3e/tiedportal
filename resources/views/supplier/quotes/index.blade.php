@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    @macro('messages')

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        Quotes
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th class="hidden-xs">Request date</th>
                                    <th class="hidden-xs">Type(s)</th>
                                    <th style="width: 5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach( $pending as $quote_request )
                                    <tr>
                                        <td>
                                            {{ $quote_request->project->name }}
                                            @if( $quote_request->project->children()->count() )
                                                <span class="badge badge-default">{{ $quote_request->project->children()->count() }}</span>
                                            @endif
                                        </td>
                                        <td class="hidden-xs">
                                            {{ $quote_request->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="hidden-xs">
                                            @foreach( $quote_request->project->types as $project_type )
                                                <span class="label label-default">{{ $project_type->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{!! route('supplier.quotes.view', $quote_request->id) !!}" class="btn btn-default waves-effect waves-light"><i class="fa fa-search"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    </div>

@endsection
