@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method='post' action='{{route('ticket.store')}}'>
@csrf
    <select name="agent_id">
        @foreach($agents as $agent)
            <option value = "{{$agent}}">{{$agent}}</option>
        @endforeach
    </select>   
    <select name="client_id">
        <option value = "2" selected>client id </option>
    </select>
    <select name="company_id">
        <option value = "2" selected>company id </option>
    </select>     
    Complaint: <input type="text" name="complaint" >
    Action: <input type ="text" name = "action" >
    <input type = "submit">
</form>