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
Route::get('agent/', 'AgentController@index');
Route::get('agent/show/{id}', 'AgentController@show');
Route::get('agent/add/', 'AgentController@create')->name('agent.add');
Route::post('agent/', 'AgentController@store')->name('agent.store');
Route::get('agent/edit/{id}', 'AgentController@edit');
Route::put('agent/update/{id}', 'AgentController@update')->name('agent.update');
Route::delete('agent/{id}', 'AgentController@delete');

Route::get('ticket/','Ticketcontroller@index');
Route::get('ticket/show/{id}','TicketController@show');
Route::get('ticket/create/', 'TicketController@create');
Route::post('ticket/' , 'Ticketcontroller@store')->name('ticket.store');
Route::get('ticket/edit/{id}', 'Ticketcontroller@edit');
Route::put('ticket/update/{id}', 'Ticketcontroller@update')->name('ticket.update');
Route::delete('ticket/{id}', 'Ticketcontroller@delete');

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
