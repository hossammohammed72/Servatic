
<form method='post' action='{{route('companies.store')}}'>
    @csrf
    <input type='text' name='name'>
    <input type='submit'>
</form>