@if(count($client->files))
	<table class="table ticket-table" id="document-table">
		 <thead>
	        <th>Title</th>
	        <th>Client</th>
	        <th>Date</th>
	        <th class="text-center">Delete</th>
	    </thead>
	    <tbody>
	        @if($type == 'seo')
	        	@foreach($client->seoFiles()->get() as $file)
	        		<tr id="seo-row-{{ $file->id }}">
	                    <td class="td-adjust">{{ $file->filename }}</td>
	                    <td class="td-adjust">{{ $client->company }}</td>
	                    <td class="td-adjust">{{ date('d/m/y', strtotime($file->created_at)) }}</td>
	                    <td class="td-adjust text-center"><a href="#" class="seoDelete icon-delete" fileId="{{ $file->id }}"></a></td>
	                </tr>
	        	@endforeach
	        @else
	            @foreach($client->infoFiles()->get() as $file)
	                <tr id="info-row-{{ $file->id }}">
	                    <td class="td-adjust">{{ $file->filename }}</td>
	                    <td class="td-adjust">{{ $client->company }}</td>
	                    <td class="td-adjust">{{ date('d/m/y', strtotime($file->created_at)) }}</td>
	                    <td class="td-adjust text-center"><a href="#" class="infoDelete icon-delete" fileId="{{ $file->id }}"></a></td>
	                </tr>
	            @endforeach
	        @endif
	    </tbody>
	</table>
@else
	<div class="alert alert-info">There are no documents to show</div>
@endif
