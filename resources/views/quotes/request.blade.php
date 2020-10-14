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
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Request a quote</b></h4>
                            <p class="text-muted m-b-30 font-13">
                                Complete the wizard below to request a quote based on the project <strong>{{ $project->name }}</strong>.
                            </p>

                            {!! Form::open(['route' => ['quotes.request.send', $project->id], 'id' => 'request-wizard', 'class' => 'wizard-horizontal']) !!}

                                @if( $project->components->count() )
                                    <h3>Components</h3>
                                    <section>
                                        <p>Please select the components you would like to send to the supplier.</p>

                                        @foreach( $project->components as $component )
                                            @macro('checkbox', 'component[]', $component->name, false, $component->id)
                                        @endforeach

                                    </section>
                                @endif

                                <h3>Suppliers</h3>
                                <section>
                                    <p>Please select the suppliers you would like to quote for this project.</p>

                                    <div class="clearfix">
                                        @foreach( $suppliers as $supplier )
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                @macro('checkbox', 'supplier[]', $supplier->name, false, $supplier->id)
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-12"><a href="#" id="other-suppliers-link">Show all</a></div>
                                    <div id="other-suppliers" class="hidden clearfix">
                                        @foreach( $other_suppliers as $supplier )
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                @macro('checkbox', 'supplier[]', $supplier->name, false, $supplier->id)
                                            </div>
                                        @endforeach
                                    </div>

                                </section>

                                <h3>Message</h3>
                                <section>
                                    <div class="form-group clearfix">
                                        <label class="col-lg-2 control-label " for="userName1">Message</label>
                                        <div class="col-lg-10">
                                            {!! Form::textarea('message', '', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </section>


                                <h3>Finish</h3>
                                <section>
                                    <div class="form-group clearfix">
                                        <div class="col-lg-12" id="summary">
                                            <p>To send your quote request click <strong>finish</strong> below.</p>
                                        </div>
                                    </div>
                                </section>
                            {!! Form::close() !!}
                            <!-- End #wizard-vertical -->
                        </div>
                    </div>
                </div><!-- End row -->
            </div>
        </div> <!-- end col -->
    </div>

@endsection

@section('script')
    $('#other-suppliers').hide().removeClass('hidden');
    $('#request-wizard').on('click', '#other-suppliers-link', function() {
        $('#other-suppliers').toggle();
    });
@endsection