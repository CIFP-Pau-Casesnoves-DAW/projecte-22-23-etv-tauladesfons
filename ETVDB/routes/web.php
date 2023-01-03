<?php

use App\Http\Controllers\IdiomaController;
use Illuminate\Support\Facades\Route;

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
Route::get('/idiomes', function () {
    $idiomes = DB::table('IDIOMES')->get();
    return view('idiomes', compact('idiomes'));

});
Route::get('/idiomes/{id}', function ($id) {
$idiomes = DB::table('IDIOMES')->where('ID_IDIOMA', $id)->get();
return view('idiomes', compact('idiomes'));
});
