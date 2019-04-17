<?php

namespace App\Http\Controllers;
use App\Models\Moderator;
use App\User;
use App\Models\Company;
use Validator;
use Illuminate\Http\Request;
use Hash;
use DB;


class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $moderators=DB:: select('select user_id from moderators');
        //->where('company_id','=',4)

        $moderators =DB::table('moderators')->get();;
        $moderato=array();

        foreach($moderators as $moderator){

            $moderato[]=User::where('id', $moderator->user_id)->get();
          }

        return response()->json([$moderato]);

        //return response()->json([$moderators]);
    }


    public function show($id)
    {

        $moderators = User::where('id', $id)->get();
        return response()->json($moderators);

    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'company_id'=>'required'
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $moderator = new Moderator();
        $moderator->user_id =$user->id ;
        $moderator->company_id =$request->company_id ;
        $moderator->save();
        return response()->json($moderator, 200);

    }

    public function update(request $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        User::where ('id',$id)->update(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password)]);

        return response()->json(null, 201);
    }




    public function destroy($id)
    {
        User::where('id','=',$id)->delete();
        Moderator::where('user_id','=',$id)->delete();
        return response()->json(null, 204);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
