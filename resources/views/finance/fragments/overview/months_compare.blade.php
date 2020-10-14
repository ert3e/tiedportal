
<table class="table financial-table  financial-table-reverse prospect-col">
    <tbody class="prospect-col">
        <tr>
            <th class="no-border big-th" rowspan="5">
                Pros
            </th>
            <th>
            </th>
            @foreach($per_month as $key => $month)
                <th>
                    {{ $key }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                No
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>{{$month['prospectsSum']['no']}}</strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Revenue
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['prospectsSum']['revenue']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['prospectsSum']['revenue_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>

            <th class="text-right">
                Profit
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['prospectsSum']['profit']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['prospectsSum']['profit_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Costs
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['prospectsSum']['cost']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['prospectsSum']['cost_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
    </tbody>

    <tbody class="active-col">
        <tr>
            <th class="no-border big-th" rowspan="5">
                Active
            </th>
            <th>
            </th>
            @foreach($per_month as $key => $month)
                <th>
                    {{ $key }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                No
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>{{$month['activeSum']['no']}}</strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Revenue
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['activeSum']['revenue']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['activeSum']['revenue_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>

            <th class="text-right">
                Profit
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['activeSum']['profit']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['activeSum']['profit_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Costs
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['activeSum']['cost']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['activeSum']['cost_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
    </tbody>

    <tbody class="lost-col">
        <tr>
            <th class="no-border big-th" rowspan="5">
                Lost
            </th>
            <th>
            </th>
            @foreach($per_month as $key => $month)
                <th>
                    {{ $key }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                No
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>{{$month['lostSum']['no']}}</strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Revenue
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['lostSum']['revenue']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['lostSum']['revenue_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>

            <th class="text-right">
                Profit
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['lostSum']['profit']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['lostSum']['profit_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Costs
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['lostSum']['cost']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['lostSum']['cost_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
    </tbody>
    <tbody class="complete-col">
        <tr>
            <th class="no-border big-th" rowspan="5">
                Compl
            </th>
            <th>
            </th>
            @foreach($per_month as $key => $month)
                <th>
                    {{ $key }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                No
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>{{$month['completedSum']['no']}}</strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Revenue
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['completedSum']['revenue']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['completedSum']['revenue_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>

            <th class="text-right">
                Profit
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['completedSum']['profit']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['completedSum']['profit_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
        <tr>
            <th class="text-right">
                Costs
            </th>
            @foreach($per_month as $key => $month)
                <td>
                    <strong>£{{$month['completedSum']['cost']}} <span class="gray">sum</span></strong><br>
                    <strong><small>£{{$month['completedSum']['cost_avg']}} <span class="gray">avg</span></small></strong>
                </td>
            @endforeach
        </tr>
    </tbody>
</table>
