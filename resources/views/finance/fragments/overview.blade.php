<h4 class="page-title m-b-20">Financial Statistics</h4>


<div class="row">

    <div class="col-lg-12">
        <div class="card-box">

            @include('finance.fragments.overview.form')
            @include('finance.fragments.overview.calculations')
            @include('finance.fragments.overview.chart')
            @include('finance.fragments.overview.table')
            {{-- @include('finance.fragments.overview.months_compare') --}}

        </div>
    </div>
</div>
