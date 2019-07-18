<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Ticket;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;
use Validator;
use DB;
use DateTime;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Company::all());
    }



    public function show($id)
    {

        $company = Company::where('id', $id)->get();
        return response()->json($company);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:companies'
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);


        $company = new Company();
        $company->name = $request->name;
        $company->save();
        return response()->json($company, 200);

    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:companies'
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        Company::where ('id',$id)->update(['name'=>$request->name]);
        return response()->json(null, 201);

    }


    public function destroy($id)
    {
        Company::where('id','=',$id)->delete();
        return response()->json(null, 204);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CompanyStor');

    }


    public function stats($company_id)
    {
       $agents_id = DB :: table('agents')->where('company_id',$company_id)->select('user_id')->get();

        $company = [];
        $companyName = DB::table('companies')->where('id',$company_id)->value('name');
        $avgWaitingTime = DB::table('tickets')->where('company_id',$company_id)->avg('waiting_time');
        $avgResponseTime = DB::table('tickets')->where('company_id',$company_id)->avg('response_time');
        $avgAccuracy = DB::table('tickets')->where('company_id',$company_id)->AVG('accuracy');

        $company [0] = $companyName ;
        $company [1] = $avgWaitingTime ;
        $company [2] = $avgResponseTime ;
        $company [3] = $avgAccuracy ;

        $agents = [];
        $i = 0;
       foreach ( $agents_id as $id )
       {
            $agentAvgResponseTime = DB::table('tickets')->where('agent_id',$id->user_id)->avg('response_time');
            $agentName = DB :: table('users')->where('id',$id->user_id)->value('name');
            $numberOfTickets = Ticket::where('agent_id',$id->user_id)->count('id');
            $agents[$i][0] = $agentName;
            $agents[$i][1] = $agentAvgResponseTime;
            $agents[$i][2] = $numberOfTickets;
            $i = $i + 1 ;
        }
        $data = [];
       $data[0] = $company ;
       $data[1] = $agents  ;
       return response()->json($data);

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
    public function edit($id)
    {
        return view('CompanyUpdate')->with(['id'=>$id]);
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
