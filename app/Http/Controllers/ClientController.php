<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;
use Validator;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json( Client::all());
    }

    public function show($id)
    {

        $client = Client::where('id', $id)->get();
        return response()->json($client);

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:clients',
            'name' => 'required|string|max:50',
            'company_id' => 'required'
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        $client = new Client();
        $client->company_id = $request->company_id;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->save();
        return response()->json(null, 200);
    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:clients',
            'name' => 'required|string|max:50',
            'company_id' => 'required'
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        Client::where ('id',$id)->update(['company_id'=>$request->company_id,'name'=>$request->name,'email'=>$request->email]);
        return response()->json(null, 201);
    }

    public function destroy($id)
    {
        Client::where('id','=',$id)->delete();
        return response()->json(null, 204);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('stor')->with(['companies'=>Company::all()]);
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
    public function edit(Client $client )
    {

        return view('update')->with(['client'=>$client,'companies'=>Company::all()]);
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
