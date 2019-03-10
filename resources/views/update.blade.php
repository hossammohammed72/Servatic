@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method='post'  action='{{route('clients.update')}}'>
    @csrf
    {{method_field('put')}}
    <label>User Name</label>
    <input type="text" name='name'>
    <label>E-malie </label>
    <input type="email" name='email'>
    <label>Company </label>
    <select name='company_id'>
        @foreach($companies as $company)
            <option value='{{$company->id}}' >{{$company->name}}</option>
        @endforeach

    </select>

    <input type="submit" value="Submit ">
</form>
