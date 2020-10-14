<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-star-o text-primary"></i> --}}
            <h2 class="m-0  counter font-600">{{ number_format($prospects, 0) }}</h2>
            <div class="text-muted m-t-5">Prospects</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-file-code-o text-pink"></i> --}}
            <h2 class="m-0  counter font-600">{{ number_format($converted, 0) }}</h2>
            <div class="text-muted m-t-5">Converted</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-file-code-o text-pink"></i> --}}
            <h2 class="m-0  counter font-600">{{ number_format($converted/($converted+$prospects)*100, 0) }}%</h2>
            <div class="text-muted m-t-5">Convertion rate</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-gbp text-info"></i> --}}
            <h2 class="m-0  counter font-600">&pound;{{ number_format($revenue, 0) }}</h2>
            <div class="text-muted m-t-5">Revenue</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-gbp text-success"></i> --}}
            <h2 class="m-0  counter font-600">&pound;{{ number_format($profit, 0) }}</h2>
            <div class="text-muted m-t-5">Profit</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 left-padding-20  right-padding-20">
        <div class="widget-panel financial-box">
            {{-- <i class="fa fa-calendar text-success"></i> --}}
            <h2 class="m-0  counter font-600">{{ number_format($average_conversion_time, 0) }}</h2>
            <div class="text-muted m-t-5">Avg conversion time (days)</div>
        </div>
    </div>
    {{-- <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="widget-panel financial-box">
            <h2 class="m-0  counter font-600">&pound;{{ number_format($average_value, 2) }}</h2>
            <div class="text-muted m-t-5">Average sale value</div>
        </div>
    </div> --}}
</div>

{{-- {{ dump($per_month) }} --}}

{{-- <div class="row">
    <div class="col-lg-6 col-sm-6 text-center">
        <h4>Five ways</h4>
        <strong>{{ number_format($prospects, 0) }}</strong> leads<br/>
        X<br/>
        Conversion rate of <strong>{{ number_format($conversion_rate, 2) }}%</strong><br/>
        =<br/>
        <strong>{{ number_format($number_of_customers, 0) }}</strong> customers<br/>
        X<br/>
        <strong>{{ number_format($number_of_customers, 0) }}</strong> transactions<br/>
        X<br/>
        <strong>&pound;{{ number_format($average_value, 2) }}</strong> average value<br/>
        =<br/>
        <strong>&pound;{{ number_format($turnover, 0) }}</strong> turnover<br/>
        X<br/>
        <strong>{{ number_format($profit_margin, 2) }}</strong> profit margin<br/>
        =<br/>
        <strong>&pound;{{ number_format($profit, 2) }}</strong> profit<br/>
    </div>
</div> --}}
