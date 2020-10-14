@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-md-11 col-sm-10">
                        @include('fragments.page.search')
                    </div>
                    <div class="col-md-1 col-sm-2 text-right">
                        <form action="" method="post">
                            {!! csrf_field() !!}
                            <input type="hidden" name="download" value="1" />
                            <button title="Download contacts" class="btn btn-default"><i class="fa fa-download"></i></button>
                        </form>
                    </div>
                </div>
                {{-- <div class="contacts-download-holder row">
                    <div class="col-md-6">
                        {{dd($types)}}
                        <select class="form-control">
                          <option value="-1">All</option>
                          <option value="0">Unasigned</option>
                          @foreach
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                    </div>
                </div> --}}

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px"></th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Type</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $contacts as $contact )
                            @if( is_object($contact->contactType) )
                                <tr style="border-left: solid 6px #{{ $contact->contactType->colour }};">
                            @else
                                <tr>
                            @endif
                                <td>
                                    <img src="{!! $contact->imageUrl(100, 100) !!}" alt="{{ $contact->first_name }} {{ $contact->last_name }}" title="{{ $contact->first_name }} {{ $contact->last_name }}" class="img-circle thumb-sm" />
                                </td>

                                <td>
                                    <a href="{!! route('contacts.details', $contact->id) !!}">{!! $contact->first_name !!} {!! $contact->last_name !!}</a>
                                </td>

                                <td>
                                    @if( is_object($contact->customer) )
                                        <a href="{{ route('customers.details', $contact->customer->id) }}">{!! $contact->customer->name !!}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    @if( is_object($contact->type) )
                                        {!! ucwords($contact->type->name) !!}
                                    @else
                                        None
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $contacts->links() !!}
                </div>
            </div>
        </div> <!-- end col -->

    </div>

@endsection
