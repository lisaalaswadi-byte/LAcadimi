<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LogMiddleware;
use App\Http\Controllers\AdminController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/publish',[AdminController::class,"publish"])->name("publish");
Route::post('/setPublish',[AdminController::class,"setPublish"])->name("setPublish");
Route::get('/news',[AdminController::class,"news"])->name("news");
Route::post('/setInfos',[AdminController::class,'setInfos'])->name("setInfos");
});



    Route::get("/log",[UserController::class,"login"])->name("log");
    Route::post("/setLogin",[UserController::class,'setLogin'])->name("setLogin");

//================================user routes=============================
Route::middleware('log')->group(function (){
    Route::get('/python',[UserController::class,"python"])->name('pythonEditor');
    Route::get('/HTMLCSSJS',[UserController::class,'frontEnd'])->name('forntEndEditor');
    Route::get("/userIndex",[UserController::class,"index"])->name('userIndex');
    Route::get("/catigory/{id}",[UserController::class,"show"])->name("catigory.show");
    Route::get("/userNews",[UserController::class,'userNews'])->name('userNews');


});

//=========================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
