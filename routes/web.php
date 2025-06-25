<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TermsAndConditionController;

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
    return redirect('admin/login');
});

Route::group(['middleware' => ['web']], function() {
    Route::get(config('crudbooster.ADMIN_PATH'),[AdminDashboardController::class, 'index']);
});

Route::post('/check-terms-accepted', [TermsAndConditionController::class, 'checkTermsAccepted'])->name('check-terms-accepted');
