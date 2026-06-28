<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PfcController;
use App\Http\Controllers\Office\DscController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Worker\eShramController;
use App\Http\Controllers\Worker\MasterWorkerController;
use App\Services\Cipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\AsdmController;

/*
|--------------------------------------------------------------------------s
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
Route::middleware(['auth:sanctum', 'throttle:30,1'])
    ->post('/verify-id-card', [VerificationController::class, 'verify']);

// Route::post('submit-pfc-status',[PfcController::class,'submitApplicationStatus']);

Route::post('transaction-status',[PaymentController::class,'egrassDecrypt']);
Route::post('sewasetu/track-application-status',[PfcController::class,'trackApplication']);

Route::post('sewasetu/encrypt',[PfcController::class,'encryptDataforTest']);
Route::post('sewasetu/decryptTest',[PfcController::class,'decryptTest']);
Route::post('csc/decryptTest',[BridgePG::class,'decryptTestCsc']);

Route::post('test-encrypt',[PfcController::class,'testEncrypt']);
Route::post('test-url', [Cipher::class, 'decrypt']);
Route::get('decrypt-token',[SecurityController::class,'testDecrypt']);

Route::get('remove-vault-data',[ApiController::class,'removeVault']);

Route::post('update-phone-number',[ApiController::class,'updatePhone']);

Route::post('search-phone-by-ack',[ApiController::class,'SearchPhone']);

Route::get('update-reject-data',[ApiController::class,'updateRejectData']);

Route::post('decrypt-data',[PfcController::class,'postSubmissionDec']);

Route::post('update-ifsc-code-temp',[ApiController::class,'updateIfscCodeTemp']);

Route::post('update-ifsc-code-main',[ApiController::class,'updateIfscCodeMain']);

 Route::get('get-application-status',[ApiController::class,'getApplicationCount']);

// Route::post('update-vault-data',[ApiController::class,'UpdateVaultData']);

// Route::post('update-vault-data-main',[ApiController::class,'UpdateVaultDataMain']);

//Route::post('office/dsc/signed-id',[DscController::class,'TestId']);

Route::post('encrypt-data-vault',[ApiController::class,'encryptDataVault']);
Route::post('decrypt-data-vault',[ApiController::class,'decryptDataVault']);
Route::post('/update-already-reg', [ApiController::class, 'updateAlreadyReg']);
Route::post('update-office-id', [ApiController::class, 'updateOfficeId']);
Route::post('/update-user-ids', [ApiController::class, 'updateReceiverUserIds']);
Route::post('/update-user-id', [ApiController::class, 'updateUserIds']);


Route::get('vault-data-decrypt/{limit}/{offset}',[ApiController::class,'vaultDecrypt']);
Route::middleware(['verify.asdm.key'])->group(function () {
    Route::post('/asdm/verify-worker', [AsdmController::class, 'verifyWorker']);
    Route::post('/asdm/verify-dependent', [AsdmController::class, 'verifyDependent']);
});




