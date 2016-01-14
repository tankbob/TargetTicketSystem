@if(count($client->services))
	<table class="table ticket-table" id="service-table">
		 <thead>
	        <th>Icon</th>
	        <th>Heading</th>
	        <th>Client</th>
	        <th>URL</th>
	        <th class="text-center">Delete</th>
	    </thead>
	    <tbody>
	    	@foreach($client->services as $service)
	    		<tr id="service-row-{{ $service->id }}">
					<td class="td-adjust text-center">
						<img src="{{ url('img/' . $service->icon) }}?w=73&amp;h=73&amp;fit=max">
					</td>
	                <td class="td-adjust">{{ $service->heading }}</td>
	                <td class="td-adjust">{{ $client->email }}</td>
	                <td class="td-adjust"><a href="{{ $service->link }}">{{ $service->link }}</a></td>
					<td class="td-adjust text-center"><a href="#" class="serviceDelete icon-delete" serviceId="{{ $service->id }}"></a></td>
	            </tr>
	    	@endforeach
	    </tbody>
	</table>
@else
	<div class="alert alert-warning">There are no services for this client</div>
@endif
