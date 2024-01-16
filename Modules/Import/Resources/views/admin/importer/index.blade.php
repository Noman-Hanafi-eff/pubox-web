@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('import::importer.importer'))

    <li class="active">{{ trans('import::importer.importer') }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.download_csv_template.download') }}" enctype="multipart/form-data"
          class="form-horizontal">
        @csrf

        <div class="accordion-content">
            <div class="accordion-box-content clearfix">
                <div class="col-md-12">
                    <div class="accordion-box-content">
                        <div class="tab-content clearfix">
                            <div class="tab-pane fade in active">
                                <h4 class="tab-content-title">
                                    {{ trans('import::importer.download_csv_template') }}
                                </h4>

                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {{ Form::select('template_type', trans('import::attributes.template_type'), $errors, trans('import::importer.template_types'), null, ['required' => true]) }}

                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-md-10">
                                                <button type="submit" class="btn btn-primary" data-loading>
                                                    {{ trans('import::importer.download') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('admin.importer.store') }}" enctype="multipart/form-data"
          class="form-horizontal m-t-10">
        @csrf

        <div class="accordion-content">
            <div class="accordion-box-content clearfix">
                <div class="col-md-12">
                    <div class="accordion-box-content">
                        <div class="tab-content clearfix">
                            <div class="tab-pane fade in active">
                                <h4 class="tab-content-title">
                                    {{ trans('import::importer.import') }}
                                </h4>

                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        {{ Form::file('csv_file', trans('import::attributes.csv_file'), $errors, null, ['required' => true]) }}
                                        {{ Form::select('import_type', trans('import::attributes.import_type'), $errors, trans('import::importer.import_types'), null, ['required' => true]) }}

                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-md-10">
                                                <button type="submit" class="btn btn-primary" data-loading>
                                                    {{ trans('import::importer.run') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
