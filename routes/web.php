<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/public/storage/{id}/{fileName}', function ($id, $fileName) {
     $image=public_path('storage/'.$id.'/'.$fileName);  
    return Response::download($image); 
})->name('dashboard.email.edit');