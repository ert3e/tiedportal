

{{-- <table class="table financial-table">
    <form class="" action="" method="post">
    <tr>
        <th colspan="2" rowspan="2" class="text-right no-border">
            {!! csrf_field() !!}
            <input type="hidden" name="start_date" value="{{$start_date->format('Y-m')}}" />
            <input type="hidden" name="end_date" value="{{$end_date->format('Y-m')}}" />
            <button class="btn btn-default">Recalculate <i class="fa fa-calculator"></i></button>
        </th>
        <td colspan="2" class="no-border" style="padding-left: 0">
            <div class="input-group n">
                <span class="input-group-addon" id="basic-addon2">From</span>
                {!! Form::select('start_date', $date_options, $start_date->format('Y-m'), ['class' => 'form-control']) !!}
            </div>
        </td>
        <td class="no-border" colspan="2" style="padding-right: 0">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon2">To</span>
                {!! Form::select('end_date', $date_options, $end_date->format('Y-m'), ['class' => 'form-control']) !!}
            </div>
        </td>
    </tr>
    <tr>
        <td class="prospect-col">
            <input type="hidden" name="check_prospects" value="0" />
            <input type="checkbox" @if(old('check_prospects', isset($check_prospects) && $check_prospects)) checked="checked" @endif  name="check_prospects" value="1" title="Select to include prospects on chart and calculations below" />
        </td>
        <td class="active-col">
            <input type="hidden" name="check_active" value="0" />
            <input type="checkbox" @if(old('check_prospects', isset($check_active) && $check_active)) checked="checked" @endif  name="check_active" value="1" title="Select to include active on chart and calculations below" />
        </td>
        <td class="lost-col">
            <input type="hidden" name="check_lost" value="0" />
            <input type="checkbox" @if(old('check_lost', isset($check_lost) && $check_lost)) checked="checked" @endif  name="check_lost" value="1" title="Select to include lost on chart and calculations below" />
        </td>
        <td class="complete-col">
            <input type="hidden" name="check_complete" value="0" />
            <input type="checkbox" @if(old('check_complete', isset($check_complete) && $check_complete)) checked="checked" @endif  name="check_complete" value="1" title="Select to include complete on chart and calculations below" />
        </td>
    </tr>
    </form>
</table> --}}



<table class="table financial-table">
    <colgroup>
        <col />
        <col />
        <col  class="prospect-col"/>
        <col  class="active-col"/>
        <col  class="lost-col"/>
        <col  class="complete-col"/>
    </colgroup>
    <tr>
        <th class="no-border">
        </th>
        <th>
        </th>
        <th>
            Prospects
        </th>
        <th>
            Active
        </th>
        <th>
            Lost
        </th>
        <th>
            Complete
        </th>
    </tr>
    <tr>
        <th class="no-border big-th" rowspan="4">
            Sum
        </th>
        <th class="text-right">
            No
        </th>
        <td>
            <strong>{{$prospectsSum['no']}}</strong>
        </td>
        <td>
            <strong>{{$activeSum['no']}}</strong>
        </td>
        <td>
            <strong>{{$lostSum['no']}}</strong>
        </td>
        <td>
            <strong>{{$completedSum['no']}}</strong>
        </td>
    </tr>
    <tr>

        <th class="text-right">
            Revenue
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['revenue']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['revenue']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['revenue']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['revenue']}}</strong>
        </td>
    </tr>
    <tr>

        <th class="text-right">
            Profit
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['profit']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['profit']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['profit']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['profit']}}</strong>
        </td>
    </tr>
    <tr>
        <th class="text-right">
            Costs
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['cost']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['cost']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['cost']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['cost']}}</strong>
        </td>
    </tr>

    <tr>
        <td colspan="6" class="no-border">

        </td>
    </tr>
    <tr>
        <th class="no-border big-th" rowspan="3">
            Avg
        </th>

        <th class="text-right">
            Revenue
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['revenue_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['revenue_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['revenue_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['revenue_avg']}}</strong>
        </td>
    </tr>

    <tr>

        <th class="text-right">
            Profit
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['profit_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['profit_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['profit_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['profit_avg']}}</strong>
        </td>
    </tr>
    <tr>
        <th class="text-right">
            Costs
        </th>
        <td>
            <strong>&pound;{{$prospectsSum['cost_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$activeSum['cost_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$lostSum['cost_avg']}}</strong>
        </td>
        <td>
            <strong>&pound;{{$completedSum['cost_avg']}}</strong>
        </td>
    </tr>
</table>
