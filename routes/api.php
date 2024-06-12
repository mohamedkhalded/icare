<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//clinic
Route::post  ('/clinic/register', [ClinicController::class, 'register'])->name('clinic.register');
Route::post  ('/clinic/login'           , 'App\Http\Controllers\ClinicController@login')   ->name('clinic.login');
Route::post  ('/clinic/logout'          , 'App\Http\Controllers\ClinicController@logout')  ->name('clinic.logout')->middleware(['clinic:sanctum', 'verified']);
Route::get   ('/clinic'                 , 'App\Http\Controllers\ClinicController@index')   ->name('admin.index');
Route::get   ('/clinic/show/{id}'       , 'App\Http\Controllers\ClinicController@show')    ->name('admin.show');
Route::post  ('/clinic/store'           , 'App\Http\Controllers\ClinicController@store')    ->name('clinic.store');
Route::get   ('/clinic/show/{id}'       , 'App\Http\Controllers\ClinicController@show')     ->name('clinic.show');
Route::put   ('/clinic/update/{id}'     , 'App\Http\Controllers\ClinicController@update')   ->name('clinic.update');
Route::delete('/clinic/destroy/{id}'    , 'App\Http\Controllers\ClinicController@destroy')  ->name('clinic.destroy');
//laporatory
Route::post  ('/laporatory/register'    , 'App\Http\Controllers\LaporatoryController@register')->name('laporatory.register');
Route::post  ('/laporatory/login'       , 'App\Http\Controllers\LaporatoryController@login')   ->name('laporatory.login');
Route::post  ('/laporatory/logout'      , 'App\Http\Controllers\LaporatoryController@logout')  ->name('laporatory.logout')->middleware(['laporatory:sanctum', 'verified']);
Route::get   ('/laporatory'             , 'App\Http\Controllers\LaporatoryController@index')   ->name('laporatory.index');
Route::get   ('/laporatory/show/{id}'   , 'App\Http\Controllers\LaporatoryController@show')    ->name('laporatory.show');
Route::post  ('/laporatory/store'       , 'App\Http\Controllers\LaporatoryController@store')->name('laporatory.store');
Route::get   ('/laporatory/show/{id}'   , 'App\Http\Controllers\LaporatoryController@show')->name('laporatory.show');
Route::put   ('/laporatory/update/{id}' , 'App\Http\Controllers\LaporatoryController@update')    ->name('laporatory.update');
Route::delete('/laporatory/destroy/{id}', 'App\Http\Controllers\LaporatoryController@destroy')   ->name('laporatory.destroy');
//pharmcy
Route::post  ('/pharmcy/register'       , 'App\Http\Controllers\PharmcyController@register')->name('pharmcy.register');
Route::post  ('/pharmcy/login'          , 'App\Http\Controllers\PharmcyController@login')   ->name('pharmcy.login');
Route::post  ('/pharmcy/logout'         , 'App\Http\Controllers\PharmcyController@logout')  ->name('pharmcy.logout')->middleware(['pharmcy:sanctum', 'verified']);
Route::get   ('/pharmcy'                , 'App\Http\Controllers\PharmcyController@index')   ->name('pharmcy.index');
Route::get   ('/pharmcy/show/{id}'      , 'App\Http\Controllers\PharmcyController@show')    ->name('pharmcy.show'     );
Route::post  ('/pharmcy/store'          , 'App\Http\Controllers\PharmcyController@store')     ->name('pharmcy.store'  );
Route::get   ('/pharmcy/show/{id}'      , 'App\Http\Controllers\PharmcyController@show')      ->name('pharmcy.show'   );
Route::put   ('/pharmcy/update/{id}'    , 'App\Http\Controllers\PharmcyController@update')    ->name('pharmcy.update' );
Route::delete('/pharmcy/destroy/{id}'   , 'App\Http\Controllers\PharmcyController@destroy')   ->name('pharmcy.destroy');
//patient
Route::post  ('/patient/register'     , 'App\Http\Controllers\PatientController@register')->name('patient.register');
Route::post  ('/patient/login'        , 'App\Http\Controllers\PatientController@login')   ->name('patient.login'   );
Route::post  ('/patient/logout'       , 'App\Http\Controllers\PatientController@logout')  ->name('patient.logout'  )->middleware(['patient:sanctum', 'verified']);
Route::get   ('/patient'              , 'App\Http\Controllers\PatientController@index')   ->name('patient.index'   );
Route::get   ('/patient/show/{id}'    , 'App\Http\Controllers\PatientController@show')    ->name('patient.show'    );
Route::post  ('/patient/store'          , 'App\Http\Controllers\PatientController@store')     ->name('patient.store' );
Route::get   ('/patient/show/{id}'      , 'App\Http\Controllers\PatientController@show')      ->name('patient.show'  );
Route::put   ('/patient/update/{id}'    , 'App\Http\Controllers\PatientController@update')    ->name('patient.update');
Route::delete('/patient/destroy/{id}'   , 'App\Http\Controllers\PatientController@destroy')   ->name('patient.destroy');
//laporatoryreservation
Route::get('/laporatoryreservation', 'App\Http\Controllers\ReservationlaporatoryController@index')->name('laporatoryreservation.index');
Route::post('/laporatoryreservation/store', 'App\Http\Controllers\ReservationlaporatoryController@store')->name('laporatoryreservation.store');
Route::get('/laporatoryreservation/show/{id}', 'App\Http\Controllers\ReservationlaporatoryController@show')->name('laporatoryreservation.show');
Route::put('/laporatoryreservation/update/{id}', 'App\Http\Controllers\ReservationlaporatoryController@update')->name('laporatoryreservation.update');
Route::delete('/laporatoryreservation/destroy/{id}', 'App\Http\Controllers\ReservationlaporatoryController@destroy')->name('laporatoryreservation.destroy');
Route::get('/laporatoryreservation/showindoctor/{id}', 'App\Http\Controllers\ReservationlaporatoryController@showindoctor')->name('laporatoryreservation.showindoctor');

//clinicreservation
Route::get   ('/clinicreservation', 'App\Http\Controllers\ReservationclinicController@index')->name('clinicreservation.index');
Route::post  ('/clinicreservation/store', 'App\Http\Controllers\ReservationclinicController@store')->name('clinicreservation.store');
Route::get   ('/clinicreservation/show/{id}'     , 'App\Http\Controllers\ReservationclinicController@show')->name('clinicreservation.show');
Route::put   ('/clinicreservation/update/{id}'        , 'App\Http\Controllers\ReservationclinicController@update')->name('clinicreservation.update');
Route::delete('/clinicreservation/destroy/{id}'   , 'App\Http\Controllers\ReservationclinicController@destroy')->name('clinicreservation.destroy');
Route::get   ('/clinicreservation/showindoctor/{id}'  , 'App\Http\Controllers\ReservationclinicController@showindoctor')->name('clinicreservation.showindoctor');
//chat 
