<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProxessController;
use \App\Http\Controllers\MarquardtMetaApi\ChancenController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



//Route::resource( '/', ProxessController::class);
Route::group(['middleware' => 'msgraph', 'prefix' => 'proxess/v1','name' => 'proxess.'], function () {
    Route::get('/', [ProxessController::class, 'index'])->name('getDocumentList');
    Route::get('/databases', [ProxessController::class, 'databases'])->name('getDatabases');
    Route::get('/get', [ProxessController::class, 'show'])->name('getDocumentFile');
    Route::get('/download', [ProxessController::class, 'download'])->name('downloadDocumentFile');
    Route::post('/', [ProxessController::class, 'store'])->name('saveFile');
    Route::patch('/', [ProxessController::class, 'update'])->name('updateFile');
    Route::delete('/', [ProxessController::class, 'destroy'])->name('deleteDocument');

    Route::get('/types', [ProxessController::class, 'doctypes'])->name('getDocumentTypes');
    Route::get('/search', [ProxessController::class, 'search'])->name('searchDocuments');
});

Route::group(['middleware' => 'msgraph', 'prefix' => 'mma/v1','name' => 'mma.'], function () {
    Route::get('stammdaten/chance/aufmerksamkeit', [ChancenController::class, 'getAufmerksamkeit'])->name('getMMAAufmerksamkeitFormRequest');
    Route::get('stammdaten/chance/getHerkunft', [ChancenController::class, 'getHerkunft'])->name('getMMAAufmerksamkeitFormRequest');

});
/*
Route::get('getDocumentFile',[ProxessController::class,'show'])->name('getDocumentFile');
Route::post('saveFile',[ProxessController::class,'save'])->name('saveFile');
Route::put('updateFile',[ProxessController::class,'update'])->name('updateFile');
Route::delete('deleteDocument',[ProxessController::class,'destroy'])->name('deleteDocument');
*/

