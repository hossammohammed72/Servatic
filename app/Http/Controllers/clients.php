<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class clients extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($id,$name,$email,$company_id)
    {
        $client = new Client();

        $client->id = $id ;
        $client->company_id = $company_id;
        $client->name = $name;
        $client->email = $email;

        $client->save();
        dd($client);
        echo "store don";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id==0)
        { dd(Client::all()); }
        else {
            $client = Client::where('id', $id)->get();
            dd($client);
        }
    }

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
    public function update($id,$name,$email,$c_id)
    {
        Client::where ('id',$id)->update(['company_id'=>$c_id,'name'=>$name,'email'=>$email]);
        echo "update done";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::where('id','=',$id)->delete();
        echo "deleted done";
    }
}
