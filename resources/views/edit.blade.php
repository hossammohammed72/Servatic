@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('agent.update' , ['id'=>$id])}}" method="POST">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    name: <input type="text" name="name"><br><br>
    Password: <input type="password" name="password">
    confirm Password: <input type="password" name="confirmPassword">
    <input type="submit">
</form>