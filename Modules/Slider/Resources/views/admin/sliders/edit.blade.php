@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('slider::sliders.slider')]))
    @slot('subtitle', $slider->name)

    <li><a href="{{ route('admin.sliders.index') }}">{{ trans('slider::sliders.sliders') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('slider::sliders.slider')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" class="form-horizontal" id="slider-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('slider')) !!}
    </form>
@endsection

@include('slider::admin.sliders.partials.shortcuts')

@push('globals')
    @vite([
        'Modules/Slider/Resources/assets/admin/sass/main.scss',
        'Modules/Slider/Resources/assets/admin/js/main.js',
        'Modules/Media/Resources/assets/admin/sass/main.scss',
        'Modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush