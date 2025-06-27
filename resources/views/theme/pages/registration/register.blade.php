@extends('theme.main')

@section('pagecss')
<style>
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
	.select-type-number {
		position: absolute;
	    width: fit-content;
	    border: none;
	    top: 1px;
	    left: 14px;
	}
	#add_messaging:hover {
		color: #005ded;
		text-decoration: underline;
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

					@if($errors->any())
					    <div class="text-danger mb-2">*{{ implode('', $errors->all(':message')) }}</div>
					@endif

					<form action="{{ route('register-store') }}" method="post" enctype="multipart/form-data">
						
						<div class="row form-group">
							<div class="col-10">
								<input class="form-control" type="text" name="firstname" placeholder="FIRST NAME" value="{{ old('firstname') }}" required>
							</div>
							<div class="col-2">
								<input class="form-control" type="text" name="middle_initial" placeholder="M.I." value="{{ old('middle_initial') }}" maxlength="1" required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-10">
								<input class="form-control" type="text" name="lastname" placeholder="LAST NAME" value="{{ old('lastname') }}" required>
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
								<input class="form-control" type="email" name="email" placeholder="EMAIL ADDRESS" value="{{ old('email') }}" required autocomplete="off">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="email" name="alt_email" placeholder="ALTERNATIVE EMAIL ADDRESS" value="{{ old('alt_email') }}" required autocomplete="off">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12 show_hide_password" id="show_hide_password">
								<input class="form-control" id="password" type="password" name="password" placeholder="PASSWORD" required>
								<a id="togglePassword" class="hide-password" style="color: gray; cursor: pointer;"><i class="icon icon-eye-slash" aria-hidden="true"></i></a>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12 show_hide_confirm_password" id="show_hide_confirm_password">
								<input class="form-control"  id="confirmPassword" type="password" name="confrim_password" placeholder="CONFIRM PASSWORD" required>
								<a id="toggleConfirmPassword" class="hide-password" style="color: gray; cursor: pointer;"><i class="icon icon-eye-slash" aria-hidden="true"></i></a>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<input class="form-control" type="text" name="contact_number" placeholder="MOBILE NUMBER" value="{{ old('contact_number') }}" required>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12 relative">
								<select id="select_number_solo" class="form-select select-type-number" aria-label="select type of number" name="type_number[]">
								  	<option value="1">Viber</option>
								  	<option value="2">WhatsApp</option>
								  	<option value="3">Telegram</option>
								  	<option value="4">Signal</option>
								  	<option value="5">WeChat</option>
								</select>
								<input class="form-control" type="text" name="other_number[]" placeholder="" required style="padding-left: 140px;">
								<div id="messaging_container">
									<!-- area for additional fields -->
								</div>
								<small id="add_messaging" class="primary-text-color float-end pt-1 cursor-pointer">Add Instant Messaging Number</small>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-6">
								<select class="form-select" aria-label="select gender" name="gender">
								  	<option value="0">GENDER</option>
									@foreach($genders as $gender)
								  	<option value="{{ $gender->id }}">{{ $gender->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-6 d-flex">
								<select class="form-select" aria-label="select month" name="month" style="width: 70%">
								  	<option value="0">BIRTHMONTH</option>
									@foreach(Config::get('months') as $month)
								  	<option value="{{ $month }}">{{ $month }}</option>
									@endforeach
								</select>
								&nbsp;
								<select class="form-select" aria-label="select day" name="day" style="width: 30%">
								  	<option value="0">BIRTHDAY</option>
									@for($d = 1; $d <= 31; $d++)
								  	<option value="{{ $d }}">{{ $d }}</option>
									@endfor
								</select>
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
									<option value="0">GOVERNMENT AGENCY</option>
									@foreach($agencies as $agency)
								  	<option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<select class="form-select" aria-label="select designation" name="designation">
									<option value="0">DESIGNATION</option>
									@foreach($designations as $designation)
								  	<option value="{{ $designation->id }}">{{ $designation->name }}</option>
									@endforeach
								</select>
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

								<div class="form-control" id="agency_logo_file_container" style="display: none;">
									<span id="agency_logo_file_holder_name">No File.</span>
									<span id="close_agency_logo_file" class="close-file" style="float: right; cursor: pointer;">
										<i class="uil uil-x"></i>
									</span>
								</div>

								<input id="agency_logo" name="agency_logo" type="file" accept=".png, .jpg, .gif" style="display:none;"/>

							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">

								<input type="text" class="form-control" name="office_id_holder" id="office_id_holder" placeholder="UPLOAD OFFICE ID" style="cursor: pointer;">

								<div class="form-control" id="office_id_file_container" style="display: none;">
									<span id="office_id_file_holder_name">No File.</span>
									<span id="close_office_id_file" class="close-file" style="float: right; cursor: pointer;">
										<i class="uil uil-x"></i>
									</span>
								</div>

								<input id="office_id" name="office_id" type="file" accept=".png, .jpg, .gif" style="display:none;"/>

							</div>
						</div>

						<small>By clicking "Register", you agree to the <span class="primary-text-color" style="cursor: pointer;">Terms and Privacy Policy.</span></small>

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

		$('#office_id_holder').click(function(){
			$("#office_id").click();
		});

		$('#agency_logo_holder').click(function(){
			$("#agency_logo").click();
		});

	  	$("#add_messaging").click(function() {
		    var newFieldHtml = `<div style="position: relative; margin-top: 4px;"><select id="select_number" class="form-select select-type-number" aria-label="select type of number" name="type_number[]" style="left: 0px;">
									<option value="1">Viber</option>
								  	<option value="2">WhatsApp</option>
								  	<option value="3">Telegram</option>
								  	<option value="4">Signal</option>
								  	<option value="5">WeChat</option>
								</select>
								<input class="form-control" type="text" name="other_number[]" placeholder="" required style="padding-left: 140px;">
		    					<svg id="remove_new_field" style="position: absolute;right: 12px; top: 12px; cursor: pointer;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
		    					  <path stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
		    					</svg>
								</div>
								`;
		    $("#messaging_container").append(newFieldHtml);
		});

		$('body').on('click', '#remove_new_field', function(e){
			e.preventDefault();
			$(this).parent('div').remove();
		});

		$('#togglePassword').click(function() {
	        var passwordField = $('#password');
	        var toggleButton = $('#togglePassword i');

	        if (passwordField.attr('type') === 'password') {
	            passwordField.attr('type', 'text');
	            toggleButton.removeClass('icon-eye-slash');
	            toggleButton.addClass('icon-eye');
	        } else {
	            passwordField.attr('type', 'password');
	            toggleButton.addClass('icon-eye-slash');
	            toggleButton.removeClass('icon-eye');
	        }
	    });

    	$('#toggleConfirmPassword').click(function() {
            var passwordField = $('#confirmPassword');
            var toggleButton = $('#toggleConfirmPassword i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                toggleButton.removeClass('icon-eye-slash');
                toggleButton.addClass('icon-eye');
            } else {
                passwordField.attr('type', 'password');
                toggleButton.addClass('icon-eye-slash');
                toggleButton.removeClass('icon-eye');
            }
        });

	});

	$('#office_id').change(function() {
	  $('#office_id_file_container').show();
	  $('#office_id_file_holder_name').text($('#office_id')[0].files[0].name);
	  $('#office_id_holder').hide();
	});

	$('#close_office_id_file').click(function(){
	 	$('#office_id_file_container').hide();
	  	$('#office_id_holder').show();
	});

	$('#agency_logo').change(function() {
	  $('#agency_logo_file_container').show();
	  $('#agency_logo_file_holder_name').text($('#agency_logo')[0].files[0].name);
	  $('#agency_logo_holder').hide();
	});

	$('#close_agency_logo_file').click(function(){
	 	$('#agency_logo_file_container').hide(); 
	  	$('#agency_logo_holder').show();
	});

	$('#exit-custom-alert').click(function(){
	    $("#custom-alert").hide();
	});

</script>
@endsection