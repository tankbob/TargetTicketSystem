Choose a client

<table class="table table-stripped">
    <thead>
        <th></th>
        <th>Company</th>
        <th>Clients Name</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td><a href="{{ url($client->company_slug . '/tickets') }}">GOTOICON</a></td>
                <td>{{ $client->company }}</td>
                <td>{{ $client->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
