Choose a client <a href="#" class="clientFormToggler" clientId="0">NEW CLIENT ICON</a>

<table class="table table-stripped">
    <thead>
        <th></th>
        <th>Email</th>
        <th>Name</th>
        <th>Last Login</th>
        <th>Delete</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td><a href="#" class="clientFormToggler" clientId="{{$client->id}}">GOTOICON</a></td>
                <td>{{$client->email}}</td>
                <td>{{$client->name}}</td>
                <td></td>
                <td>DELETE ICON</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div id="clientFormDiv">

</div>