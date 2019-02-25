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
<input type='text' name='name'>
<input type='ss' name='email'>
<input type='password' name='password'>
<input type='submit'>
</form>