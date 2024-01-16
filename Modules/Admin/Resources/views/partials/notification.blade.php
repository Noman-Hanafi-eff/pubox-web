@if (session()->has('success'))
    <div class="alert alert-success fade in alert-dismissible clearfix">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        <span class="alert-text">{{ session('success') }}</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger fade in alert-dismissible clearfix">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        <span class="alert-text">{{ session('error') }}</span>
    </div>
@endif


@stack('notifications')
