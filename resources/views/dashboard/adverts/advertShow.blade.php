@if(count($client->adverts))
	<table class="table ticket-table" id="banner-table">
		 <thead>
	        <th class="text-center">Thumbnail</th>
	        <th>Advert Name</th>
	        <th>Clients</th>
	        <th class="text-center">Added On</th>
	        <th class="text-center">Delete</th>
	    </thead>
	    <tbody>
	    	@foreach($client->adverts as $advert)
	    		<tr id="banner-row-{{ $advert->id }}">
	                <td class="td-adjust text-center">
						<img src="{{ url('img/' . $advert->image) }}?w=120&amp;h=240&amp;fit=max">
					</td>
	                <td class="td-adjust">{{ $advert->name }}</td>
	                <td class="td-adjust">{{ $client->email }}</td>
	                <td class="td-adjust text-center">{{ date('d/m/y', strtotime($advert->created_at)) }}</td>
					<td class="td-adjust text-center"><a href="#" class="bannerDelete icon-delete" bannerId="{{ $advert->id }}"></a></td>
	            </tr>
	    	@endforeach
	    </tbody>
	</table>
@else
	<div class="alert alert-info">There are no adverts for this client</div>
@endif
