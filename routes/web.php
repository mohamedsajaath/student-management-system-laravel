<?php

use App\Http\Controllers\StudentController;
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


Route::get( '/',[StudentController::class ,'index'])->name('student');

Route::post( '/edit/{id}',[StudentController::class,'edit'] )
->name('student.edit');

Route::post('/store',[StudentController::class,'store'])->name('student.store');

Route::post('/update',[StudentController::class,'update'])->name('student.update');


Route::post('/delete/{id}',[StudentController::class,'destroy'])->name('student.delete');
