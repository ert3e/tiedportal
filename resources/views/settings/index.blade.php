@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <p>{{ trans('settings.welcome') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Setting</th>
                                <th>Description</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $settings as $setting )
                                <tr>
                                    <td>
                                        {!! $setting['name'] !!}
                                    </td>

                                    <td>
                                        {!! $setting['description'] !!}
                                    </td>
                                    <td>
                                        <a href="{!! $setting['url'] !!}" title="Edit" class="btn btn-default waves-effect waves-light"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection