<table class="table table-stripped" id="banner-table">
	 <thead>
        <th>Title</th>
        <th>Client</th>
        <th>Date</th>
        <th>Delete</th>
    </thead>
    <tbody>
        @if($type == 'seo')
        	@foreach($client->seoFiles()->get() as $file)
        		<tr id="seo-row-{{$file->id}}">
                    <td>{{$file->filename}}</td>
                    <td>{{$client->company}}</td>
                    <td>{{date('d/m/y', strtotime($file->created_at))}}</td>
                    <td><a href="#" class="seoDelete" fileId="{{$file->id}}">DELETE ICON</a></td>
                </tr>
        	@endforeach
        @else
            @foreach($client->infoFiles()->get() as $file)
                <tr id="info-row-{{$file->id}}">
                    <td>{{$file->filename}}</td>
                    <td>{{$client->company}}</td>
                    <td>{{date('d/m/y', strtotime($file->created_at))}}</td>
                    <td><a href="#" class="infoDelete" fileId="{{$file->id}}">DELETE ICON</a></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>