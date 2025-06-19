@extends('theme.main')

@section('pagecss')

	<style>
		.form-title {
			margin-bottom: 10px;
			color: #3c5d90;
		}

		td {
			font-size: 14px;
		}
		
		a {
			color: #3c5d90;
		}
	</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-12 mb-3">
					<h3 class="form-title text-uppercase">{{ $page->name }}</h3>
				</div>

				<div class="col-12 mb-3">
					
					@forelse($events as $event)

						<div class="col-lg-12 mt-2">
							<div class="p-0 card">
								<div id="oc-testi" class="" data-margin="0" data-pagi="false" data-items="1">
									<div class="oc-item">
										<div class="row g-0 align-items-center">
											<div class="col-md-3 d-flex align-items-center justify-content-center overflow-hidden" style="height:210px;">
												<img src="{{ asset($event->event_img ?? 'theme/addons/images/logos/pllo-logo.png')}}" class="rounded-start" alt="..." style="height: auto; width: auto; object-fit: cover;">
											</div>
											<div class="col-md-8 px-5 py-4 testi-content">
												<h3 class="form-title">{{ $event->title }}</h3>
												<span>{{ $event->description }}</span>
												<br><br>
												<span>{{ $event->location}}</span>
												<br>
												<small class="text-danger">{{ \Carbon\Carbon::parse($event->date)->format('Y M d') .' at '. $event->time}}</small>
											</div>
											<div class="col-md-1">
												<a href="{{ route('events.view', $event->id) }}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

						{{-- <div class="promo promo-light p-4 p-md-5 mb-5">
							<div class="row align-items-center">
								<div class="col-12 col-lg">
									<h3 class="form-title">{{ $event->title }}</h3>
									<span>{{ $event->description }}</span>
									<br>
									<span>{{ $event->location}}</span>
									<br>
									<small class="text-danger">{{ \Carbon\Carbon::parse($event->date)->format('Y M d') .' at '. $event->time}}</small>
								</div>
								<div class="col-12 col-lg-auto mt-4 mt-lg-0">
									<a href="{{ route('events.view', $event->id) }}" class="button button-large button-circle button-black m-0">VIEW</a>
								</div>
							</div>
						</div> --}}
					@empty
						<div class="promo promo-light p-4 p-md-5 mb-5">
							<div class="row align-items-center">
								<div class="col-12 col-lg">
									<h3 class="text-center">No events yet. Stay tuned!</h3>
								</div>
							</div>
						</div>
					@endforelse
					
				</div>
			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection