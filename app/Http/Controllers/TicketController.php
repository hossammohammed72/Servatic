<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AgentController;
use App\Models\Ticket;
use Validator;
use App\User;
use DB;

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

    public function show($id) {
        $ticket = DB::table('tickets')
            ->select('tickets.action','tickets.complaint','clients.name as client' ,'users.name as agent' , 'companies.name as company')
            ->join('users', 'users.id', '=', 'tickets.agent_id')
            ->join('clients', 'clients.id', '=', 'tickets.client_id')
            ->join('companies', 'companies.id', '=', 'tickets.company_id')
            ->where('tickets.id','=',$id)
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
        return response()->json(null, 201);
    }
    public function destroy($id) {
        ticket::where('id',$id)->delete();
        return response()->json(null, 204);
    }
    
}
