<?php

use Illuminate\Support\Facades\Route;
use Xoxoday\Disclaimer\Http\Controller\DisclaimerController;

Route::group(['middleware' => ['web']], function () {

Route::get('/disclaimer', [DisclaimerController::class, 'showDisclaimerPage'])->name('disclaimer');;

Route::get('/form', [DisclaimerController::class, 'showFormPage']);

Route::post('/form', [DisclaimerController::class, 'postFormData']);

});
