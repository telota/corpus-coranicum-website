<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Commentary;
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

Route::view('/', 'list_api');

Route::get('/sleep', function (){
  sleep(4);
  return response()->json(['success' => 'success'], 200);
});
