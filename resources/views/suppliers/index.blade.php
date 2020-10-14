@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    <div class="btn-group pull-right m-t-15">
        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#add-supplier-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Supplier</a>
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

                <form role="form" method="GET">
                    <div class="row m-b-30">
                        <div class="col-sm-6">
                            <div class="form-group contact-search">
                                <input type="text" name="search" class="form-control autosubmit delayed" placeholder="Search..." value="{{ $term }}">
                                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('type', $type_options, $type, ['class' => 'form-control autosubmit']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::select('status', $statuses, $status, ['class' => 'form-control autosubmit']) !!}
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Types</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $suppliers as $supplier )
                            <tr>
                                <td>
                                    <a href="{!! route('suppliers.details', $supplier->id) !!}">
                                    @if( is_object($supplier->media) )
                                        <img src="{!! route('media.get', [$supplier->media_id, 100, 100]) !!}" alt="{{ $supplier->name }}" title="{{ $supplier->name }}" class="img-circle thumb-sm" />
                                    @else
                                        <img src="/img/generic-supplier-small.png" alt="{{ $supplier->name }}" title="{{ $supplier->name }}" class="img-circle thumb-sm" />
                                    @endif
                                    </a>
                                </td>

                                <td>
                                    <a href="{!! route('suppliers.details', $supplier->id) !!}">
                                    {{ $supplier->name }}
                                    @if( $supplier->verified )
                                        <span class="label label-success">{{ trans('global.verified') }}</span>
                                    @else
                                        <span class="label label-danger">{{ trans('global.unverified') }}</span>
                                    @endif
                                    </a>
                                </td>

                                <td>
                                    @if( is_object($supplier->contacts()->first()) )
                                        {{ $supplier->contacts()->first()->first_name }} {{ $supplier->contacts()->first()->last_name }}
                                    @else
                                        None
                                    @endif
                                </td>

                                <td>
                                    @foreach( $supplier->projectTypes as $project_type )
                                        <span class="label label-default">{{ $project_type->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $suppliers->links() !!}
                </div>
            </div>
        </div>

    </div> <!-- end col -->


    @embed('fragments.page.modal', ['id' => 'add-supplier-modal', 'route' => 'suppliers.store', 'files' => false, 'title' => 'Add Supplier', 'button' => trans('global.save')])

        @section('content')

            @macro('text_title', 'name', 'Supplier name')
            @macro('textarea_title', 'description', 'Supplier description')

        @endsection

    @endembed

@endsection