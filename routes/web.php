<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




//===========================INDEX PAGE================================//
Route::get('/','App\Http\Controllers\GoodsController@index');
Route::post('/add-item','App\Http\Controllers\GoodsController@add');
Route::post('/add-itemtype','App\Http\Controllers\GoodsController@addtype');
// Route::get('/getitem','App\Http\Controllers\GoodsController@show');
Route::get('/get-item','App\Http\Controllers\GoodsController@show');
Route::get('/getitemtype','App\Http\Controllers\GoodsController@show2');
Route::post('/update-item','App\Http\Controllers\GoodsController@edit');
Route::post('/additem','App\Http\Controllers\GoodsController@additem');
Route::post('/takeitem','App\Http\Controllers\GoodsController@takeitem');
Route::get('/delete-item/{id}','App\Http\Controllers\GoodsController@destory');


//===========================USER PAGE================================//


// Route::get('/','App\Http\Controllers\GoodsController@index');

Route::get('/user-requests','App\Http\Controllers\UserController@showRequests');
Route::get('/getrequest','App\Http\Controllers\UserController@getrequest');
Route::post('/submit-request' ,'App\Http\Controllers\UserController@submitRequest');





//===========================MANAGER PAGE================================//
Route::get('/manager-requests','App\Http\Controllers\ManagerController@showRequests');
Route::post('/approve-request/{id}', 'App\Http\Controllers\ManagerController@approveRequest'); // For managers to approve requests via AJAX
Route::post('/reject-request/{id}', 'App\Http\Controllers\ManagerController@rejectRequest');   // For managers to reject requests via AJAX






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
