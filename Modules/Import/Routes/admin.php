<?php

use Illuminate\Support\Facades\Route;

Route::get('importer', [
    'as' => 'admin.importer.index',
    'uses' => 'ImporterController@index',
    'middleware' => 'can:admin.importer.index',
]);

Route::post('importer', [
    'as' => 'admin.importer.store',
    'uses' => 'ImporterController@store',
    'middleware' => 'can:admin.importer.create',
]);

Route::post('download-csv-template', [
    'as' => 'admin.download_csv_template.download',
    'uses' => 'DownloadCsvTemplateController@download',
    'middleware' => 'can:admin.importer.index',
]);
