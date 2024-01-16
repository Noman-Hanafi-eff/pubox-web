@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('product::products.products'))

    <li class="active">{{ trans('product::products.products') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'products')
    @slot('name', trans('product::products.product'))

    @slot('thead')
        @include('product::admin.products.partials.thead', ['name' => 'products-index'])
    @endslot
@endcomponent

@if (session()->has('exit_flash'))
    @push('notifications')
        <div class="alert alert-success fade in alert-dismissible clearfix">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            <span class="alert-text">{{ session('exit_flash') }}</span>
        </div>
    @endpush
@endif

@push('scripts')
    <script type="module">
        new DataTable('#products-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'id', width: '5%' },
                { data: 'thumbnail', orderable: false, searchable: false, width: '10%' },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'price', searchable: false },
                { data: 'status', name: 'is_active', searchable: false },
                { data: 'updated', name: 'updated_at' },
            ],
        });
    </script>
@endpush
