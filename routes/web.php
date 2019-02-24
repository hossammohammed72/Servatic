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
use App\User;
use App\Models\Company;
use App\Models\agent;

Route::get('/', function () {
    return view('welcome');
});
Route::put('agent/', 'AgentController@store')->name('agent.store');
Route::get('agent/add', 'AgentController@create')->name('agent.add');
