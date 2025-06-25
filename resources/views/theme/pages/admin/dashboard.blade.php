@extends('theme.main')

@section('pagecss')
<style>

</style>
@endsection

@section('content')
	<section id="admin-dashboard" class="bottommargin-2xl">
		<div class="container">

			<div class="row">
				
				<aside class="sidebar col-lg-2">
					<div class="sidebar-widgets-wrap">

						<div class="widget widget_links">

							<h4 class="d-flex align-items-center gap-2">
								<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
								  <path stroke="currentColor" stroke-width="2" d="M3 11h18m-9 0v8m-8 0h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
								</svg>
								Dashboard
							</h4>
							<ul>
								<li>
									<a href="{{ route('admin.dashboard') }}">Registrations</a>
								</li>
								<li><a href="#">Profiles</a></li>
								<li><a href="#">Agencies</a></li>
							</ul>
						</div>
					</div>
				</aside>

				<main class="col-lg-10">
					<div class="table-responsive mx-4">

						<div class="d-flex align-items-center justify-content-between w-100">
							<h5 class="mb-3 text-uppercase">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
								  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
								</svg>
								Registrations
							</h5>
						</div>

						<table id="registrationsPendingTable" class="table table-hover table-striped table-bordered">
							<thead class="bg-dark text-white">
							  <tr>
								<th width="25%"><b>Email</b></th>
								<th width="25%"><b>Status</b></th>
								<th width="25%"><b>Date/Time Registered</b></th>
								<th width="25%"><b>Action</b></th>
							  </tr>
							</thead>
							<tbody>
								@forelse($registrations_pending as $registration_pending)
								  	<tr>
										<td>{{ $registration_pending->email }}</td>
										<td>{{ $registration_pending->is_active ? 'Approved' : 'Pending' }}</td>
										<td>{{ $registration_pending->created_at }}</td>
										<td>
											<button class="btn btn-success text-white mx-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#regApproveModal"  title="Approve this Registration" {{ $registration_pending->is_active ? 'disabled' : '' }}><small>approve</small></button>
											<button class="btn btn-danger text-white mx-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#regDeleteModal" title="Delete this Registration" {{ $registration_pending->is_active ? 'disabled' : '' }}><small>delete</small></button>
										</td>
								  	</tr>

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
								  	        	<input type="hidden" name="reg_id_approve" value="{{ $registration_pending->user_id }}">
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
								  	        	<input type="hidden" name="reg_id_delete" value="{{ $registration_pending->user_id }}">
								  	        	<button type="submit" class="btn btn-danger">DELETE</button>
								  	        </form>
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

						<div class="col-12 d-flex my-4" style="padding-top: 30px;">
							
							<div class="col-12 col-md-6" style="padding-right: 20px;">
								<h5 class="mb-3 text-uppercase">
									<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
									  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z"/>
									</svg>
									Approved Registrations
								</h5>
								<table id="registrationsApproveTable" class="table table-hover table-striped table-bordered">
									<thead class="bg-dark text-white">
									  <tr>
										<th width="25%"><b>Email</b></th>
										<th width="25%"><b>Approved At</b></th>
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

							<div class="col-12 col-md-6" style="padding-left: 20px;">
								<h5 class="mb-3 text-uppercase">
									<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
									  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
									</svg>
									Email Confirmation Processing
								</h5>
								<table id="registrationsProcessingTable" class="table table-hover table-striped table-bordered">
									<thead class="bg-dark text-white">
									  <tr>
										<th width="25%"><b>Email</b></th>
										<th width="25%"><b>Date/Time Registered</b></th>
									  </tr>
									</thead>
									<tbody>
										@forelse($registrations_process as $registration_process)
										  	<tr>
												<td>{{ $registration_process->email }}</td>
												<td>{{ $registration_process->updated_at }}</td>
										  	</tr>
										@empty
											<tr>
												<td colspan="4">No processing registrations found.</td>
										  	</tr>
										@endforelse

									</tbody>
								</table>	
							</div>
						</div>

					</div>
				</main>

			</div>

		</div>
	</section>


@endsection

@section('pagejs')
<script>
	$(document).ready( function () {
	    $('#registrationsPendingTable').DataTable({
			// addons here
	    });

	    $('#registrationsApproveTable').DataTable({
			// addons here
	    });

	    $('#registrationsProcessingTable').DataTable({
			// addons here
	    });
	} );

</script>
@endsection