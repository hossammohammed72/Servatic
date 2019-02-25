<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\AgentController;
use App\Models\Ticket;
use App\User;
class TicketController extends Controller
{
    public function index() {
        $ticket = DB::table('tickets')
            ->select('tickets.action','tickets.complaint','clients.name as client' ,'users.name as user' , 'companies.name as company')
            ->join('users', 'users.id', '=', 'tickets.agent_id')
            ->join('clients', 'clients.id', '=', 'tickets.client_id')
            ->join('companies', 'companies.id', '=', 'tickets.company_id')
            ->get();
        dd($ticket);
    }
    public function show($id) {
        $ticket = DB::table('tickets')
            ->select('tickets.action','tickets.complaint','clients.name as client' ,'users.name as user' , 'companies.name as company')
            ->join('users', 'users.id', '=', 'tickets.agent_id')
            ->join('clients', 'clients.id', '=', 'tickets.client_id')
            ->join('companies', 'companies.id', '=', 'tickets.company_id')
            ->where('tickets.id','=',$id)
            ->get();
        dd($ticket);
    }
    public function create(){
        $agent= AgentController::index()->pluck('id');
        return view('createTicket')->with('agents',$agent);
    }
    public function store(request $request) {
        
        $validatedData = $request->validate([
            'complaint'=>'required|string|max:100',
            'action' => 'required|string',
        ]);

        $ticket = new Ticket();
        $ticket->client_id = $request->input('client_id');
        $ticket->agent_id = $request->input('agent_id');
        $ticket->company_id = $request->input('company_id');
        $ticket->complaint = $request->input('complaint') ;
        $ticket->action = $request->input('action');
        $ticket->save();
        dd($ticket);
    }   
    public function edit($id){
        return view('editTicket')->with('id',$id);
    }
    public function update(request $request, $id) {
        $validatedData = $request->validate([
            'complaint'=>'required|string|max:100',
            'action' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->complaint = $request->input('complaint');
        $ticket->action = $request->input('action');
        $ticket->save();
    }
    public function destroy($id) {
        ticket::where('id',$id)->delete();
    }
    
}
