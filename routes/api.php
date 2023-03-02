<?php

use App\Http\Controllers\Allotjament_serveiController;
use App\Http\Controllers\AllotjamentController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\FotografiaController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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

//  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
//  });
// ruta de idiomes
Route::group(['prefix' => 'idiomes'], function () {
    Route::get('/', [IdiomaController::class, 'getAllIdiomes']);
    Route::get('/{id}', [IdiomaController::class, 'getIdioma']);
    Route::post('', [IdiomaController::class, 'insertIdioma'])->middleware("token");
    Route::put('/put/{id}', [IdiomaController::class, 'updateIdioma'])->middleware("token");
    Route::delete('/destroy/{id}', [IdiomaController::class, 'deleteIdioma'])->middleware("token");
});
// !ruta de tipus
Route::group(['prefix' => 'tipus'], function () {
    Route::get('/', [TipusController::class, 'getAllTipus']);
    Route::get('/{id}', [TipusController::class, 'getTipus']);
    Route::post('', [TipusController::class, 'insertTipus'])->middleware("token");
    Route::put('/put/{id}', [TipusController::class, 'updateTipus'])->middleware("token");
    Route::delete('/destroy/{id}', [TipusController::class, 'deleteTipus'])->middleware("token");
});
// ! ruta de municipis
Route::group(['prefix' => 'municipis'], function () {
    Route::get('/', [MunicipiController::class, 'getAllMunicipis']);
    Route::get('/{id}', [MunicipiController::class, 'getMunicipi']);
    Route::post('', [MunicipiController::class, 'insertMunicipi'])->middleware("token");
    Route::put('/put/{id}', [MunicipiController::class, 'updateMunicipi'])->middleware("token");
    Route::delete('/destroy/{id}', [MunicipiController::class, 'deleteMunicipi'])->middleware("token");
});
// !ruta de allotjaments
Route::group(['prefix' => 'allotjaments'], function () {
    Route::get('/', [AllotjamentController::class, 'getAllAllotjaments']);
    Route::get('/{id}', [AllotjamentController::class, 'getAllotjament']);
    Route::post('', [AllotjamentController::class, 'insertAllotjament'])->middleware("token");
    Route::put('/put/{id}', [AllotjamentController::class, 'updateAllotjament'])->middleware("token");
    Route::delete('/destroy/{id}', [AllotjamentController::class, 'deleteAllotjament'])->middleware("token");
});
// !ruta de allotjament_servei
Route::group(['prefix' => 'allotjaments_serveis'], function () {
    Route::get('/', [Allotjament_serveiController::class, 'getAllAllotjamentServei'])->middleware("token");
    Route::get('/{id_allot}/{id_servei}', [Allotjament_serveiController::class, 'getAllotjamentServei']);
    Route::post('', [Allotjament_serveiController::class, 'insertAllotjamentServei'])->middleware("token")->middleware("token");
    Route::put('/put/{id_allot}/{id_servei}', [Allotjament_serveiController::class, 'updateAllotjamentServei'])->middleware("token");
    Route::delete('/destroy/{id_allot}/{id_servei}', [Allotjament_serveiController::class, 'deleteAllotjamentServei'])->middleware("token");
});
// !ruta de categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriaController::class, 'getAllCategories']);
    Route::get('/{id}', [CategoriaController::class, 'getCategoria']);
    Route::post('', [CategoriaController::class, 'insertCategoria'])->middleware("token");
    Route::put('/put/{id}', [CategoriaController::class, 'updateCategoria'])->middleware("token");
    Route::delete('/destroy/{id}', [CategoriaController::class, 'deleteCategoria'])->middleware("token");
});
// !ruta de comentaris
Route::group(['prefix' => 'comentaris'], function () {
    Route::get('/', [ComentariController::class, 'getAllComentaris']);
    Route::get('/{id}', [ComentariController::class, 'getComentari']);
    Route::post('', [ComentariController::class, 'insertComentari'])->middleware("token");
    Route::put('/put/{id}', [ComentariController::class, 'updateComentari'])->middleware("token");
    Route::delete('/destroy/{id}', [ComentariController::class, 'deleteComentari'])->middleware("token");
});
// !ruta de reserves
Route::group(['prefix' => 'reserves'], function () {
    Route::get('/', [ReservaController::class, 'getAllReserves'])->middleware("token");
    Route::get('/{id}', [ReservaController::class, 'getReserva'])->middleware("token");
    Route::post('', [ReservaController::class, 'insertReserva'])->middleware("token");
    Route::put('/put/{id}', [ReservaController::class, 'updateReserva'])->middleware("token");
    Route::delete('/destroy/{id}', [ReservaController::class, 'deleteReserva'])->middleware("token");
});
// !ruta de serveis
Route::group(['prefix' => 'serveis'], function () {
    Route::get('/', [ServeiController::class, 'getAllServeis']);
    Route::get('/{id}', [ServeiController::class, 'getServei']);
    Route::post('', [ServeiController::class, 'insertServei'])->middleware("token");
    Route::put('/put/{id}', [ServeiController::class, 'updateServei'])->middleware("token");
    Route::delete('/destroy/{id}', [ServeiController::class, 'deleteServei'])->middleware("token");
});
// ! ? ruta de traduccions_serveis
Route::group(['prefix' => 'traduccio_serveis'], function () {
    Route::get('/', [Traduccio_serveiController::class, 'getAllTraduccionsServeis']);
    Route::get('/{id_servei}/{id_idioma}', [Traduccio_serveiController::class, 'getTraduccioServei']);
    Route::post('', [Traduccio_serveiController::class, 'insertTraduccioServei'])->middleware("token");
    Route::put('/put/{id_servei}/{id_idioma}', [Traduccio_serveiController::class, 'updateTraduccioServei'])->middleware("token");
    Route::delete('/destroy/{id_servei}/{id_idioma}', [Traduccio_serveiController::class, 'deleteTraduccioServei'])->middleware("token");
});
// !  ruta de traduccions_tipus
Route::group(['prefix' => 'traduccio_tipus'], function () {
    Route::get('/', [Traduccio_tipusController::class, 'getAllTraduccionsTipus']);
    Route::get('/{id_tipus}/{id_idioma}', [Traduccio_tipusController::class, 'getTraduccioTipus']);
    Route::post('', [Traduccio_tipusController::class, 'insertTraduccioTipus'])->middleware("token");
    Route::put('/put/{id_tipus}/{id_idioma}', [Traduccio_tipusController::class, 'updateTraduccioTipus'])->middleware("token");
    Route::delete('/destroy/{id_tipus}/{id_idioma}', [Traduccio_tipusController::class, 'deleteTraduccioTipus'])->middleware("token");
});
// ! ruta de traduccions_vacances
Route::group(['prefix' => 'traduccio_vacances'], function () {
    Route::get('/', [Traduccio_vacancesController::class, 'getAllTraduccionsVacances']);
    Route::get('/{id_vacances}/{id_idioma}', [Traduccio_vacancesController::class, 'getTraduccioVacances']);
    Route::post('', [Traduccio_vacancesController::class, 'insertTraduccioVacances'])->middleware("token");
    Route::put('/put/{id_vacances}/{id_idioma}', [Traduccio_vacancesController::class, 'updateTraduccioVacances'])->middleware("token");
    Route::delete('/destroy/{id_vacances}/{id_idioma}', [Traduccio_vacancesController::class, 'deleteTraduccioVacances'])->middleware("token");
});
// !ruta de usuaris
Route::group(['prefix' => 'usuaris'], function () {
    Route::get('/', [UsuariController::class, 'getAllUsuaris'])->middleware("token");
    Route::get('/{id}', [UsuariController::class, 'getUsuari'])->middleware("token");
    Route::post('', [UsuariController::class, 'insertUsuaris']);
    Route::put('/put/{id}', [UsuariController::class, 'updateUsuaris'])->middleware("token");
    Route::delete('/destroy/{id}', [UsuariController::class, 'deleteUsuari'])->middleware("token");
});
// !ruta de vacances
Route::group(['prefix' => 'vacances'], function () {
    Route::get('/', [VacancesController::class, 'getAllVacances']);
    Route::get('/{id}', [VacancesController::class, 'getVacances']);
    Route::post('', [VacancesController::class, 'insertVacances'])->middleware("token");
    Route::put('/put/{id}', [VacancesController::class, 'updateVacances'])->middleware("token");
    Route::delete('/destroy/{id}', [VacancesController::class, 'destroy'])->middleware("token");
});
// !ruta de valoracions
Route::group(['prefix' => 'valoracions'], function () {
    Route::get('/', [ValoracioController::class, 'getAllValoracions']);
    Route::get('/{id}', [ValoracioController::class, 'getValoracio']);
    Route::post('', [ValoracioController::class, 'insertValoracio'])->middleware("token");
    Route::put('/put/{id}', [ValoracioController::class, 'updateValoracio'])->middleware("token");
    Route::delete('/destroy/{id}', [ValoracioController::class, 'destroy'])->middleware("token");
});
// ! ruta de login
Route::group(['prefix' => 'login'], function () {
    Route::post('', [LoginController::class, 'login']);
});
// !ruta de fotografies
Route::group(['prefix' => 'fotografies'], function () {
    Route::get('/', [FotografiaController::class, 'getFotografies'])->middleware("token");
    Route::get('/{id}', [FotografiaController::class, 'getFotografia'])->middleware("token");
    Route::post('', [FotografiaController::class, 'insertFotografia'])->middleware("token");
    Route::put('/put/{id}', [FotografiaController::class, 'updateFotografia'])->middleware("token");
    Route::delete('/destroy/{id}', [FotografiaController::class, 'deleteFotografia'])->middleware("token");
});
// ! Ruta logout
Route::group(["prefix"=>"logout"], function() {
    Route::post('', [LogoutController::class, "logout"])->middleware("token");
});