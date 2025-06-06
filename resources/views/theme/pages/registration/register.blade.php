@extends('theme.main')

@section('pagecss')
<style>
	.form-title {
		margin-bottom: 10px;
		color: #3c5d90;
	}
	.primary-text-color {
		color: #3c5d90;
	}
	.primary-button-color {
		background-color: #3c5d90 !important;
	}
	div#custom-alert {
		width: 99%;
	    height: 100%;
	    position: absolute;
	    background-color: #0000003b;
	    z-index: 999;
	    top: 0;
	}
	div#custom-alert .card.col-4 {
	    transform: translate(0px, 150px);
	}
	#exit-custom-alert {
		min-width: 200px;
		padding: 6px 10px;
		border-radius: 6px;
		border: none;
		font-weight: 600;
		color: white;
		float: right;
	}
	.hide-password {
		position: absolute;
		top: 7px;
		right: 22px;
		opacity: .7;
	}
</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-2"></div>
				<div class="col-8">
					<h3 class="form-title">REGISTRATION</h3>
					<form action="{{ route('register-store') }}" method="post" enctype="multipart/form-data">
						
						<div class="row form-group">
							<div class="col-10">
								<input class="form-control" type="text" name="firstname" placeholder="FIRST NAME" required>
							</div>
							<div class="col-2">
								<input class="form-control" type="text" name="middle_initial" placeholder="M.I." required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-10">
								<input class="form-control" type="text" name="lastname" placeholder="LAST NAME" required>
							</div>
							<div class="col-2">
								<select class="form-select" aria-label="select suffix" name="suffix">
								  <option value="" selected>SUFFIX</option>
								  <option value="Jr">Jr</option>
								  <option value="Sr">Sr</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="email" name="email" placeholder="EMAIL ADDRESS" required autocomplete="off">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="email" name="alt_email" placeholder="ALTERNATIVE EMAIL ADDRESS" required autocomplete="off">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="password" name="password" placeholder="PASSWORD" required>
								<svg class="hide-password" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
								  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
								</svg>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="password" name="confrim_password" placeholder="CONFIRM PASSWORD" required>
								<svg class="hide-password" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
								  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
								</svg>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="text" name="mobile_number" placeholder="MOBILE NUMBER" required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="text" name="other_number" placeholder="DROPDOWN NUMBER" required>
								<small class="primary-text-color float-end pt-1">Add Instant Messaging Number</small>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-6">
								<select class="form-select" aria-label="select gender" name="gender">
								  <option value="" selected>GENDER</option>
								  <option value="MALE">MALE</option>
								  <option value="FEMALE">FEMALE</option>
								</select>
							</div>
							<div class="col-6">
								<input class="form-control" type="date" name="birthdate" placeholder="BIRTHDAY" required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<select class="form-select" aria-label="select system" name="system">
									@foreach($systems as $system)
								  	<option value="{{ $system->id }}">{{ $system->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<select class="form-select" aria-label="select agency" name="agency">
									@foreach($agencies as $agency)
								  	<option value="{{ $agency->id }}">{{ $agency->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="text" name="designation" placeholder="DESIGNATION" required autocomplete="off">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<select class="form-select" multiple aria-label="multiple select example" name="cluster[]">
									@foreach($clusters as $cluster)
								  	<option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
								  	@endforeach
								</select>
							</div>
							<small>Press Control in keyboard and Left Click Mouse for changes and Multi Select. Changes in cluster needs approval.</small>
						</div>

						<div class="row form-group">
							<div class="col-12">

								<input type="text" class="form-control" name="agency_logo_holder" id="agency_logo_holder" placeholder="UPLOAD GOVERNMENT AGENCY LOGO" style="cursor: pointer;">

								<div class="form-control" id="file_container" style="display: none;">
									<span id="file_holder_name">No File.</span>
									<span id="close_file" class="close-file" style="float: right; cursor: pointer;">
										<i class="uil uil-x"></i>
									</span>
								</div>

								<input id="agency_logo" name="agency_logo" type="file" accept=".png, .jpg, .gif" style="display:none;"/>

							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">

								<input type="text" class="form-control" name="office_id_holder" id="office_id_holder" placeholder="UPLOAD OFFICE ID" style="cursor: pointer;">

								<div class="form-control" id="file_container" style="display: none;">
									<span id="file_holder_name">No File.</span>
									<span id="close_file" class="close-file" style="float: right; cursor: pointer;">
										<i class="uil uil-x"></i>
									</span>
								</div>

								<input id="office_id" name="office_id" type="file" accept=".png, .jpg, .gif" style="display:none;"/>

							</div>
						</div>

						<small>By clicking "Register", you agree to the <span class="primary-text-color">Terms and Privacy Policy.</span></small>

						<button type="submit" class="form-control primary-button-color text-white my-3" id="register-submit">REGISTER</button>
						<a href="#" class="btn form-control bg-secondary text-white">LOGIN</a>
						@csrf
					</form>
				</div>
				<div class="col-2"></div>
			</div>
		</div>

		<!-- Custom Alert -->
		@if($message = Session::get('success'))
		<div class="custom-alert" id="custom-alert">
			<div class="row justify-content-center">
				<div class="card col-4">
					<div class="card-header bg-white border-0">
						<h5 class="text-uppercase form-title pt-2 pb-0 mb-0">Registration</h5>
					</div>
					<div class="card-body">
						<p class="mb-0">We have sent an email with a confirmation link to your email address. Please allow 5-10 minutes for this message to arrive.</p>
					</div>
					<div class="card-footer bg-white border-0 py-4">
						<button id="exit-custom-alert" class="primary-button-color">EXIT</button>
					</div>
				</div>	
			</div>
		</div>
		@endif

	</section>
@endsection

@section('pagejs')
<script>

	$(document).ready( function() {

	  $('#file_holder').click(function(){
	    $("#photo").click();
	  });

	});

	$('#photo').change(function() {
	  $('#file_container').show();
	  $('#file_holder_name').text($('#photo')[0].files[0].name);
	  $('#file_holder').hide();
	});

	$('#close_file').click(function(){
	 	$('#file_container').hide();
	  	$('#file_holder').show();
	});

	$('#exit-custom-alert').click(function(){
	    $("#custom-alert").hide();
	  });

</script>
@endsection