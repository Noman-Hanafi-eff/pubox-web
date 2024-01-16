@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('product::products.product')]))
    @slot('subtitle', $product->name)

    <li><a href="{{ route('admin.products.index') }}">{{ trans('product::products.products') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('product::products.product')]) }}</li>
@endcomponent

@section('content')
    <div id="app" v-cloak>
        <form
            class="product-form form-horizontal"
            @input="errors.clear($event.target.name)"
            @submit.prevent
            ref="form"
        >
            <div class="row">
                <div class="product-form-left-column col-lg-8 col-md-12">
                    @include('product::admin.products.layouts.left_column')
                </div>

                <div class="product-form-right-column col-lg-4 col-md-12">
                    @include('product::admin.products.layouts.right_column')
                </div>
            </div>

            <div class="product-form-footer">
                <button
                    type="button"
                    class="btn btn-default"
                    :class="{ 'btn-loading': formSubmissionType === 'save' }"
                    :disabled="formSubmissionType === 'save'"
                    @click="submit({ submissionType: 'save' })"
                >
                    {{ trans('product::products.save') }}
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    :class="{ 'btn-loading': formSubmissionType === 'save_and_exit' }"
                    :disabled="formSubmissionType === 'save_and_exit'"
                    @click="submit({ submissionType: 'save_and_exit' })"
                >
                    {{ trans('product::products.save_and_exit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@include('product::admin.products.partials.shortcuts')

@if (session()->has('exit_flash'))
    @push('notifications')
        <div class="alert alert-success alert-exit-flash fade in alert-dismissible clearfix">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            <span class="alert-text">{{ session('exit_flash') }}</span>
        </div>
    @endpush
@endif

@push('globals')
    <script>
        FleetCart.data['product'] = {!! $product_resource !!};
        FleetCart.data['attribute-sets'] = @json($attributeSets);
        FleetCart.langs['product::products.section.order_saved'] = '{{ trans('product::products.section.order_saved') }}';
        FleetCart.langs['product::products.variants.variants'] = '{{ trans('product::products.variants.variants') }}';
        FleetCart.langs['product::products.variants.variant'] = '{{ trans('product::products.variants.variant') }}';
        FleetCart.langs['product::products.variants.bulk_variants_updated'] = '{{ trans('product::products.variants.bulk_variants_updated') }}';
        FleetCart.langs['product::products.variants.variants_created'] = '{{ trans('product::products.variants.variants_created') }}';
        FleetCart.langs['product::products.variants.variants_removed'] = '{{ trans('product::products.variants.variants_removed') }}';
        FleetCart.langs['product::products.variants.variants_reordered'] = '{{ trans('product::products.variants.variants_reordered') }}';
        FleetCart.langs['product::products.variants.disable_default_variant'] = '{{ trans('product::products.variants.disable_default_variant') }}';
        FleetCart.langs['product::products.options.option_inserted'] = '{{ trans('product::products.options.option_inserted') }}';
    </script>

    @vite([
        'Modules/Product/Resources/assets/admin/sass/main.scss',
        'Modules/Product/Resources/assets/admin/js/edit.js',
        'Modules/Attribute/Resources/assets/admin/sass/main.scss',
        'Modules/Variation/Resources/assets/admin/sass/main.scss',
        'Modules/Option/Resources/assets/admin/sass/main.scss',
        'Modules/Media/Resources/assets/admin/sass/main.scss',
        'Modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
