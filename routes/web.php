<?php

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
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home;
use App\Http\Controllers\Accounts;
use App\Http\Controllers\User;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
;

//PMS
use App\Http\Controllers\Work;


 
 
 
Route::get('/Agent',[Home::class,'Show']);
Route::get('/Agent/{id}',[Home::class,'ShowAgent']);
Route::post('/UserAdd',[Home::class,'UserAdd']);
Route::get('/Promo/{id}',[Home::class,'Promo']);




Route::get('/',[Accounts::class,'Login']);
Route::get('/Login',[Accounts::class,'Login']);
Route::get('/Logout', [Accounts::class, 'Logout']);
Route::post('/UserVerify',[Accounts::class,'UserVerify']);
Route::get('/Offers',[Accounts::class,'Offers']);

 
 Route::group(['middleware' => ['CheckAdmin']], function () {


Route::get('/Dashboard',[Accounts::class,'Dashboard']);



Route::get('/User',[User::class,'Show']);
Route::post('/UserSave',[User::class,'UserSave']);
Route::get('/UserEdit/{id}',[User::class,'UserEdit']);
Route::post('/UserUpdate/',[User::class,'UserUpdate']);
Route::get('/UserDelete/{id}',[User::class,'UserDelete']); 

Route::get('/UserProfile',[Accounts::class,'UserProfile']);
Route::get('/ChangePassword',[Accounts::class,'ChangePassword']);
Route::post('/UpdatePassword',[Accounts::class,'UpdatePassword']);

//.............Client..................
Route::get('/Clients',[Accounts::class,'Clients']);
Route::get('/CustomerDelete/{id}',[Accounts::class,'CustomerDelete']); 

// ............Company............
Route::get('/Company',[CompanyController::class,'Company']);
Route::post('/SaveCompany',[CompanyController::class,'SaveCompany']);
Route::get('/CompanyEdit/{id}',[CompanyController::class,'CompanyEdit']);
Route::post('/CompanyUpdate/',[CompanyController::class,'CompanyUpdate']);
Route::get('/CompanyDelete/{id}',[CompanyController::class,'CompanyDelete']);


Route::get('Backup', function () {
	
	/* php artisan migrate */
    \Artisan::call('database:backup');
    dd("Done");
});




Route::post('/DBDump/',[Accounts::class,'DBDump']);
Route::post('/Excel/',[Accounts::class,'Excel']);


});  
// middleware end
