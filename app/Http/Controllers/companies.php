<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

class companies extends Controller
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
       echo "lkjnvlnfdvlksdnvlndvlkds";

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id,$name)
    {
        $company = new Company();

        $company->id = $id ;

        $company->name = $name;

        $company->save();
        dd($company);
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
        { dd(Company::all()); }
        else {
            $company = Company::where('id', $id)->get();
            dd($company);
        }
        echo "show don";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,$name)
    {
        Company::where ('id',$id)->update(['name'=>$name]);
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
        Company::where('id','=',$id)->delete();
        echo "deleted done";
    }
}
