<div class="row bottom-space-20">
    <div class="col-md-6 pull-right text-right">
        <form class="form-inline" action="" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="start_date" value="{{$start_date->format('Y-m')}}" />
                <input type="hidden" name="end_date" value="{{$end_date->format('Y-m')}}" />
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">From</span>
                        {!! Form::select('start_date', $date_options, $start_date->format('Y-m'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">To</span>
                        {!! Form::select('end_date', $date_options, $end_date->format('Y-m'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <button class="btn btn-default">Recalculate <i class="fa fa-calculator"></i></button>
            </td>
        </form>
    </div>
</div>
