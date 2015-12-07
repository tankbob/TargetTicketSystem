<table class="table table-stripped" id="banner-table">
	 <thead>
        <th>Icon</th>
        <th>Heading</th>
        <th>Client</th>
        <th>URL</th>
        <th>Delete</th>
    </thead>
    <tbody>
    	@foreach($client->services as $service)
    		<tr id="service-row-{{ $service->id }}">
                <td><img src="{{ url('files/services/' . $service->icon) }}"></td>
                <td>{{ $service->heading }}</td>
                <td>{{ $client->email }}</td>
                <td><a href="{{ $service->link }}">{{ $service->link }}</a></td>
                <td><a href="#" class="serviceDelete" serviceId="{{ $service->id }}">DELETE ICON</a></td>
            </tr>
    	@endforeach
    </tbody>
</table>
