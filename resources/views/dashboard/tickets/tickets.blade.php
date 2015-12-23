<h2 class="maintenance-title">Choose a client</h2>

@if($clients)
<table class="table ticket-table">
    <thead>
        <th width="75"></th>
        <th width="65%">Company</th>
        <th>Clients Name</th>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr class="clickable-row" data-href="{{ url($client->company_slug . '/tickets') }}">
                <td><i class="show-on-hover icon-goto"></i></td>
                <td class="td-adjust">{{ $client->company }}</td>
                <td class="td-adjust">{{ $client->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-warning">There are no clients</div>
@endif
