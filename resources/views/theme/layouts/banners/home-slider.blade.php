@php
    $is_video = 0;
    if($page->album->banner_type == 'video'){
        $is_video = 1;
    }
@endphp

<section id="slider" class="slick-wrapper clearfix home-slider-banner" style="min-height: 480px !important;"><!--.include-header-->
	<div class="banner-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12" style="padding:0;">
					<div id="banner" class="home-slider slick-slider">
						@foreach ($page->album->banners as $banner)

							@if($is_video > 0)

							@else
								<div class="hero-slide dark">
									<img src="{{ $banner->image_path }}" alt="{{ $banner->title }}">
									<div class="banner-caption">
										<div class="container">
											<div class="row align-items-center min-vh-100 pt-5 pb-4">
												<div class="col-lg-6 text-start">
													<h1 class="display-3 fw-bolder">{{ $banner->title }}</h1>
													<p class="mt-4 mb-5 fw-light">{{ $banner->description }}</p>

													@if($banner->url && $banner->button_text)
														<a href="{{ $banner->url }}" class="btn text-white rounded-1 py-3 px-5 fw-medium" style="background-color: #053487;">{{ $banner->button_text }}</a>
					                                @endif
													
												</div>
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>