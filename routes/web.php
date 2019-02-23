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

Route::get('/', function () {
    return view('welcome');

});


Route :: get('moderator/store/{uid}/{cid}','moderators@store');
Route :: get('moderator/show/{id}','moderators@show');
Route :: get('moderator/update/{uid}/{cid}','moderators@update');
Route :: get('moderator/destroy/{id}','moderators@destroy');
Route :: get('client/store/{id}/{name}/{email}/{company_id}','clients@store');
Route :: get('client/show/{id}','clients@show');
Route :: get('client/update/{id}/{name}/{email}/{company_id}','clients@update');
Route :: get('client/destroy/{id}','clients@destroy');
Route :: get('company/store/{id}/{name}','companies@store');
Route :: get('company/show/{id}','companies@show');
Route :: get('company/update/{id}/{name}','companies@update');
Route :: get('company/destroy/{id}','companies@destroy');

//Route::get('client/{id}', [
  //  'as' => 'client.show',
  //  'uses' => 'clients@show'
//]);
//Route::resource('user', 'users', ['except' => 'show']);
