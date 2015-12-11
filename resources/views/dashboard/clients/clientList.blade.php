
<h2 class="maintenance-title pull-left">Clients</h2> <a href="#" class="clientFormToggler icon-new-client pull-left" clientId="0"></a>


<table class="table ticket-table" id="client-table">
    <thead>
        <th width="75"></th>
        <th>Email</th>
        <th>Name</th>
        <th>Last Login</th>
        <th class="text-center">Delete</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr id="client-row-{{ $client->id }}">
                <td><a href="#" class="clientFormToggler show-on-hover icon-goto" clientId="{{ $client->id }}"></a></td>
                <td class="td-adjust" id="client-email-{{ $client->id }}">{{ $client->email }}</td>
                <td class="td-adjust" id="client-name-{{ $client->id }}">{{ $client->name }}</td>
                <td class="td-adjust"></td>
                <td><a href="#" class="clientDelete icon-delete" clientId="{{ $client->id }}"></a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="clientFormDiv" class="row"></div>
