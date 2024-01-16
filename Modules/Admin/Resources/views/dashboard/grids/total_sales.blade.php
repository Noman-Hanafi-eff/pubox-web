<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="single-grid total-sales">
        <i class="fa fa-money" aria-hidden="true"></i>

        <span class="title">{{ trans('admin::dashboard.total_sales') }}</span>
        
        <span class="count">{{ $totalSales->format() }}</span>
    </div>
</div>
