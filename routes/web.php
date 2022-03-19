<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatusMasterController;
use App\Http\Controllers\CompanyDetailController;
use App\Http\Controllers\LineMasterController;
use App\Http\Controllers\ContainerTypeController;
use App\Http\Controllers\EDIController;
use App\Http\Controllers\GetPassController;
use App\Http\Controllers\IalUploadController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BulkUpload;
use Illuminate\Support\Facades\Auth;
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
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('/dashboard');
    }else{
        return view('auth/login');
    }
});
// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('new-user',[AdminController::class,'index'])->name('user.create');
    Route::resource('upload-ial-file',IalUploadController::class);
    Route::get('ial-report',[IalUploadController::class,'ial_report'])->name('ial_report');
    Route::resource('status-master',StatusMasterController::class);
    Route::resource('company',CompanyDetailController::class);
    Route::resource('line-master',LineMasterController::class);
    Route::resource('container-type',ContainerTypeController::class);
    Route::resource('gate-pass',GetPassController::class);
    Route::post('gate-pass',[GetPassController::class,'store']);
    Route::post('gate-pass-preview',[GetPassController::class,'gate_pass_preview']);
    Route::get('download-gate-pass-reciept/{related}',[GetPassController::class,'reciept']);
    Route::post('out-pass',[GetPassController::class,'out_container_store']);
    Route::view('dashboard','dashboard')->name('dashboard');
    Route::get('out-container',[GetPassController::class,'out_container'])->name('out_container');
    Route::get('estimate-data-report',[GetPassController::class,'estimate_data_report'])->name('estimate_data_report');
    Route::post('save-estimate-report',[GetPassController::class,'save_estimate_report']);
    Route::resource('inventory-report',InventoryController::class);
    Route::post('inventory-report',[InventoryController::class,'inventory_report_fetch'])->name('inventory_report_fetch');
    Route::get('container-register',[InventoryController::class,'container_register'])->name('container_register');
    Route::get('depot-stock-report',[InventoryController::class,'depot_stock_report'])->name('depot_stock_report');
    Route::post('depot-stock-report',[InventoryController::class,'depot_stock_report_fetch'])->name('depot_stock_report_fetch');
    Route::post('store-tues-value',[InventoryController::class,'store_tues_value']);
    Route::get('excel-update',[InventoryController::class,'excel_update_view'])->name('excel_update_view');
    Route::post('excel-update',[InventoryController::class,'excel_update'])->name('excel_update');
    Route::get('estimate-data-import',[InventoryController::class,'estimate_data_import'])->name('estimate_data_import');
    Route::post('upload_estimate_data_import',[InventoryController::class,'upload_estimate_data_import'])->name('upload_estimate_data_import');
    Route::post('container-register',[InventoryController::class,'container_register_fetch'])->name('container_register_fetch');;
    Route::get('total-in-out-movement',[InventoryController::class,'total_in_out_movement'])->name('total_in_out_movement');
    Route::post('total-in-out-movement',[InventoryController::class,'total_in_out_movement_fetch'])->name('total_in_out_movement_fetch');
    Route::post('multi-sheets',[InventoryController::class,'multi_sheets'])->name('multi-sheets');
    Route::get('edi',[EDIController::class,'index'])->name('edi');
    Route::post('edi',[EDIController::class,'edi_fetch'])->name('edi_fetch');
    Route::get('offhire',[GetPassController::class,'offhire'])->name('offhire');
    Route::post('offhire',[GetPassController::class,'offhire_save'])->name('offhire_save');
    Route::get('bulk-upload',[BulkUpload::class,'index'])->name('bulk_upload.index');
    Route::post('bulk-upload-in',[BulkUpload::class,'bulk_upload_in'])->name('bulk_upload.in');
    Route::post('bulk-upload-out',[BulkUpload::class,'bulk_upload_out'])->name('bulk_upload.out');
    Route::post('/edi_report',[EDIController::class,'edi_report'])->name('edi_report');
// });

