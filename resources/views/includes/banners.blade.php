@if(count(auth()->user()->Adverts))
<h4 class="sponsor-title">Featured Ads</h4>
	@foreach(auth()->user()->adverts as $advert)
	<div class="sponsor">
	    <a href="{{ $advert->url }}" target="_blank">
			<img src="{{ url('img/' . $advert->image) }}?w=120&amp;h=240&amp;fit=max" alt="{{ $advert->name }}">
	    </a>
	</div>
	@endforeach
@endif
