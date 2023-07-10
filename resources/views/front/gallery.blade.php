@extends('layouts.front')
@section('title','Home')
@section('content')
<main>
	<section class="gallery-page">
		<div class="container">
			<div class="row">
			@if(!is_null($gallery))
				@foreach($gallery as $gk => $gv)
					@if($gv->grid_type == 1)
						<div class="col-lg-3 col-sm-4 col-6">
							<div class="gallery-thumb-wrapper">
								<a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }}" class="html5lightbox" data-group="kb-img-gallery" style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }});">
								</a>
							</div>
						</div>
					@else
						<div class="col-lg-3 col-sm-4 col-6">
							<div class="gallery-thumb-wrapper">
								<a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }}" class="html5lightbox" data-group="kb-img-gallery" style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_one }});">
								</a>
							</div>
						</div>
						<div class="col-lg-3 col-sm-4 col-6">
							<div class="gallery-thumb-wrapper">
								<a href="{{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_two }}" class="html5lightbox" data-group="kb-img-gallery" style="background-image: url({{ Config::get('constants.awsUrl') }}/gallery/{{ $gv->image_two }});">
								</a>
							</div>
						</div>
					@endif
				@endforeach
			@endif
			</div>
		</div>
	</section>

</main>
@endsection