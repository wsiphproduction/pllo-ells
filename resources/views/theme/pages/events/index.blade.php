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
					<a href="{{ route('events.create') }}" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i> Create New Event</a>
				</div>

				<div class="col-12 mb-3">
					
					@php $show_event = 0; @endphp
					@foreach($events as $event)
						@if(Auth::user()->role_id == 1 || App\Models\Custom\Event::isUserInvited(App\Models\Member::where('user_id', Auth::check() ? Auth::id() : 0)->first()->id, $event->id))
							@php $show_event = 1; @endphp
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
													<br>
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
													@endif
												</div>
												<div class="col-md-1">
													<a href="{{ route('events.view', $event->id) }}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>

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
			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection