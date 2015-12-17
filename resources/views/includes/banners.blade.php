@if(count(auth()->user()->Adverts))
<h4 class="sponsor-title">Featured Ads</h4>
	@foreach(auth()->user()->adverts as $advert)
	<div class="sponsor">
		@if(file_exists(public_path() . 'files/banners/' . $advert->image))
	    <a href="{{ $advert->url }}" target="_blank">
	        <img src="{{ asset('files/banners/' . $advert->image) }}" alt="{{ $advert->name }}">
	    </a>
		@endif
	</div>
	@endforeach
@endif
