<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Ticket;
use DB;
use Illuminate\Http\Request;
use Validator;
use DateTime;



class TicketController extends Controller
{
    public function index() {
        $ticket = DB::table('tickets')
        ->select('tickets.action','tickets.complaint','clients.name as client' ,'users.name as agent' , 'companies.name as company')
        ->join('users', 'users.id', '=', 'tickets.agent_id')
        ->join('clients', 'clients.id', '=', 'tickets.client_id')
        ->join('companies', 'companies.id', '=', 'tickets.company_id')
        ->get();
        return response()->json($ticket, 200);
    }
    // id is company id
    public function show($id) {
            $ticket = DB::table('tickets')
            ->select('tickets.action','tickets.complaint','clients.name as client' ,'users.name as agent')
            ->join('users', 'users.id', '=', 'tickets.agent_id')
            ->join('clients', 'clients.id', '=', 'tickets.client_id')
            ->where('tickets.company_id', '=', $id)
            ->get();
        return response()->json($ticket, 200);
    }

    public function store(request $request) {
        $validator = Validator::make($request->all(), [
            'complaint'=>'required|string|max:100',
            'action' => 'required|string',
            'agent_id' =>'required|exists:agents,user_id',
            'client_id' =>'required|exists:clients,id',
            'company_id' =>'required|exists:companies,id',
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        $ticket = new Ticket();
        $ticket->client_id = $request->input('client_id');
        $ticket->agent_id = $request->input('agent_id');
        $ticket->company_id = $request->input('company_id');
        $ticket->complaint = $request->input('complaint') ;
        $ticket->action = $request->input('action');
        $ticket->save();
        return response()->json(null, 200);
    }



    public function update(request $request, $id) {

        $validator = validator::make($request->all(), [
            'complaint'=>'required|string|max:100',
            'action' => 'required|string',
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        $ticket = Ticket::findOrFail($id);

        $ticket->complaint = $request->input('complaint');
        $ticket->action = $request->input('action');
        $ticket->save();
        Agent::where('user_id',$ticket->agent_id)->update(['busy'=>0]);

        $agent_id=$ticket->agent_id;
        $client_id=$ticket->client_id;
        $room_id=$request->room_id;
        self::response_time($agent_id,$client_id,$room_id);

        return response()->json(null, 201);
    }



    public function destroy($id) {
        ticket::where('id',$id)->delete();
        return response()->json(null, 204);
    }


    public function response_time($agent_id,$client_id,$room_id)
    {
        $CratAt = new DateTime(DB :: table ('rooms')->where('agent_id',$agent_id)->where('client_id',$client_id)
            ->orderByDesc('created_at')->take(1)->value('created_at'));

        $UpDate = new DateTime(DB :: table ('tickets')->where('agent_id',$agent_id)->where('client_id',$client_id)
            ->orderByDesc('updated_at')->take(1)->value('updated_at'));

        $def = $CratAt->diff($UpDate);

        $ResponseTime=$def->format('%h').":".$def->format('%i').":".$def->format('%s');

       DB:: table ('rooms')->where('id',$room_id)->where('agent_id',$agent_id)
           ->where('client_id',$client_id)->orderByDesc('updated_at')->take(1)->update(['response_time'=>$ResponseTime]);
        return ;
    }
}
