@if(count(auth()->user()->Adverts))
<h4 class="sponsor-title">Featured Ads</h4>
	@foreach(auth()->user()->adverts as $advert)
	<div class="sponsor">
	    <a href="{{ $advert->url }}" target="_blank">
			<img src="{{ 'https://s3-eu-west-1.amazonaws.com/' . config('filesystems.disks.s3.bucket') . '/' . $advert->image }}" alt="{{ $advert->name }}">
	    </a>
	</div>
	@endforeach
@endif
