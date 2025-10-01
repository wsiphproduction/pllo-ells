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
				<div class="col-12 mb-3 d-flex justify-content-between align-items-center">
					<h3 class="form-title text-uppercase">{{ $page->name }}</h3>
					<a href="{{ route('events.create') }}" class="btn btn-success" @if(Auth::user()->role_id != 1) hidden @endif><i class="fa fa-plus">&nbsp;</i> Create New Event</a>

					<!-- filter cluster -->
					<select class="form-select lh-1" id="filter-cluster" style="height: 38px; width: 180px;">
					    <option selected disabled>CLUSTER</option>
					    @foreach($clusters as $cluster)
					    <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
					    @endforeach
					    <option value="0">ALL</option>
					</select>

				</div>

				<div class="col-12 mb-3">


					<div id="portfolio" class="row g-4">

						@php $show_event = 0; @endphp
						@foreach($events as $event)
							@if(Auth::user()->role_id == 1 || App\Models\Custom\Event::isUserInvited(App\Models\Member::where('user_id', Auth::check() ? Auth::id() : 0)->first()->id, $event->id))
								@php $show_event = 1; @endphp
								
								<article class="portfolio-item col-md-6 col-12">
									<div class="card mb-4 p-3 border-0 shadow-sm">
										<div class="row g-0">
											<div class="col-md-4" style="height: 200px;">
												<img src="{{ asset($event->event_img ?? 'theme/addons/images/logos/pllo-logo.png')}}"
													onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
													class="img-fluid rounded-start"
													style="height: 100%; width: 100%; object-fit: contain;"
													alt="Event Image">
											</div>
											
											<div class="col-md-8">
												<div class="card-body">
													<h6 class="card-title mb-2 text-primary fw-bold">{{ $event->title }}</h6>

													<ul class="list-unstyled mb-2 small">
														<li style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;"><i class="bi-diagram-3 me-2"></i>Cluster: {{ $event->cluster->name }}</li>
														<li><i class="bi-calendar-event me-2"></i>Date: {{ \Carbon\Carbon::parse($event->date)->format('Y M d') .' at '. $event->time}}</li>
														<li><i class="bi-geo-alt me-2"></i>{{ $event->location }}</li>
													</ul>

													<p class="card-text small text-muted mb-2" style="
														display: -webkit-box;
														-webkit-line-clamp: 2;
														-webkit-box-orient: vertical;
														overflow: hidden;
														text-overflow: ellipsis;
													">
														{{ $event->description }}
													</p>


													{{-- <p class="card-text small text-muted mb-2">
														{{ $event->description }}
													</p> --}}

													<div class="d-flex justify-content-between align-items-center">
														@if(Auth::user()->role_id != 1)
															@php
																$member = \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0);
															@endphp
															@if(App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id)->status == 1)
																<span class="badge badge-sm bg-success p-1 text-white rounded">CONFIRMED TO JOIN</span>
															@elseif(App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id)->status == 0)
																<span class="badge badge-sm bg-danger p-1 text-white rounded">INVITATION DECLINED</span>
															@else
																<span class="badge badge-sm bg-secondary p-1 text-white rounded">AWAITING CONFIRMATION</span>
															@endif
														@else
															<span class="badge badge-sm bg-transparent p-1 text-white rounded">&nbsp;</span>
														@endif

														<a href="{{ route('events.view', $event->id) }}" class="fw-semibold small text-decoration-none text-primary">
															VIEW <i class="bi-arrow-right-short align-middle"></i>
														</a>
													</div>

												</div>
											</div>
										</div>
									</div>
								</article>

							@endif
						@endforeach

						@if($show_event == 0)
							<div class="promo promo-light p-4 p-md-5 mb-5">
								<div class="row align-items-center">
									<div class="col-12 col-lg">
										<h3 class="text-center">No events yet. Stay tuned!</h3>
									</div>
								</div>
							</div>
						@endif

					</div>

					<div class="d-flex justify-content-center">
						{{ $events->links() }}
					</div>
					
				</div>
			</div>
		</div>

	</section>

	<!-- form filter by designation -->
    <form action="{{ route('events.index') }}" method="get" id="filter-cluster-form">
        <input type="hidden" name="cluster" id="cluster-value-holder">
    </form>

@endsection

@section('pagejs')

<script>
	// filter by designation
	$('#filter-cluster').on('change', function() {
	    let val = $(this).val();
	    $('#cluster-value-holder').val(val);
	    $('#filter-cluster-form').submit();
	});
</script>

@endsection