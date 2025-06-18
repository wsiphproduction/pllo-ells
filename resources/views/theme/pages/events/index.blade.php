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
						<div class="promo promo-light p-4 p-md-5 mb-5">
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
						</div>
					@empty
						<div class="promo promo-light p-4 p-md-5 mb-5">
							<div class="row align-items-center">
								<div class="col-12 col-lg">
									<h3 class="text-center">No events yet. Stay tuned!</h3>
								</div>
							</div>
						</div>
					@endforelse

					{{-- <table class="table table-hover table-striped">
						<thead>
							<tr>
								<th>Title</th>
								<th>Description</th>
								<th>Cluster</th>
								<th>Schedule</th>
								<th>Venue</th>
								<th>Created by</th>
							</tr>
						</thead>
						<tbody>
							@forelse($events as $event)
								<tr>
									<td>{{ $event->title }}</td>
									<td>{{ $event->description }}</td>
									<td>{{ $event->cluster->name }}</td>
									<td>{{ $event->date }} {{ $event->time }}</td>
									<td>{{ $event->location }}</td>
									<td>{{ $event->created_by }}</td>
								</tr>
							@empty
								<tr>
									<td class="text-center" colspan="100%">No data available.</td>
								</tr>
							@endforelse
						</tbody>
					</table> --}}
				</div>
			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection