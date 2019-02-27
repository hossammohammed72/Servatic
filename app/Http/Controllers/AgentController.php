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
    public static function index() {
        $agent = DB::table('users')
            ->join('agents', 'users.id', '=', 'agents.user_id')
            ->select('users.*')
            ->get();
        return $agent;
        //dd($agent);
    }
    public function show($id) {
        dd(user::findOrfail($id));
    }   
    public function create(){
        return view('form')->with('companies',company::pluck('name'));
    }
    public function store(AgentStoreRequest $request) {
        $user = new user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $agent = new agent();
        $agent->user_id = user::where('email',$request->input('email'))->first()->id;
        $agent->company_id = company::where('name', $request->input('company'))->first()->id;
        $agent->save(); 
        dd($user);
    }
    public function edit($id){
        return view('edit')->with('id',$id);
    }
    public function update(request $request , $id) {
        $validatedData = $request->validate([
            'name'=>'required|string|max:50',
            'password' => 'required|min:8|required_with:confirmPassword|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }
    public function destroy($id) {
        user::where('id',$id)->delete();
        agent::where('user_id',$id)->delete();
    }

}