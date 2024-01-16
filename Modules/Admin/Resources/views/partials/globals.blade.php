<script>
    window.FleetCart = {
        version: '{{ fleetcart_version() }}',
        csrfToken: '{{ csrf_token() }}',
        baseUrl: '{{ url('/') }}',
        rtl: {{ is_rtl() ? 'true' : 'false' }},
        langs: {},
        data: {},
        errors: {},
        selectize: [],
        defaultCurrencySymbol: '{{ currency_symbol(setting("default_currency")) }}'
    };

    FleetCart.langs['admin::admin.buttons.delete'] = '{{ trans('admin::admin.buttons.delete') }}';
    FleetCart.langs['media::media.file_manager.title'] = '{{ trans('media::media.file_manager.title') }}';
</script>

@stack('globals')

@routes
