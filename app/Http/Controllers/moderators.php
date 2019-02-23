<?php

namespace App\Http\Controllers;
use App\Models\Moderator;
use Illuminate\Http\Request;

class moderators extends Controller
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
        echo "kdnsklvjncdsknvdsln";

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id,$company_id)
    {
        $moderator = new Moderator();

        $moderator->user_id = $user_id ;

        $moderator->company_id = $company_id;

        $moderator->save();
        dd($moderator);
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
        { dd(Moderator::all()); }
        else {
            $moderators = Moderator::where('user_id', $id)->get();
            dd($moderators);
        }
        echo "show don";
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
    public function update($u_id,$c_id)
    {
        Moderator::where ('user_id',$u_id)->update(['company_id'=>$c_id]);
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
        Moderator::where('user_id','=',$id)->delete();
        echo "deleted done";
    }
}
