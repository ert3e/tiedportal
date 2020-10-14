@extends('layout.html')

@section('title')
    Login
@endsection

@include('macros.form')
@include('macros.messages')

@section('body')

    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div class=" card-box">
            <div class="panel-heading">
                <div class="text-center">
                    <H1>Tienda.digital</H1>
                    <!-- <img src="/img/logo-large.png" alt="{!! Config::get('system.name.plain') !!}" /> -->
                </div>
                <h3 class="text-center">Forgotten your password?</h3>
            </div>


            <div class="panel-body">

                @macro('errors')
                @macro('messages')

                <p class="text-center">Enter your email address below and we will send you instructions on how to reset your password.</p>

                {!! Form::open(['route' => 'reset.post', 'class' => 'form-horizontal m-t-20']) !!}

                <div class="form-group ">
                    <div class="col-xs-12">
                        @macro('email', 'email', null, ['class' => 'form-control', 'placeholder' => 'Email address'])
                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{!! route('login') !!}" class="text-dark"><i class="fa fa-chevron-left m-r-5"></i> Back to login</a>
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>

    </div>

@endsection