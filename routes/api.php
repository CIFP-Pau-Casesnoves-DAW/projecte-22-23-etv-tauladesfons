<?php

use App\Http\Controllers\Allotjament_serveiController;
use App\Http\Controllers\AllotjamentController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MunicipiController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ServeiController;
use App\Http\Controllers\TipusController;
use App\Http\Controllers\Traduccio_serveiController;
use App\Http\Controllers\Traduccio_tipusController;
use App\Http\Controllers\Traduccio_vacancesController;
use App\Http\Controllers\UsuariController;
use App\Http\Controllers\VacancesController;
use App\Http\Controllers\ValoracioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    //ruta de idiomes
    Route::group(['prefix' => 'idiomes'], function () {
    Route::get('/', [IdiomaController::class, 'index']);
    Route::get('/{id}', [IdiomaController::class, 'show']);
    Route::post('', [IdiomaController::class, 'store']);
    Route::put('/put/{id}', [IdiomaController::class, 'update']);
    Route::delete('/destroy/{id}', [IdiomaController::class, 'destroy']);
    });
    //ruta de tipus
    Route::group(['prefix' => 'tipus'], function () {
    Route::get('/', [TipusController::class, 'index']);
    Route::get('/{id}', [TipusController::class, 'show']);
    Route::post('', [TipusController::class, 'store']);
    Route::put('/put/{id}', [TipusController::class, 'update']);
    Route::delete('/destroy/{id}', [TipusController::class, 'destroy']);
    });
    //ruta de municipis
    Route::group(['prefix' => 'municipis'], function () {
    Route::get('/', [MunicipiController::class, 'index']);
    Route::get('/{id}', [MunicipiController::class, 'show']);
    Route::post('', [MunicipiController::class, 'store']);
    Route::put('/put/{id}', [MunicipiController::class, 'update']);
    Route::delete('/destroy/{id}', [MunicipiController::class, 'destroy']);
    });
    //ruta de allotjaments
    Route::group(['prefix' => 'allotjaments'], function () {
    Route::get('/', [AllotjamentController::class, 'index']);
    Route::get('/{id}', [AllotjamentController::class, 'show']);
    Route::post('', [AllotjamentController::class, 'store']);
    Route::put('/put/{id}', [AllotjamentController::class, 'update']);
    Route::delete('/destroy/{id}', [AllotjamentController::class, 'destroy']);
    });
    //ruta de allotjament servei
    Route::group(['prefix' => 'allotjaments_serveis'], function () {
    Route::get('/', [Allotjament_serveiController::class, 'index']);
    Route::get('/{id}', [Allotjament_serveiController::class, 'show']);
    Route::post('', [Allotjament_serveiController::class, 'store']);
    Route::put('/put/{id}', [Allotjament_serveiController::class, 'update']);
    Route::delete('/destroy/{id}', [Allotjament_serveiController::class, 'destroy']);
    });
    //ruta de categories
    Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriaController::class, 'index']);
    Route::get('/{id}', [CategoriaController::class, 'show']);
    Route::post('', [CategoriaController::class, 'store']);
    Route::put('/put/{id}', [CategoriaController::class, 'update']);
    Route::delete('/destroy/{id}', [CategoriaController::class, 'destroy']);
    });
    //ruta de comentaris
    Route::group(['prefix' => 'comentaris'], function () {
    Route::get('/', [ComentariController::class, 'index']);
    Route::get('/{id}', [ComentariController::class, 'show']);
    Route::post('', [ComentariController::class, 'store']);
    Route::put('/put/{id}', [ComentariController::class, 'update']);
    Route::delete('/destroy/{id}', [ComentariController::class, 'destroy']);
    });
    //ruta de reserves
    Route::group(['prefix' => 'reserves'], function () {
    Route::get('/', [ReservaController::class, 'index']);
    Route::get('/{id}', [ReservaController::class, 'show']);
    Route::post('', [ReservaController::class, 'store']);
    Route::put('/put/{id}', [ReservaController::class, 'update']);
    Route::delete('/destroy/{id}', [ReservaController::class, 'destroy']);
    });
    //ruta de serveis
    Route::group(['prefix' => 'serveis'], function () {
    Route::get('/', [ServeiController::class, 'index']);
    Route::get('/{id}', [ServeiController::class, 'show']);
    Route::post('', [ServeiController::class, 'store']);
    Route::put('/put/{id}', [ServeiController::class, 'update']);
    Route::delete('/destroy/{id}', [ServeiController::class, 'destroy']);
    });
    //ruta de traduccions_serveis
    Route::group(['prefix' => 'traduccions_serveis'], function () {
    Route::get('/', [Traduccio_serveiController::class, 'index']);
    Route::get('/{id}', [Traduccio_serveiController::class, 'show']);
    Route::post('', [Traduccio_serveiController::class, 'store']);
    Route::put('/put/{id}', [Traduccio_serveiController::class, 'update']);
    Route::delete('/destroy/{id}', [Traduccio_serveiController::class, 'destroy']);
    });
    //ruta de traduccions_tipus
    Route::group(['prefix' => 'traduccions_tipus'], function () {
    Route::get('/', [Traduccio_tipusController::class, 'index']);
    Route::get('/{id}', [Traduccio_tipusController::class, 'show']);
    Route::post('', [Traduccio_tipusController::class, 'store']);
    Route::put('/put/{id}', [Traduccio_tipusController::class, 'update']);
    Route::delete('/destroy/{id}', [Traduccio_tipusController::class, 'destroy']);
    });
    //ruta de traduccions_vacances
    Route::group(['prefix' => 'traduccions_vacances'], function () {
    Route::get('/', [Traduccio_vacancesController::class, 'index']);
    Route::get('/{id}', [Traduccio_vacancesController::class, 'show']);
    Route::post('', [Traduccio_vacancesController::class, 'store']);
    Route::put('/put/{id}', [Traduccio_vacancesController::class, 'update']);
    Route::delete('/destroy/{id}', [Traduccio_vacancesController::class, 'destroy']);
    });
    //ruta de usuaris
    Route::group(['prefix' => 'usuaris'], function () {
    Route::get('/', [UsuariController::class, 'index']);
    Route::get('/{id}', [UsuariController::class, 'show']);
    Route::post('', [UsuariController::class, 'store']);
    Route::put('/put/{id}', [UsuariController::class, 'update']);
    Route::delete('/destroy/{id}', [UsuariController::class, 'destroy']);
    });
    //ruta de vacances
    Route::group(['prefix' => 'vacances'], function () {
    Route::get('/', [VacancesController::class, 'index']);
    Route::get('/{id}', [VacancesController::class, 'show']);
    Route::post('', [VacancesController::class, 'store']);
    Route::put('/put/{id}', [VacancesController::class, 'update']);
    Route::delete('/destroy/{id}', [VacancesController::class, 'destroy']);
    });
    //ruta de valoracions
    Route::group(['prefix' => 'valoracions'], function () {
    Route::get('/', [ValoracioController::class, 'index']);
    Route::get('/{id}', [ValoracioController::class, 'show']);
    Route::post('', [ValoracioController::class, 'store']);
    Route::put('/put/{id}', [ValoracioController::class, 'update']);
    Route::delete('/destroy/{id}', [ValoracioController::class, 'destroy']);
    });
    //ruta de login
    Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::post('', [LoginController::class, 'login']);
    });


