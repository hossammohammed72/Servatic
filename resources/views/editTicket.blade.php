@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('ticket.update' , ['id'=>$id])}}" method="POST">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    action: <input type="text" name="action"><br><br>
    Complaint: <input type="text" name="complaint">
    <input type="submit">
</form>