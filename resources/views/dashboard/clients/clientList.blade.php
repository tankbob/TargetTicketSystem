<h2 class="maintenance-title pull-left">Clients</h2> <a href="#" class="clientFormToggler icon-new-client pull-left" clientId="0"></a>

@if(session('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<table class="table ticket-table" id="client-table">
    <thead>
        <th class="goto-column hidden-xs"></th>
        <th class="hidden-xs">Email</th>
        <th>Name</th>
        <th class="hidden-sm hidden-xs">Last Login</th>
        <th class="text-center">Delete</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr id="client-row-{{ $client->id }}" class="clientFormToggler" clientId="{{ $client->id }}">
                <td class="hidden-xs"><a href="#" class="show-on-hover icon-goto" clientId="{{ $client->id }}"></a></td>
                <td class="td-adjust hidden-xs" id="client-email-{{ $client->id }}">{{ $client->email }}</td>
                <td class="td-adjust" id="client-name-{{ $client->id }}">{{ $client->name }}</td>
                <td class="td-adjust hidden-sm hidden-xs"></td>
                <td><a href="#" class="clientDelete icon-delete" clientId="{{ $client->id }}"></a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="clientFormDiv" class="row"></div>
