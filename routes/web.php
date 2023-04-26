<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;



Route::middleware(['guard'])->group(function(){
    
    Route::get('/dashboard',[CustomAuthController::class,'dashboard']);
    
    Route::get('/logout',[CustomAuthController::class,'logout']);


    Route::get("/quiz",[StudentController::class,'start_quiz']);

    Route::post("/status",[StudentController::class,'add']);

    Route::post("/eval",[StudentController::class,'evaluate'])->name('eval');

    Route::get("/cross-check", [StudentController::class , 'CrossCheck']);
    
    

});



Route::get('/', function () {return view('welcome');});
Route::get("/registration",[CustomAuthController::class,'registration']);
Route::post('/register-user',[CustomAuthController::class,'registerUser']);
Route::get('/login',[CustomAuthController::class,'login']);
Route::post('/login-user',[CustomAuthController::class,'loginUser']);

Route::get("/prev",[StudentController::class, 'showHistory'])->name('prev');

Route::get("/leaderBoard",[StudentController::class,'showResult'])->name('leaderBoard');



// Route::get("/status",[StudentController::class,'index']);
// Route::post("/status",[StudentController::class,'add']);
// Route::post("/store-answer",[StudentController::class,'store']);