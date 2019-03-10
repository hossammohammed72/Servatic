<?php

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\agent;

use App\Http\Resources\AgentResource; 
use App\User;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('agent/', 'AgentController@index');
Route::get('agent/{id}', 'AgentController@show');
Route::post('agent/', 'AgentController@store');
Route::put('agent/{id}', 'AgentController@update');
Route::delete('agent/{id}', 'AgentController@destroy');

Route::get('ticket/','Ticketcontroller@index');
Route::get('ticket/{id}','TicketController@show');
Route::post('ticket/', 'Ticketcontroller@store');
Route::put('ticket/{id}', 'Ticketcontroller@update');
Route::delete('ticket/{id}', 'TicketController@destroy');
//////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
Route :: resource('moderators','ModeratorController');
Route :: resource('clients','ClientController');
Route :: resource('companies','CompanyController');