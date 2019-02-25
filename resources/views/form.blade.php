@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method='post' action='{{route('agent.store')}}'>
@csrf
    name: <input type='text' name='name'><br><br>
    email: <input type='email' name='email'><br><br>
    password: <input type='password' name='password'><br><br>
    Company: 
    <select name="company">
        @foreach($companies as $company)
            <option value = "{{$company}}">{{$company}}</option>
        @endforeach
    </select>
    <input type='submit'>
</form>