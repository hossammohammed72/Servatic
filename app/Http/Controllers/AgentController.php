<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests\AgentStoreRequest;
use App\User;
use App\Models\Company;
use App\Models\agent;
use Hash;

class AgentController extends Controller
{
    public function index() {
        $agent = DB::table('users')
            ->join('agents', 'users.id', '=', 'agents.user_id')
            ->select('users.*')
            ->get();
        dd($agent);
    }
    public function create(){
        return view('form');
    }
    public function store(AgentStoreRequest $request) {
        $user = new user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->name = Hash::make($request->input('password'));
        $user->save();

        $agent = new agent();
        $agent->user_id = user::where('email',$request->input('email'))->first()->id;
        $agent->company_id = company::where('name', $request->input('company'))->first()->id;
        $agent->save(); 

        //return response()->json($user, 201);
    }
    public function show($id) {
        dd(user::where('id',$id)->get());
    }
    public function update(AgentStoreRequest $request, $id) {
        $user = User::findOrFail($id);
        $input = $request->all();

        $user->fill($input)->save();
        //return response()->json($user, 200);
    }
    public function destroy($id) {
        user::where('id',$id)->delete();
        agent::where('user_id',$id)->delete();
    }

}