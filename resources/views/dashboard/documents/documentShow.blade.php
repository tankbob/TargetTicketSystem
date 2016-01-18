@if(($type == 'seo' && count($client->seoFiles()->get())) || ($type == 'info' && count($client->infoFiles()->get())))
	<table class="table ticket-table" id="document-table">
		 <thead>
	        <th>Title</th>
	        <th>Client</th>
	        <th class="hidden-sm hidden-xs">Date</th>
	        <th class="text-center">Delete</th>
	    </thead>
	    <tbody>
	        @if($type == 'seo')
	        	@foreach($client->seoFiles()->get() as $file)
	        		<tr id="seo-row-{{ $file->id }}">
	                    <td class="td-adjust">{{ $file->filename }}</td>
	                    <td class="td-adjust">{{ $client->company }}</td>
	                    <td class="td-adjust hidden-sm hidden-xs">{{ date('d/m/y', strtotime($file->created_at)) }}</td>
	                    <td class="td-adjust text-center">
							<a href="/document/seo/delete" class="ajax-delete icon-delete" data-type="document" data-contentid="{{ $file->id }}" data-uri="/documents/seo/" data-delrow="#seo-row-{{ $file->id }}"></a>
						</td>
	                </tr>
	        	@endforeach
	        @else
	            @foreach($client->infoFiles()->get() as $file)
	                <tr id="info-row-{{ $file->id }}">
	                    <td class="td-adjust">{{ $file->filename }}</td>
	                    <td class="td-adjust">{{ $client->company }}</td>
	                    <td class="td-adjust hidden-sm hidden-xs">{{ date('d/m/y', strtotime($file->created_at)) }}</td>
	                    <td class="td-adjust text-center">
							<a href="/document/info/delete" class="ajax-delete icon-delete" data-type="document" data-contentid="{{ $file->id }}" data-uri="/documents/info/" data-delrow="#info-row-{{ $file->id }}"></a>
						</td>
	                </tr>
	            @endforeach
	        @endif
	    </tbody>
	</table>
@else
	<div class="alert alert-warning">There are no documents to show</div>
@endif
