@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                <li class="active tab">
                    <a href="#overview" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-line-chart"></i></span>
                        <span class="hidden-xs">Overview</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#invoices" data-toggle="tab" aria-expanded="true">
                        <span><i class="fa fa-money"></i></span>
                        <span class="hidden-xs">Costs</span>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane active">
                    @include('finance.fragments.overview')
                </div>
                <div id="invoices" class="tab-pane">
                    @include('finance.fragments.invoices')
                </div>
            </div>
        </div>
    </div>

@endsection

