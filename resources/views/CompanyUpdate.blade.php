
<form method='post' action='{{route('companies.update',['id'=>$id])}}'>
    @csrf
    {{method_field('put')}}
    <input type='text' name='name'>
    <input type='submit'>
</form>