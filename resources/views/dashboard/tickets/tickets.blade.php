<h2 class="maintenance-title">Choose a client</h2>

@if($clients)
<table class="table ticket-table">
    <thead>
        <th class="goto-column"></th>
        <th>Company</th>
        <th class="hidden-xs">Clients Name</th>
        <th>Response Needed</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr class="clickable-row" data-href="{{ url($client->company_slug . '/tickets') }}">
                <td><i class="show-on-hover icon-goto"></i></td>
                <td class="td-adjust">{{ $client->company }}</td>
                <td class="td-adjust hidden-xs">{{ $client->name }}</td>
                <td class="td-adjust">{{ count($client->openTickets->where('responded', 0)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-warning">There are no clients</div>
@endif
