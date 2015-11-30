<table class="table table-stripped" id="banner-table">
	 <thead>
        <th>Thumbnail</th>
        <th>Advert Name</th>
        <th>Clients</th>
        <th>Added On</th>
        <th>Delete</th>
    </thead>
    <tbody>
    	@foreach($client->adverts as $advert)
    		<tr id="banner-row-{{$advert->id}}">
                <td><img src="/files/banners/{{$advert->image}}"></td>
                <td>{{$advert->name}}</td>
                <td>{{$client->email}}</td>
                <td>{{date('d/m/y', strtotime($advert->created_at))}}</td>
                <td><a href="#" class="bannerDelete" bannerId="{{$advert->id}}">DELETE ICON</a></td>
            </tr>
    	@endforeach
    </tbody>
</table>