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

Route::middleware('auth:api')->group(function(){
    Route::resource('agents', 'AgentController');
    Route::resource('tickets', 'TicketController');
    Route::post('tickets/update/{id}','TicketController@update');
    Route::resource('moderators','ModeratorController');
    Route::resource('clients','ClientController');
    Route::resource('companies','CompanyController');
    Route::get('roomClient/{room}','ChatController@ِgetRoomClient');

    Route::get('agents/company/{id}', 'AgentController@companyAgents');
});

Route::resource('rooms','RoomController');

Route::get('makeusers','ChatController@testAgentUser');
Route::post('addtoroom/','ChatController@ِaddClientToRoom');
Route::post('pusher_auth/','ChatController@ِpusherAuth');

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

//Route::put('test/','TicketController@update');