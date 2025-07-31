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

		.selectable-card {
			transition: border 0.2s, box-shadow 0.2s;
		}

		.selectable-card.border-primary {
			box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.5);
		}

	</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-12 mb-1 d-flex justify-content-between align-items-center">
					<div class="row">
						<h3 class="form-title m-0">{{ $page->name }}</h3>

						<ul class="list-unstyled mb-2 small">
							<li class="d-inline-block me-4">
								<i class="bi-diagram-3 me-2"></i>Cluster: {{ $event->cluster->name }}
							</li>
							<li class="d-inline-block me-4">
								<i class="bi-calendar-event me-2"></i>
								Date: {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
							</li>
							<li class="d-inline-block">
								<i class="bi-geo-alt me-2"></i>{{ $event->location }}
							</li>
						</ul>

					</div>

					<div class="btn-group">
						<button type="button" class="btn btn-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Options
						</button>
						<div class="dropdown-menu">

							@if(Auth::check() && $event->created_by == Auth::id())
								<a class="dropdown-item" href="{{ route('events.invitees', $event->id) }}">List of Invitees</a>
								<a class="dropdown-item" href="{{ route('events.feedbacks', $event->id) }}">View Feedbacks</a>
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

						{{-- MODALS --}}
						{{-- REGISTER --}}

						<div class="modal fade" id="registerModal" tabindex="-1">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-body">
										<strong class="custom-text-primary">ACTIVITY REGISTRATION</strong><br>
										<small class="text-muted">Select who will attend on the event (multiple selection).</small>
										
										<form id="registration_form" method="POST" action="{{ route('events.register-event', $event->id) }}">
											<div id="portfolio" class="row g-1 mt-3">
				
												@csrf
												@foreach($members as $member)
													@if(App\Models\Custom\Event::isUserInvited($member->id, $event->id) && App\Models\Custom\Event::isMemberInSameGroup($member->id))
													{{-- @if(App\Models\Custom\Event::isUserInvited($member->id, $event->id)) --}}

														<article class="portfolio-item col-md-6 col-12 member-select" data-member-id="{{ $member->id }}" title="Agency: {{ \App\Models\Agency::getAgencyName($member->agency)->agency_name ?? 'N/A' }}">
															<label class="card mb-0 p-3 border-0 w-100 selectable-card" style="cursor: pointer;" data-agency-id="{{ $member->agency }}">
																
																<input type="checkbox" name="member_id[]" value="{{ $member->id }}" class="d-none">

																<div class="row g-0 align-items-center">
																	<div class="col-md-4 text-center">
																		<img src="{{ asset($member->photo) }}"
																			onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
																			class="img-fluid rounded-circle"
																			style="height: 70px; width: 70px; object-fit: cover;"
																			alt="{{ $member->fullName }}">
																	</div>
																	<div class="col-md-8">
																		<div class="card-body py-0">
																			<h6 class="card-title mb-1 custom-text-primary fw-bold">{{ $member->fullName }}</h6>
																			<span class="small">{{ $member->full_designation_name }}</span>
																		</div>
																	</div>
																</div>
															</label>
														</article>

													@endif
												@endforeach

											</div>

											<div class="row mt-2 mb-4">
												<small class="text-muted mt-5">
													If you want to add a representative to stand in for you as the invited participant,
													<a href="javascript:void(0)" id="add-representative">click here</a>.
												</small>
											</div>

											<div id="representatives-container"></div>

										</form>
									
										<div class="col-12 text-end">
											<button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>
											<button type="submit" class="btn bg-custom-primary text-white mt-3" onclick="return validateSelection();"><small>REGISTER</small></button>
										</div>


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

						
						{{-- FEEDBACK --}}
						@if(Auth::user()->role_id != 1)
							<div class="modal fade" id="feedbackModal" tabindex="-1">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-body">
											<strong class="custom-text-primary">FEEDBACK FORM</strong><br>
											<small class="text-muted">Your feedback helps us improve a better presentations along the way.</small>

											<br><br><br>
											<form class="row me-3" id="feedback-form" method="POST" action="{{ route('events.submit-feedback', $event->id) }}">
											@csrf

												<div class="form-process">
													<div class="css3-spinner">
														<div class="css3-spinner-scaler"></div>
													</div>
												</div>

												{{-- Question 1 --}}
												<div class="col-12">
													<div class="form-group">
														<label>How would you rate the over-all quality of the services provided by the PLLO in this activity?</label>
														<div class="btn-group d-flex" role="group">
															<input type="radio" class="btn-check" name="q1" id="quality-3" value="3">
															<label class="btn btn-outline-success" for="quality-3"><i class="bi-emoji-laughing"></i></label>

															<input type="radio" class="btn-check" name="q1" id="quality-2" value="2">
															<label class="btn btn-outline-warning" for="quality-2"><i class="bi-emoji-expressionless"></i></label>

															<input type="radio" class="btn-check" name="q1" id="quality-1" value="1">
															<label class="btn btn-outline-danger" for="quality-1"><i class="bi-emoji-frown"></i></label>
														</div>
													</div>
												</div>

												{{-- Question 2 --}}
												<div class="col-12">
													<div class="form-group">
														<label>Did you find the facilities and materials provided sufficient and useful?</label>
														<div class="btn-group d-flex" role="group">
															<input type="radio" class="btn-check" name="q2" id="facilities-3" value="3">
															<label class="btn btn-outline-success" for="facilities-3"><i class="bi-emoji-laughing"></i></label>

															<input type="radio" class="btn-check" name="q2" id="facilities-2" value="2">
															<label class="btn btn-outline-warning" for="facilities-2"><i class="bi-emoji-expressionless"></i></label>

															<input type="radio" class="btn-check" name="q2" id="facilities-1" value="1">
															<label class="btn btn-outline-danger" for="facilities-1"><i class="bi-emoji-frown"></i></label>
														</div>
													</div>
												</div>

												{{-- Question 3 --}}
												<div class="col-12">
													<div class="form-group">
														<label>How would you rate the presentations / discussions?</label>
														<div class="btn-group d-flex" role="group">
															<input type="radio" class="btn-check" name="q3" id="presentations-3" value="3">
															<label class="btn btn-outline-success" for="presentations-3"><i class="bi-emoji-laughing"></i></label>

															<input type="radio" class="btn-check" name="q3" id="presentations-2" value="2">
															<label class="btn btn-outline-warning" for="presentations-2"><i class="bi-emoji-expressionless"></i></label>

															<input type="radio" class="btn-check" name="q3" id="presentations-1" value="1">
															<label class="btn btn-outline-danger" for="presentations-1"><i class="bi-emoji-frown"></i></label>
														</div>
													</div>
												</div>

												{{-- Question 4 --}}
												<div class="col-12">
													<div class="form-group">
														<label>Was the objective/s of the activity achieved?</label>
														<div class="btn-group d-flex" role="group">
															<input type="radio" class="btn-check" name="q4" id="objectives-3" value="3">
															<label class="btn btn-outline-success" for="objectives-3"><i class="bi-emoji-laughing"></i></label>

															<input type="radio" class="btn-check" name="q4" id="objectives-2" value="2">
															<label class="btn btn-outline-warning" for="objectives-2"><i class="bi-emoji-expressionless"></i></label>

															<input type="radio" class="btn-check" name="q4" id="objectives-1" value="1">
															<label class="btn btn-outline-danger" for="objectives-1"><i class="bi-emoji-frown"></i></label>
														</div>
													</div>
												</div>

												{{-- Question 5 --}}
												<div class="col-12">
													<div class="form-group">
														<label>How did you learn about PLLO?</label>
														<select class="form-select" name="q5" id="q5" required>
															<option value="" selected disabled>-- SELECT ONE --</option>
															<option value="Google">Google</option>
															<option value="Social Media">Social Media</option>
															<option value="Friends">Friends</option>
															<option value="Advertisement">Advertisement</option>
															<option value="Others">Others</option>
														</select>
													</div>
												</div>

												{{-- Optional Comments --}}
												<div class="col-12 form-group">
													<label>Do you have any other comments / recommendations to improve future activities of the PLLO?</label>
													<textarea name="comments" id="comments" class="form-control" cols="30" rows="8"></textarea>
												</div>

												{{-- Buttons --}}
												<div class="col-12 text-end">
													<button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>
													<button type="submit" class="btn bg-custom-primary text-white mt-3"><small>SUBMIT</small></button>
												</div>

												<input type="hidden" name="event_id" value="{{ $event->id }}"/>
												<input type="hidden" name="member_id" value="{{ $user->id }}"/>

											</form>

										</div>
									</div>
								</div>
							</div>
						@endif

					</div>
				</div>

				<div class="col-3 mt-1">
					<img src="{{ asset($event->event_img)}}" width="100%" onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';" @if(!$event->event_img) hidden @endif>
					
					@if(Auth::check() && $event->created_by == Auth::id())
						<button class="btn form-control mt-2 text-white bg-custom-primary" onclick="$('#uploadDownloadablesModal').modal('show')">UPLOAD DOWNLOADABLES</button>
						<button class="btn form-control mt-2 text-white bg-custom-primary" onclick="$('#uploadCertificatesModal').modal('show')">UPLOAD CERTIFICATES</button>
					@endif
					
					
					@if(Auth::user()->role_id != 1)
						@php
							$member = \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0);
						@endphp

						@if(App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id)->status == 1)
							@if($event->isDone && !$event->hasDoneFeedback($user->id))
								<button class="btn form-control mt-2 text-white bg-custom-primary" onclick="$('#feedbackModal').modal('show')">GIVE FEEDBACK</button>
							@endif
						@endif

						@if(Auth::user()->role_id != 1 && !App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id))
							<button class="btn form-control mt-2 text-white bg-custom-primary" onclick="$('#registerModal').modal('show')">REGISTER NOW</button>
						@endif
					@endif
				</div>
				
				<div class="col-9 mt-1">

					<p>{{ $event->description }}</p>

					<br>
					
					@php
						$attachments = json_decode($event->attachments, true);
					@endphp
					@if (!empty($attachments))
						<strong style="font-size:14px;">Event Materials</strong>

						<div style="padding-left: 0.5rem;">
							<ul class="mb-0 ps-3">
								@foreach ($attachments as $index => $file)
									<li>
										<a class="text-primary" href="{{ asset($file) }}" target="_blank" download>
											Attachment {{ $index + 1 }} : {{ basename($file) }}
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						<br>
					@endif
					
					@php
						$other_links = json_decode($event->other_links, true);
					@endphp
					@if (!empty($other_links))
						<strong style="font-size:14px;">Other Links</strong>

						<div style="padding-left: 0.5rem;">
							<ul class="mb-0 ps-3">
								@foreach ($other_links as $index => $link)
									<li>
										<a class="text-primary" href="{{ $link }}" target="_blank">
											{{ $link }}
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						<br>
					@endif

					@php
						if($downloads){
							$download = json_decode($downloads->attachments ?? [], true);
						}
					@endphp

					@if (!empty($download))
						@if(Auth::user()->role_id == 1 || ($event->isDone && $event->hasDoneFeedback($user->id)))
							<strong style="font-size:14px;">Post-Activity Downloadable Materials</strong>

							<div class="col-12">
								<table>
									@foreach ($download as $index => $file)
										<tr>
											<td>Attachment {{ $index + 1 }} : &nbsp;</td>
											<td><a class="text-primary" href="{{ asset($file) }}" target="_blank" download>{{ basename($file) }}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
											<td @if(Auth::user()->role_id != 1) hidden @endif>
												<ul class="list-unstyled mb-2 small">
													<li class="d-inline-block me-2">
														<a href="javascript:void(0);" onclick="document.getElementById('downloadable_input{{ $index }}').click();" class="btn btn-sm btn-primary">
															<i class="bi-upload"></i>
														</a>
													</li>
													<li class="d-inline-block me-2">
														<a href="javascript:void(0);" onclick="updateDownloadable('downloadable_form{{ $index }}')" class="btn btn-sm btn-danger">
															<i class="bi-trash"></i>
														</a>
													</li>
												</ul>

												<form id="downloadable_form{{ $index }}" action="{{ route('events.update-downloadable', $event->id) }}" method="post" enctype="multipart/form-data" style="display:none;">
													@csrf
													<input id="downloadable_input{{ $index }}" name="attachment[]" type="file" onchange="updateDownloadable('downloadable_form{{ $index }}')">
													<input name="file_index" value="{{ $index }}" type="hidden">
													<input name="type" value="Materials" type="hidden">
												</form>
											</td>
										</tr>
									@endforeach
								</table>
							</div>

							{{-- <div style="padding-left: 0.5rem;">
								<ul class="mb-0 ps-3">
									@foreach ($download as $index => $file)
										<li>
											<a class="text-primary" href="{{ asset($file) }}" target="_blank" download>
												Attachment {{ $index + 1 }} : {{ basename($file) }}
											</a>
										</li>
									@endforeach
								</ul>
							</div>
							<br> --}}
						@endif
					@endif

					@php
						if($certificates){
							$certificate = json_decode($certificates->attachments ?? [], true);
							$member_id = json_decode($certificates->member_id ?? [], true);
						}
					@endphp

					@if (!empty($certificate))
						@if(Auth::user()->role_id == 1 || ($event->isDone && $event->hasDoneFeedback($user->id)))
							<strong style="font-size:14px;">Certificates</strong>

							<div class="col-12">
								<table>
									@foreach ($certificate as $index => $file)
										@if(Auth::user()->role_id == 1 || App\Models\Custom\Event::isMemberInSameGroup($member_id[$index]))
											<tr>
												<td><strong class="custom-text-primary">{{  \App\Models\Member::getMemberName($member_id[$index]) }} : </strong> &nbsp;</td>
												<td><a class="text-primary" href="{{ asset($file) }}" target="_blank" download>{{ basename($file) }}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td @if(Auth::user()->role_id != 1) hidden @endif>
													<ul class="list-unstyled mb-2 small">
														<li class="d-inline-block me-2">
															<a href="javascript:void(0);" onclick="document.getElementById('cert_input{{ $index }}').click();" class="btn btn-sm btn-primary">
																<i class="bi-upload"></i>
															</a>
														</li>
														<li class="d-inline-block me-2">
															<a href="javascript:void(0);" onclick="updateCert('cert_form{{ $index }}')" class="btn btn-sm btn-danger">
																<i class="bi-trash"></i>
															</a>
														</li>
													</ul>

													<form id="cert_form{{ $index }}" action="{{ route('events.update-certificate', $event->id) }}" method="post" enctype="multipart/form-data" style="display:none;">
														@csrf
														<input id="cert_input{{ $index }}" name="attachment[]" type="file" onchange="updateCert('cert_form{{ $index }}')">
														<input name="member_id" value="{{ $member_id[$index] }}" type="hidden">
														<input name="type" value="Certificates" type="hidden">
													</form>
												</td>
											</tr>
										@endif
									@endforeach
								</table>
							</div>
							
						@endif
					@endif

					

					<strong style="font-size:14px;"><a href="{{ route('events.invitees', $event->id) }}">Attendees <i class="bi-arrow-right me-2"></i></a></strong>

					<ul class="list-unstyled mb-2 small">
						<li class="d-inline-block me-4">
							<i class="bi-person me-2"></i>Total Invited: <strong class="custom-text-primary">{{ App\Models\Custom\Event::getInvitedCount($event->id) }}</strong>
						</li>
						<li class="d-inline-block me-4">
							<i class="bi-person me-2"></i>Registered: <strong class="custom-text-primary">{{ $participants->count() }}</strong>
						</li>
						<li class="d-inline-block me-4">
							<i class="bi-person me-2"></i>Pending: <strong class="custom-text-primary">{{ App\Models\Custom\Event::getInvitedCount($event->id) - $participants->count() }}</strong>
						</li>
					</ul>
					<br>

					{{-- @if(Auth::user()->role_id != 1 && !App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0)->id))
						<button class="btn form-control mt-5 text-white bg-custom-primary" onclick="$('#registerModal').modal('show')">REGISTER NOW</button>
					@endif --}}

				</div>

			</div>

			
			<div class="row mt-4">
				<div class="col-12 mb-5">
					<h3 class="form-title">PREVIOUS EVENTS</h3>

					<div id="portfolio" class="row g-4">
						
						@php $show_event = 0; @endphp
						@foreach($events as $prev_event)
							@if(Auth::user()->role_id == 1 || App\Models\Custom\Event::isUserParticipated(App\Models\Member::where('user_id', Auth::check() ? Auth::id() : 0)->first()->id, $prev_event->id))
								@php $show_event = 1; @endphp
								
								<article class="portfolio-item col-md-6 col-12">
									<div class="card mb-4 p-3 border-0 shadow-sm">
										<div class="row g-0">
											<div class="col-md-4" style="height: 200px;">
												<img src="{{ asset($prev_event->event_img ?? 'theme/addons/images/logos/pllo-logo.png')}}"
													onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
													class="img-fluid rounded-start"
													style="height: 100%; width: 100%; object-fit: contain;"
													alt="Event Image">
											</div>
											
											<div class="col-md-8">
												<div class="card-body">
													<h6 class="card-title mb-2 text-primary fw-bold">{{ $prev_event->title }}</h6>

													<ul class="list-unstyled mb-2 small">
														<li style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;"><i class="bi-diagram-3 me-2"></i>Cluster: {{ $prev_event->cluster->name }}</li>
														<li><i class="bi-calendar-event me-2"></i>Date: {{ \Carbon\Carbon::parse($prev_event->date)->format('F d, Y') .' at '. $prev_event->time}}</li>
														<li><i class="bi-geo-alt me-2"></i>{{ $prev_event->location }}</li>
													</ul>

													<p class="card-text small text-muted mb-2" style="
														display: -webkit-box;
														-webkit-line-clamp: 2;
														-webkit-box-orient: vertical;
														overflow: hidden;
														text-overflow: ellipsis;
													">
														{{ $prev_event->description }}
													</p>

													<div class="d-flex justify-content-between align-items-center">
														@if(Auth::user()->role_id != 1)
															@php
																$member = \App\Models\Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0);
															@endphp
															@if(App\Models\Custom\EventParticipant::hasRepliedInvitation($prev_event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($prev_event->id, $member->id)->status == 1)
																<span class="badge badge-sm bg-success p-1 text-white rounded">CONFIRMED TO JOIN</span>
															@elseif(App\Models\Custom\EventParticipant::hasRepliedInvitation($prev_event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($prev_event->id, $member->id)->status == 0)
																<span class="badge badge-sm bg-danger p-1 text-white rounded">INVITATION DECLINED</span>
															@else
																<span class="badge badge-sm bg-secondary p-1 text-white rounded">AWAITING CONFIRMATION</span>
															@endif
														@else
															<span class="badge badge-sm bg-transparent p-1 text-white rounded">&nbsp;</span>
														@endif

														<a href="{{ route('events.view', $prev_event->id) }}" class="fw-semibold small text-decoration-none text-primary">
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
				</div>
			</div>
		</div>

		{{-- MODALS --}}

		{{-- DOWNLOADABLES --}}
		<div class="modal fade" id="uploadDownloadablesModal" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<strong class="custom-text-primary">UPLOAD DOWNLOADABLES</strong><br>

						<div class="row mt-3">
							<form id="downloadables_form" action="{{ route('events.upload-downloadables', $event->id) }}" method="post" enctype="multipart/form-data">
								@csrf

								<div class="form-group">
									<label class="d-block">File</label>
									<input type="file" name="attachments[]" class="form-control @error('attachments') is-invalid @enderror" accept=".pdf, .csv, .xlsx, .xls, .pdf" multiple required>
									<br/>
									@error('attachments')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<input type="hidden" name="type" value="Materials"/>
								<button type="submit" class="btn bg-custom-primary text-white mt-3"><small>SUBMIT</small></button>
								<button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>

							</form>
						</div>
						

					</div>
				</div>
			</div>
		</div>

		{{-- CERTIFICATES --}}
		<div class="modal fade" id="uploadCertificatesModal" tabindex="-1">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-body">
						<strong class="custom-text-primary">UPLOAD CERTIFICATES</strong><br>

						<div class="row mt-3">
							<form id="certificates_form" action="{{ route('events.upload-downloadables', $event->id) }}" method="post" enctype="multipart/form-data">
								@csrf

								@foreach($members as $index => $member)
									@if(App\Models\Custom\Event::isUserParticipated($member->id, $event->id))

										<div class="form-group mb-4">
											<div class="d-flex align-items-center justify-content-between mb-2">
												<div class="d-flex align-items-center">
													<img src="{{ asset($member->photo) }}" alt="Profile" class="rounded-circle me-2"
														style="width: 40px; height: 40px; object-fit: cover;"
														onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';">
													<div>
														<strong>{{ $member->fullName }}</strong><br>
														<small class="text-muted">{{ App\Models\Agency::getAgencyName($member->agency)->agency_name }}</small>
													</div>
												</div>

												<label for="file-upload-{{ $index }}" class="btn btn-outline-primary btn-sm ms-auto mb-0">
													<i class="bi bi-upload me-1"></i> Upload File
												</label>
											</div>

											{{-- HIDDEN --}}
											<input type="hidden" name="member_id[]" value="{{ $member->id }}"/>

											<input type="file" id="file-upload-{{ $index }}" name="attachments[]" class="d-none file-input"
												accept=".pdf, .csv, .xlsx, .xls, .png, .jpg, .jpeg" required>

											<div id="file-name-{{ $index }}" class="small text-secondary mt-1 text-end"></div>

											@error('attachments')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									
									@endif
								@endforeach

								<input type="hidden" name="type" value="Certificates"/>
								<button type="submit" id="submit_certificates_btn" class="btn bg-custom-primary text-white mt-3"><small>SUBMIT</small></button>
								<button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>

							</form>
						</div>
						

					</div>
				</div>
			</div>
		</div>

	</section>
@endsection

@section('pagejs')

	<script>
		const AGENCY_LIMITS = @json($event_agencies->pluck('participant_limit', 'invited'));

		function selectedCountByAgency(agencyId) {
			return document.querySelectorAll(`.selectable-card[data-agency-id="${agencyId}"] input[type="checkbox"]:checked`).length;
		}

		document.querySelectorAll('.selectable-card').forEach(card => {
			card.addEventListener('click', function () {
				const checkbox = this.querySelector('input[type="checkbox"]');
				const willBeChecked = !checkbox.checked;
				const agencyId = parseInt(this.dataset.agencyId);

				if (AGENCY_LIMITS.hasOwnProperty(agencyId)) {
					const limit = parseInt(AGENCY_LIMITS[agencyId]);

					if (limit > 0 && willBeChecked && selectedCountByAgency(agencyId) >= limit) {
						Swal.fire({
							icon: 'warning',
							title: 'Selection limit reached',
							text: `You can only choose up to ${limit} members from this agency.`,
							timer: 2000,
							showConfirmButton: false
						});
						return;
					}
				}
				// Proceed with toggle
				checkbox.checked = willBeChecked;
				this.classList.toggle('border-primary', checkbox.checked);
				this.classList.toggle('border', checkbox.checked);
			});
		});
	</script>

	<script>
		function validateSelection() {
			// Check if at least one member is selected
			if ($('input[name="member_id[]"]:checked').length === 0) {
				Swal.fire({
					icon: 'warning',
					title: 'No member selected',
					text: 'Please select at least one member before submitting.',
					timer: 2000,
					showConfirmButton: false
				});
				return false;
			}

			// Validate dynamically added representative fields
			let hasInvalid = false;
			let hasInvalidEmail = false;

			$('.representative-entry').each(function () {
				const fullname = $(this).find('input[name="fullname[]"]').val()?.trim();
				const designation = $(this).find('input[name="designation[]"]').val()?.trim();
				const email = $(this).find('input[name="email[]"]').val()?.trim();
				const contact = $(this).find('input[name="contact[]"]').val()?.trim();

				if (!fullname || !designation || !email || !contact) {
					hasInvalid = true;
					return false; // exit .each loop early
				}
			});

			if (hasInvalid) {
				Swal.fire({
					icon: 'warning',
					title: 'Incomplete representative info',
					text: 'Please complete all representative fields (Full Name, Designation, Email, Contact).',
					timer: 2500,
					showConfirmButton: false
				});
				return false;
			}

			// Validate representative emails
			document.querySelectorAll('input[name="email[]"]').forEach(function (emailInput) {
				if (!emailInput.checkValidity()) {
					hasInvalidEmail = true;
				}
			});

			if (hasInvalidEmail) {
				Swal.fire({
					icon: 'warning',
					title: 'Invalid email detected',
					text: 'Please check all emails are correct.',
					timer: 2500,
					showConfirmButton: false
				});
				return false;
			}

			// All good – submit the form
			$('#registration_form').submit();
			return false;
		}

	</script>

	<script>
		$(document).ready(function () {
			$('#feedback-form').on('submit', function (e) {
				e.preventDefault(); // Prevent form from submitting

				const q1 = $('input[name="q1"]:checked').val();
				const q2 = $('input[name="q2"]:checked').val();
				const q3 = $('input[name="q3"]:checked').val();
				const q4 = $('input[name="q4"]:checked').val();
				const q5 = $('#q5').val();

				if (!q1 || !q2 || !q3 || !q4 || !q5) {
					Swal.fire({
						icon: 'warning',
						title: 'Missing Answer',
						text: 'Please answer all required questions before submitting.'
					});
					return false;
				}

				this.submit(); // Submit form if all are answered
			});
		});
	</script>

	<script>
		$(document).ready(function () {
			$('#add-representative').on('click', function () {
				const fieldset = `
					<div class="form-group representative-entry mb-3 bg-light p-2">
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-sm btn-transparent text-danger remove-rep">&times; Remove</button>
						</div>
						<div class="row">
							<div class="col-6 mb-2">
								<input class="form-control" type="text" name="fullname[]" placeholder="FULL NAME" required />
							</div>
							<div class="col-6 mb-2">
								<input class="form-control" type="text" name="designation[]" placeholder="DESIGNATION" required />
							</div>
							<div class="col-6 mb-2">
								<input class="form-control" type="email" name="email[]" placeholder="EMAIL ADDRESS" required />
							</div>
							<div class="col-6 mb-2">
								<input class="form-control" type="text" name="contact[]" placeholder="CONTACT NUMBER" required />
							</div>
						</div>
					</div>
				`;
				$('#representatives-container').prepend(fieldset);
			});

			// Remove representative entry
			$(document).on('click', '.remove-rep', function () {
				$(this).closest('.representative-entry').remove();
			});
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			document.querySelectorAll('.file-input').forEach(function (input) {
				input.addEventListener('change', function () {
					const fileNameDisplay = document.getElementById('file-name-' + this.id.split('-').pop());
					fileNameDisplay.textContent = this.files.length ? this.files[0].name : '';
				});
			});
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const submitBtn = document.getElementById('submit_certificates_btn');

			submitBtn.addEventListener('click', function (e) {
				// Prevent default form submission
				e.preventDefault();

				let allFilled = true;
				document.querySelectorAll('.file-input').forEach(function (input) {
					if (!input.value) {
						allFilled = false;
					}
				});

				if (!allFilled) {
					Swal.fire({
						icon: 'warning',
						title: 'Missing File(s)',
						text: 'Please upload a file for each member before submitting.',
					});
					return;
				}

				// If all inputs have values, submit the form
				document.getElementById('certificates_form').submit();
			});
		});
	</script>

	<script>
		function updateCert(formId) {
			Swal.fire({
				title: 'Are you sure?',
				text: 'This will update or remove the certificate.',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					document.getElementById(formId).submit();
				}
			});
		}

		function updateDownloadable(formId) {
			Swal.fire({
				title: 'Are you sure?',
				text: 'This will update or remove the file.',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					document.getElementById(formId).submit();
				}
			});
		}

		// function updateCert(form) {
		// 	document.getElementById(form).submit();
		// }
	</script>
@endsection