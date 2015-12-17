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
						@if(file_exists(public_path() . '/files/services/' . $service->icon))
						<img src="{{ url('files/services/' . $service->icon) }}">
						@endif
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
	<div class="alert alert-info">There are no services for this client</div>
@endif
