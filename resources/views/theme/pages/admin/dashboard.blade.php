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
									<a href="{{ route('admin.dashboard') }}">Registration Approval</a>
								</li>
								<li><a href="#">Profile Approval</a></li>
								<li><a href="#">Agency Approval</a></li>
							</ul>
						</div>
					</div>
				</aside>

				<main class="col-lg-10">
					<div class="table-responsive mx-4">

						<h5 class="mb-3 text-uppercase">Registrations</h5>

						<table id="registrationsTable" class="table table-hover table-striped table-bordered">
							<thead class="bg-dark text-white">
							  <tr>
								<th width="25%"><b>Email</b></th>
								<th width="25%"><b>Status</b></th>
								<th width="25%"><b>Date/Time Registered</b></th>
								<th width="25%"><b>Action</b></th>
							  </tr>
							</thead>
							<tbody>
								@forelse($registrations as $registration)
								  	<tr>
										<td>{{ $registration->email }}</td>
										<td>{{ $registration->is_active ? 'Approved' : 'Pending' }}</td>
										<td>{{ $registration->created_at }}</td>
										<td>
											<button class="btn btn-success text-white mx-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#regApproveModal"  title="Approve this Registration" {{ $registration->is_active ? 'disabled' : '' }}><small>approve</small></button>
											<button class="btn btn-danger text-white mx-2 text-uppercase" data-bs-toggle="modal" data-bs-target="#regDeleteModal" title="Delete this Registration" {{ $registration->is_active ? 'disabled' : '' }}><small>delete</small></button>
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
								  	        	<input type="hidden" name="reg_id_approve" value="{{ $registration->id }}">
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
								  	        	<input type="hidden" name="reg_id_delete" value="{{ $registration->id }}">
								  	        	<button type="submit" class="btn btn-danger">DELETE</button>
								  	        </form>
								  	      </div>
								  	    </div>
								  	  </div>
								  	</div>
								@empty
									<tr>
										<td colspan="4">No registrations found.</td>
								  	</tr>
								@endforelse

							</tbody>
						</table>

					</div>
				</main>

			</div>

		</div>
	</section>


@endsection

@section('pagejs')
<script>
	$(document).ready( function () {
	    $('#registrationsTable').DataTable({
			// addons here
	    });
	} );
</script>
@endsection