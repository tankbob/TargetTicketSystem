Choose a client <a href="#" class="clientFormToggler" clientId="0">NEW CLIENT ICON</a>

<table class="table table-stripped" id="client-table">
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
                <td id="client-email-{{$client->id}}">{{$client->email}}</td>
                <td id="client-name-{{$client->id}}">{{$client->name}}</td>
                <td></td>
                <td>DELETE ICON</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div id="clientFormDiv">

</div>