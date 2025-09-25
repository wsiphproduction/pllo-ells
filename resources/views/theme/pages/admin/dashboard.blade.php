@extends('theme.main')

@section('pagecss')
<style>
	.table.table-hover.table-striped.table-bordered thead tr th {
		background-color: #2b3649;
		color: white;
	}
</style>
@endsection

@section('content')
	<section id="admin-dashboard" class="bottommargin-2xl">
		<div class="container">

			<div class="row">

				<h4 class="d-flex align-items-center gap-1 mb-0">
					<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
					  <path d="M5 3a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm14 18a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4ZM5 11a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H5Zm14 2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4Z"/>
					</svg>
					Dashboard
				</h4>

				<div class="row g-3 mt-0">

					<div class="col-md-12">
						<div class="card h-100 shadow">
							<div class="card-header">
								<i class="bi-megaphone"> </i> 
								ANNOUNCEMENTS
							</div>
							<div class="card-body">

								<div class="shadow p-3 mb-3">
									<i class="fa fa-sm bi-circle-fill"> </i> 
									<small>
										The president has requested invited members to join the hearing of FGD ON ANTI-AGRICULTURAL SMUGGLING ACT 2016 this coming April 18, 2023 8:00AM - 12:00PM at Luxent Hotel, Timog Avenue, Quezon CIty.
									</small>
								</div>

								<div class="shadow p-3 mb-3">
									<i class="fa fa-sm bi-circle-fill"> </i> 
									<small>
										System maintenance is scheduled for July 1, 2025 from 1:00AM to 3:00AM. During this time, all services will be temporarily unavailable.
									</small>
								</div>

							</div>
						</div>
					</div>
					
					<div class="col-md-8">
						<div class="card shadow">
							<div class="card-body">

								<div class="col-12">

									<ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="tab-registrations-border-tab" data-bs-toggle="pill" data-bs-target="#registrations-border" type="button" role="tab" aria-controls="tab-registrations-border" aria-selected="false"><small><b>REGISTRATIONS</b></small></button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tab-approved-border-tab" data-bs-toggle="pill" data-bs-target="#approved-border" type="button" role="tab" aria-controls="tab-approved-border" aria-selected="false"><small><b>APPROVED REGISTRATIONS</b></small></button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tab-confirmation-border-tab" data-bs-toggle="pill" data-bs-target="#confirmation-border" type="button" role="tab" aria-controls="tab-confirmation-border" aria-selected="false"><small><b>EMAIL CONFIRMATION</b></small></button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tab-update-border-tab" data-bs-toggle="pill" data-bs-target="#update-border" type="button" role="tab" aria-controls="tab-update-border" aria-selected="false"><small><b>UPDATE REQUESTS</b></small></button>
										</li>
									</ul>

									<div class="tab-content mb-3 relative">

										{{-- REGISTRATIONS TAB --}}
										<div class="tab-pane fade show active" id="registrations-border" role="tabpanel" aria-labelledby="tab-registrations-border-tab" tabindex="0">
											
											<table id="registrationsPendingTable" class="table table-hover table-striped table-bordered">
												<thead class="bg-dark text-white">
												<tr>
													<th width="25%"><b>Email</b></th>
													{{-- <th width="25%"><b>Status</b></th> --}}
													<th width="25%"><b>Date/Time Registered</b></th>
													<th width="25%"><b>Action</b></th>
												</tr>
												</thead>
												<tbody>
													@forelse($registrations_pending as $registration_pending)
														<tr>
															<td>
																<a href="{{ route('register.view.member', $registration_pending->id ) }}" class="cursor-pointer">
																	{{ $registration_pending->email }}
																</a>
																{{-- <a type="button" class="cursor-pointer" data-bs-target="#showDetailsModal{{$registration_pending->user_id}}" data-bs-toggle="modal">
																	{{ $registration_pending->email }}
																</a> --}}
															</td>
															{{-- <td>{{ $registration_pending->is_active ? 'Approved' : 'Pending' }}</td> --}}
															<td>{{ $registration_pending->created_at }}</td>
															<td>
																<button class="btn btn-success text-white mx-2 text-uppercase approve-register-btn" data-id="{{ $registration_pending->user_id }}" data-bs-toggle="modal" data-bs-target="#regApproveModal"  title="Approve this Registration" {{ $registration_pending->is_active ? 'disabled' : '' }}><small>approve</small></button>
																<button class="btn btn-danger text-white mx-2 text-uppercase delete-register-btn" data-id="{{ $registration_pending->user_id }}" data-bs-toggle="modal" data-bs-target="#regDeleteModal" title="Delete this Registration" {{ $registration_pending->is_active ? 'disabled' : '' }}><small>delete</small></button>
															</td>
														</tr>

														<!-- Show Member Details Modal -->
														<div class="modal fade" id="showDetailsModal{{$registration_pending->user_id}}" tabindex="-1" aria-labelledby="showDetailsModalLabel{{$registration_pending->user_id}}" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="showDetailsModalLabel{{$registration_pending->user_id}}">Member Details</h5>
																		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body">
																		<div class="d-flex flex-column">
																			<small class="my-2">
																				<b>Registering As:</b> {{ $registration_pending->userType->name }}	
																			</small>
																			@if(!empty( $registration_pending->designationDetails ))
																				<small class="my-2">
																					<b>For Designation:</b> {{ $registration_pending->designationDetails->name }}
																				</small>
																			@endif
																			<small class="my-2">
																				<b>Name:</b> {{ $registration_pending->name }}	
																			</small>
																			<small class="my-2">
																				<b>Email Address:</b> {{ $registration_pending->email }}	
																			</small>
																			<small class="my-2">
																				<b>Contact Number:</b> {{ $registration_pending->contact_number }}	
																			</small>
																			<small class="my-2">
																				<b>Birthdate:</b> {{ $registration_pending->birthdate }}	
																			</small>
																			<small class="my-2">
																				<b>Gender:</b> @if($registration_pending->gender == 1) Male @elseif($registration_pending->gender == 2) Female @else Others @endif	
																			</small>
																			<br />
																		</div>
																	<div class="modal-footer">
																		<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>

													@empty
														<tr>
															<td colspan="4">No pending registrations found.</td>
														</tr>
													@endforelse

												</tbody>
											</table>

										</div>

										{{-- APPROVED TAB --}}
										<div class="tab-pane fade" id="approved-border" role="tabpanel" aria-labelledby="tab-approved-border-tab" tabindex="0">
											
											<table id="registrationsApproveTable" class="table table-hover table-striped table-bordered">
												<thead class="bg-dark text-white">
												<tr>
													<th><b>Email</b></th>
													<th><b>Approved At</b></th>
												</tr>
												</thead>
												<tbody>
													@forelse($registrations_approve as $registration_approve)
														<tr>
															<td>{{ $registration_approve->email }}</td>
															<td>{{ $registration_approve->updated_at }}</td>
														</tr>
													@empty
														<tr>
															<td colspan="4">No approved registrations found.</td>
														</tr>
													@endforelse

												</tbody>
											</table>

										</div>

										{{-- CONFIRMATIONS TAB --}}
										<div class="tab-pane fade" id="confirmation-border" role="tabpanel" aria-labelledby="tab-confirmation-border-tab" tabindex="0">
											
											<table id="registrationsProcessingTable" class="table table-hover table-striped table-bordered">
												<thead class="bg-dark text-white">
												<tr>
													<th><b>Email</b></th>
													<th><b>Date/Time Registered</b></th>
													<th><b>Action</b></th>
												</tr>
												</thead>
												<tbody>
													@forelse($registrations_process as $registration_process)
														<tr>
															<td>{{ $registration_process->email }}</td>
															<td>{{ $registration_process->updated_at }}</td>
															<td>
																<button class="btn btn-sedcondary mx-2 border resend-email-btn" data-id="{{ $registration_process->user_id }}" data-bs-toggle="modal" data-bs-target="#emailResendModal"  title="Resend Email Confirmation">
																	<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
																	<path d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z"/>
																	<path d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z"/>
																	</svg>
																</button>
															</td>
														</tr>

														<!-- Resend Email Confirmation Modal -->
														<div class="modal fade" id="emailResendModal" tabindex="-1" aria-labelledby="emailResendModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="regApproveModalLabel">Resend Email Confirmation</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																Are you sure you want to resend an email confirmation?
															</div>
															<div class="modal-footer">
																<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																<form method="post" action="{{ route('member.resend.email') }}" enctype="multipart/form-data">
																	@csrf
																	<input type="hidden" name="reg_id" id="reg_id_resend">
																	<button type="submit" class="btn btn-success">Resend</button>
																</form>
															</div>
															</div>
														</div>
														</div>

													@empty
														<tr>
															<td colspan="4">No processing registrations found.</td>
														</tr>
													@endforelse
												</tbody>
											</table>	

										</div>

										{{-- UPDATE REQUESTS TAB --}}
										<div class="tab-pane fade" id="update-border" role="tabpanel" aria-labelledby="tab-update-border-tab" tabindex="0">
											<table id="updateRequestTable" class="table table-hover table-striped table-bordered">
												<thead class="bg-dark text-white">
												<tr>
													<th width="20%"><b>Name</b></th>
													<th width="45%"><b>Modify To</b></th>
													<th width="20%"><b>Date/Time Requested</b></th>
													<th width="15%"><b>Action</b></th>
												</tr>
												</thead>
												<tbody>
													@forelse($cluster_updates as $cluster_update)
														<tr>
															<td>
																<small>{{ $cluster_update->firstname .' '. $cluster_update->lastname }}</small>
															</td>
															@php
																$clusters = explode('::',$cluster_update->cluster );
															@endphp
															<td>
																@foreach($clusters as $cluster)
																<small>
																	{{ \App\Models\ClusterUpdateHolder::getClusterName($cluster)->name }}
																</small>
																<br />
																@endforeach
															</td>
															<td>
																<small>{{ $cluster_update->cls_created_at }}</small>
															</td>
															<td>
																<form action="{{ route('admin.update-request-approve', $cluster_update->member_id) }}" method="post" >
																	@csrf
																	<button class="btn btn-sm btn-success">
																		Approve
																	</button>

																	<input type="hidden" name="data_holder_id" value="{{ $cluster_update->cls_id }}">
																	<input type="hidden" name="cluster" value="{{ $cluster_update->cls_cluster }}">
																	<input type="hidden" name="member_id" value="{{ $cluster_update->member_id }}">

																</form>
															</td>
														</tr>
													@empty
														<tr>
															<td colspan="4">No update request found.</td>
														</tr>
													@endforelse
												</tbody>
											</table>
										</div>

									</div>

								</div>

							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="row g-3">

							<div class="col-md-12">
								<div class="card h-100 shadow">
									<div class="card-header d-flex justify-content-between align-items-center">
										<div>
											<i class="bi-calendar4-event"></i>
											UPCOMING EVENTS
										</div>
										<a href="{{ route('events.index') }}" class="text-decoration-none text-primary">
											<small>Show all</small>
										</a>
									</div>

									<div class="card-body">

										@forelse($upcoming_events as $upcoming_event)

											<div class="d-flex justify-content-between align-items-start mb-4 p-3 border-bottom">
												<div class="d-flex">
													<div class="me-3">
														<i class="bi-calendar-event-fill fs-3 text-dark"></i>
													</div>
													<div>
														<h6 class="mb-1 fw-semibold text-start">{{ $upcoming_event->title }}</h6>
														<small class="text-muted">
															{{ \Carbon\Carbon::parse($upcoming_event->date)->format('F d, Y') }} | {{ $upcoming_event->start_time }} - {{ $upcoming_event->end_time }}
															<br>{{ $upcoming_event->location }}
														</small>
													</div>
												</div>
												<a href="events/view/{{ $upcoming_event->id }}" class="text-decoration-none text-muted">
													<i class="bi-arrow-right-circle fs-5"></i>
												</a>
											</div>
										@empty
											<p>No upcoming events for now.</p>
										@endforelse

									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="card h-100 shadow">
									<div class="card-header">
										<i class="bi-cake"> </i> 
										BIRTHDAY CELEBRANTS THIS MONTH
									</div>
									<div class="card-body">
										@forelse($celebrants as $celebrant)
											<div class="d-flex align-items-center mb-4">
												<img src="{{ asset('/') . $celebrant->photo }}" onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';" class="rounded-circle me-3 border" alt="Avatar" width="50" height="50">
												<div>
													<h6 class="mb-1 fw-semibold text-capitalize">{{ $celebrant->fullName }}</h6>
													<small class="text-muted">{{ $celebrant->birthdate }}</small>
												</div>
											</div>
										@empty
											<p>No celebrants for this month.</p>
										@endforelse
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>

			</div>

		</div>
	</section>

	<!-- Approve Modal -->
	<div class="modal fade" id="regApproveModal" tabindex="-1" aria-labelledby="regApproveModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="regApproveModalLabel">Registration Appproval</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to <span class="text-success">approve</span> this registration?
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<form method="post" action="{{ route('admin.registration.approve') }}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="reg_id_approve" id="reg_id_approve">
					<button type="submit" class="btn btn-success">APPROVE</button>
				</form>
			</div>
			</div>
		</div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="regDeleteModal" tabindex="-1" aria-labelledby="regDeleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="regDeleteModalLabel">Registration Delete</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to <span class="text-danger">delete</span> this registrration?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<form method="post" action="{{ route('admin.registration.approve') }}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="reg_id_delete" id="reg_id_delete">
					<button type="submit" class="btn btn-danger">DELETE</button>
				</form>
			</div>
			</div>
		</div>
	</div>


@endsection

@section('pagejs')
<script>
	$(document).ready( function () {
        jQuery.fn.dataTable.ext.errMode = 'none';

	    $('#registrationsPendingTable').DataTable({
			// addons here
	    });

	    $('#registrationsApproveTable').DataTable({
			// addons here
	    });

	    $('#registrationsProcessingTable').DataTable({
			// addons here
	    });

	    $('#updateRequestTable').DataTable({
			// addons here
	    });
	} );

	$(document).on('click','.resend-email-btn',function(){
	     let id = $(this).attr('data-id');
	     $('#reg_id_resend').val(id);
	});

	$(document).on('click','.approve-register-btn',function(){
	     let id = $(this).attr('data-id');
	     $('#reg_id_approve').val(id);
	});

	$(document).on('click','.delete-register-btn',function(){
	     let id = $(this).attr('data-id');
	     $('#reg_id_delete').val(id);
	});

</script>
@endsection