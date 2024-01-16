<?php

use Illuminate\Support\Facades\Route;


Route::get('install', 'InstallController@installation')->name('install.show');
Route::post('install', 'InstallController@install')->name('install.post');

Route::get('license', 'LicenseController@create')->name('license.create');
Route::post('license', 'LicenseController@store')->name('license.store');
