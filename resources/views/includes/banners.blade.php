@if(count(auth()->user()->Adverts))
<h4 class="sponsor-title">Featured Ads</h4>
	@foreach(auth()->user()->Adverts as $advert)
	<div class="sponsor">
	    <a href="{{ $advert->url }}" target="_blank">
	        <img src="{{ asset('files/banners/' . $advert->image) }}" alt="{{ $advert->name }}">
	    </a>
	</div>
	@endforeach
@endif
