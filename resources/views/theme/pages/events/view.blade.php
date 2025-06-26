@extends('theme.main')

@section('pagecss')

	<style>
		.bg-custom-primary {
			background-color: #3c5d90 !important;
		}

		.form-title {
			margin-bottom: 10px;
			color: #3c5d90;
		}

		td {
			font-size: 14px;
		}

		.text-roman {
			font-family: 'Cinzel', serif !important;
		}
	</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-12 mb-5 d-flex justify-content-between align-items-center">
					<h3 class="form-title m-0">{{ $page->name }}</h3>

					<div class="btn-group">
						<button type="button" class="btn btn-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Options
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{ route('events.invitees', $event->id) }}">List of Invitees</a>

							@if(Auth::check() && $event->created_by == Auth::id())
								<a class="dropdown-item" href="{{ route('events.edit', $event->id) }}">Update Details</a>
								<a class="dropdown-item text-danger bg-transparent" href="#" onclick="$('#cancelModal').modal('show')">Cancel Event</a>
							@endif

							@if(Auth::user()->role_id != 1)
								@if(!App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id))
									<a class="dropdown-item" href="#" @if(Auth::user()->role_id == 1 || !App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id)) onclick="$('#registerModal').modal('show')" @else onclick="$('#repliedModal').modal('show')" @endif>Register Now</a>
									<a class="dropdown-item text-danger bg-transparent" href="#" @if(Auth::user()->role_id == 1 || !App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id)) onclick="$('#declineModal').modal('show')" @else onclick="$('#repliedModal').modal('show')" @endif>Decline Invitation</a>
								@endif
							@endif

						</div>

						<div class="modal fade" id="cancelModal" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body">Are you sure you want to cancel this event?</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
										<form method="POST" action="{{ route('events.cancel-event', $event->id) }}">
										@csrf
											<button class="btn btn-danger">Yes</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="registerModal" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body">Are you sure you want to register in this event?</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
										<form method="POST" action="{{ route('events.register-event', $event->id) }}">
										@csrf
											<button class="btn btn-primary">Yes</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="declineModal" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body">Are you sure you want to decline this event invitation?</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
										<form method="POST" action="{{ route('events.decline-event', $event->id) }}">
										@csrf
											<button class="btn btn-danger">Yes</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="repliedModal" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body">You already answered to this invitation</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="col-12 mt-5 text-center">
					<div class="d-inline-flex justify-content-center align-items-center gap-3">
						<img src="{{ asset('theme/addons/images/logos/bp-logo.png') }}" height="120">
						<img src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" height="120">
						<img src="{{ asset('theme/addons/images/logos/pllo-logo.png') }}" height="120">
					</div>
					
					<h3 class="text-roman text-black m-0" style="font-size: 38px;">Legislative Liaison System</h2>
					<h2 class="text-roman text-black mb-0" style="border-top: 1px solid #a1a1a1;">Presidential Legislative Liaison Office</h3>

					<img src="{{ asset($event->event_img)}}" width="70%" @if(!$event->event_img) hidden @endif>
				</div>

				<div class="col-8 offset-2 mt-5 mb-3">

					<p>Hi, Ferdinand Palaspas!</p>

					<p>
						I have the honor to inform the esteemed Secretaries that the Presidential
						Legislative Liaison Office (PLLO) will conduct a Focus Group Discussion on
						the proposed bill seeking to amend the Republic Act known as 
						<span class="text-primary">{{ $event->title }}</span>.
					</p>

					<div style="padding-left: 0.5rem;">
						<ul class="mb-0 ps-3">
							<li><strong>Cluster</strong>: {{ $event->cluster->name }}</li>
							<li><strong>Date</strong>: {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</li>
							<li><strong>Time</strong>: {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</li>

							<li><strong>Location</strong>: {{ $event->location }}</li>
						</ul>
					</div>

					<br>
					<p>You can download the Invitation Letter and other Materials for the event.</p>

					<div style="padding-left: 0.5rem;">
						<ul class="mb-0 ps-3">
							<li><a class="text-primary" href="#">Invitation Letter</a></li>
							<li><a class="text-primary" href="#">Attachment 1</a></li>
							<li><a class="text-primary" href="#">Attachment 2</a></li>
						</ul>
					</div>

					@if(Auth::user()->role_id != 1 && !App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id))
						<button class="btn form-control mt-5 text-white bg-custom-primary" onclick="$('#registerModal').modal('show')">REGISTER NOW</button>
					@endif

				</div>

			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection