<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProxessController;
use \App\Http\Controllers\EmailController;
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
Route::group(['middleware' => 'msgraph', 'prefix' => 'mma/v1/documents', 'name' => 'proxess.'], function () {
    Route::get('/', [ProxessController::class, 'index'])->name('getDocumentList');
    Route::get('/databases', [ProxessController::class, 'databases'])->name('getDatabases');
    Route::get('/get', [ProxessController::class, 'show'])->name('getDocumentFile');
    Route::get('/download', [ProxessController::class, 'download'])->name('downloadDocumentFile');
    Route::post('/', [ProxessController::class, 'store'])->name('saveFile');
    Route::patch('/', [ProxessController::class, 'update'])->name('updateFile');
    Route::delete('/', [ProxessController::class, 'destroy'])->name('deleteDocument');

    Route::get('/types', [ProxessController::class, 'doctypes'])->name('getDocumentTypes');
    Route::get('/search', [ProxessController::class, 'search'])->name('searchDocuments');

    Route::group(['prefix' => 'email', 'name' => 'email.'], function () {
        Route::post('/', [EmailController::class, 'newMail'])->name('newMail');
    });
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'mma/v1', 'name' => 'mma.'], function () {
    Route::get('stammdaten/chance/aufmerksamkeit', [ChancenController::class, 'getAufmerksamkeit'])->name('getMMAAufmerksamkeitFormRequest');
    Route::get('stammdaten/chance/herkunft', [ChancenController::class, 'getHerkunft'])->name('getMMAAufmerksamkeitFormRequest');
    Route::get('stammdaten/chance/kaufabsicht', [ChancenController::class, 'getKaufabsicht'])->name('getMMAAufmerksamkeitFormRequest');
    Route::get('stammdaten/chance/status', [ChancenController::class, 'getStatus'])->name('getMMAAufmerksamkeitFormRequest');
    Route::get('stammdaten/chance/wahrscheinlichkeit', [ChancenController::class, 'getWahrscheinlichkeit'])->name('getMMAAufmerksamkeitFormRequest');

    Route::group(['prefix' => 'kunden', 'name' => 'kunden.'], function () {
        Route::get('/', [\App\Http\Controllers\MarquardtMetaApi\KundenController::class, 'getKunden'])->name('getKunden');
    });

    Route::group(['prefix' => 'keys', 'name' => 'key.'], function () {
        Route::get('attention', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getAttentionKeys'])->name('getAttentionKeys');
        Route::get('country', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getCountryKeys'])->name('getCountryKeys');
        Route::get('serviceError', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getServiceErrorKeys'])->name('getServiceErrorKeys');
        Route::get('serviceNote', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getServiceNoteKeys'])->name('getServiceNoteKeys');
        Route::get('employee', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getEmployeeKeys'])->name('getEmployeeKeys');
        Route::get('employeeType', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getEmployeeTypeKeys'])->name('getEmployeeTypeKeys');
        Route::get('leadOrigin', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getLeadOriginKeys'])->name('getLeadOriginKeys');
        Route::get('outlet', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getOutletKeys'])->name('getOutletKeys');
        Route::get('paymentTerm', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getPaymentTermKeys'])->name('getPaymentTermKeys');
        Route::get('probability', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getProbabilityKeys'])->name('getProbabilityKeys');
        Route::get('salutation', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getSalutationKeys'])->name('getSalutationKeys');
        Route::get('salutationTitle', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getSalutationTitleKeys'])->name('getSalutationTitleKeys');
        Route::get('federalState', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getFederalStateKeys'])->name('getFederalStateKeys');
        Route::get('leadStatus', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getLeadStatusKeys'])->name('getLeadStatusKeys');
        Route::get('intentToPurchase', [\App\Http\Controllers\MarquardtMetaApi\KeyController::class, 'getIntentToPurchaseKeys'])->name('getIntentToPurchaseKeys');
    });


});

Route::get('/clear-cache', function () {
    // TODO: protect via backend
    Artisan::call('cache:clear');
    return "Cache is cleared";
})->name('cache.clear');
/*
Route::get('getDocumentFile',[ProxessController::class,'show'])->name('getDocumentFile');
Route::post('saveFile',[ProxessController::class,'save'])->name('saveFile');
Route::put('updateFile',[ProxessController::class,'update'])->name('updateFile');
Route::delete('deleteDocument',[ProxessController::class,'destroy'])->name('deleteDocument');
*/

