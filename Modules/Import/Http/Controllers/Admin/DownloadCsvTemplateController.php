<?php

namespace Modules\Import\Http\Controllers\Admin;

use Illuminate\Http\Response;

class DownloadCsvTemplateController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function download()
    {
        $template_types = ['product' => 'products.csv'];

        if (array_key_exists(request('template_type'), $template_types)) {
            $path = storage_path('app/csv_templates/' . $template_types[request('template_type')]);

            return response()->download($path);
        }
    }
}
