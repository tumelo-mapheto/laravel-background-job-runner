<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-background-job', function () {
    // Run SampleJob in the background with a message parameter
    runBackgroundJob('App\\Jobs\\SampleJob', 'execute', ['This is a test message']);
    return 'Background job has been triggered. Check the logs.';
});
