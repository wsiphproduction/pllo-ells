@extends('theme.main')

@section('pagecss')

<!-- 7/14/2025 -->
<!-- Style for new date picker on registration -->
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI CSS for the datepicker -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <style>
      /* Customize datepicker appearance */
      .ui-datepicker-year, .ui-datepicker-day {
        display: none;
      }
      .ui-datepicker-month {
        font-weight: bold;
      }
    </style>
<!-- End 7/14/2025 Style for new date picker on registration -->

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

	/*Loading Screen Css*/
    #loadingScreen {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 9999;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: #fff;
    }
    .spinner {
      border: 6px solid #f3f3f3;
      border-top: 6px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-bottom: 15px;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    /*End Loading Screen Css*/
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

					<form action="{{ route('register-store') }}" method="post" enctype="multipart/form-data" id="registration-form-body">
						
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
								<input class="form-control" type="email" name="alt_email" placeholder="ALTERNATIVE EMAIL ADDRESS" value="{{ old('alt_email') }}" required autocomplete="off" required>
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
								<input class="form-control" type="number" name="contact_number" placeholder="MOBILE NUMBER" value="{{ old('contact_number') }}" required>
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
								<input class="form-control" type="number" name="other_number[]" required style="padding-left: 140px;" max="999999999" oninput="if(this.value.length > 9) this.value = this.value.slice(0,9)">
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
								<!-- Birthday -->

									<!-- new birthday -->
									<input type="text" id="datepicker" name="birthdate" class="form-control cursor-pointer" placeholder="BIRTHDAY" autocomplete="off">
									<!-- end new birthday -->

								{{-- <select class="form-select" aria-label="select month" name="month" style="width: 70%">
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
								</select> --}}

								<!-- End Birthday -->
							</div>
						</div>

						<div class="row form-group">
							<div class="col-12">
								<select class="form-select" aria-label="select user type" name="user_type" id="user_type">
									@foreach($user_types as $user_type)
								  	<option value="{{ $user_type->id }}">{{ $user_type->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_agency_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select agency" name="agency" id="agency">
									<option value="0" selected disabled>GOVERNMENT AGENCY</option>

									<div id="pllo_lls_agency_dropdown">
										@foreach($pllo_lls_agencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
										@endforeach
									</div>

									<div id="op_agency_dropdown">
										@foreach($op_agencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->agency_name }}</option>
										@endforeach
									</div>

								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_sub_agency_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select sub agency" name="sub_agency">

									<div id="op_subagency_dropdown">
										@foreach($op_subagencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->name }}</option>
										@endforeach
									</div>

									<div id="cabinet_subagency_dropdown">
										@foreach($cabinet_subagencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->name }}</option>
										@endforeach
									</div>

								</select>
							</div>
						</div>

						<!-- if op proper under op proper chosen then need to select an official -->
						{{-- <div class="row form-group" id="op_proper_official_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select sub agency" name="sub_agency">

									<div id="op_proper_official_dropdown">
										@foreach($op_subagencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->name }}</option>
										@endforeach
									</div>

								</select>
							</div>
						</div> --}}

						<!-- if cabinet member under op proper chosen then need to select an official -->
						{{-- <div class="row form-group" id="cabinet_member_official_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select sub agency" name="sub_agency">

									<div id="cabinet_member_official_dropdown">
										@foreach($op_subagencies as $agency)
									  	<option value="{{ $agency->id }}">{{ $agency->name }}</option>
										@endforeach
									</div>

								</select>
							</div>
						</div> --}}

						<div class="row form-group" id="reg_designation_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select designation" name="designation">
									<option value="0" selected disabled>DESIGNATION</option>

									<div id="designation_lls_dropdown">
										@foreach($designations_lls as $designation_lls)
									  	<option value="{{ $designation_lls->id }}">{{ $designation_lls->name }}</option>
										@endforeach
									</div>

									<div id="designation_senator_dropdown">
										@foreach($designations_senators as $designation_senators)
									  	<option value="{{ $designation_senators->id }}">{{ $designation_senators->name }}</option>
										@endforeach
									</div>

									<div id="designation_hor_dropdown">
										@foreach($designations_hor as $designation_hor)
									  	<option value="{{ $designation_hor->id }}">{{ $designation_hor->name }}</option>
										@endforeach
									</div>

									<div id="designation_op_dropdown">
										@foreach($designations_op as $designation_op)
									  	<option value="{{ $designation_op->id }}">{{ $designation_op->name }}</option>
										@endforeach
									</div>


								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_senators_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select senator" name="senator_id">
									@foreach($senators as $senator)
								  	<option value="{{ $senator->id }}">Sen. {{ $senator->FullName }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_hor_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select hor" name="hor_id">
									@foreach($hors as $hor)
								  	<option value="{{ $hor->id }}">{{ $hor->firstname }} {{ $hor->middle_initial }}@if($hor->middle_initial). @endif {{ $hor->lastname }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_congsec_type_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select congsec type" name="congsec_type" id="congsec_type">
								  	<option value="Senate Committee Secretary">Senate Committee Secretary</option>
								  	<option value="House of Representatives Committee Secretary">House of Representatives Committee Secretary</option>
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_committee_type_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select congsec committee type" name="committee_type" id="committee_type">
								  	<option value="Standing Committee">Standing Committee</option>
								  	<option value="Special Committee">Special Committee</option>
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_standing_committee_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select standing type" name="committee_standing" id="standing_committee_type">
								  	<option value="1">Agrarian Reform</option>
								  	<option value="2">Agriculture and Food</option>
								  	<option value="3">Appropriations</option>
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_special_committee_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select special type" name="committee_special" id="special_committee_type">
								  	<option value="1">Bases Conversion</option>
								  	<option value="2">Food Security</option>
								  	<option value="3">Land Use</option>
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_chairperson_dropdown">
							<div class="col-12">
								<select class="form-select" aria-label="select hor member" name="chairperson" id="chairperson">
									@foreach($hors as $hor)
								  	<option value="{{ $hor->id }}">{{ $hor->firstname }} {{ $hor->middle_initial }}@if($hor->middle_initial). @endif {{ $hor->lastname }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="row form-group" id="reg_cluster_dropdown">
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

								<input type="text" class="form-control" name="agency_logo_holder" id="agency_logo_holder" placeholder="UPLOAD GOVERNMENT AGENCY LOGO" style="cursor: pointer;" required>

								<div class="form-control" id="agency_logo_file_container" style="display: none;">
									<span id="agency_logo_file_holder_name">No File.</span>
									<span id="close_agency_logo_file" class="close-file" style="float: right; cursor: pointer;">
										<i class="uil uil-x"></i>
									</span>
								</div>

								<input id="agency_logo" name="agency_logo" type="file" accept=".png, .jpg, .gif" style="display:none;" required>

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

						<div class="d-flex justify-content-start align-items-center gap-1">
							<input type="checkbox" name="agree_terms" id="agree_terms">
							<small><span id="by_click" style="cursor: pointer;">By clicking "Register"</span>, you agree to the <a href="#" class="primary-text-color" style="cursor: pointer;">Terms and Privacy Policy.</a></small>
						</div>

						<button type="submit" class="form-control primary-button-color text-white my-3" id="register-submit" disabled style="opacity: .7;">REGISTER</button>
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

		<!-- Loading screen -->
		<div id="loadingScreen">
			<div class="spinner"></div>
			<div>Just a moment while we register your account...</div>
		</div>

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
							<input class="form-control" type="number" name="other_number[]" placeholder="" required style="padding-left: 140px;" max="999999999" oninput="if(this.value.length > 9) this.value = this.value.slice(0,9)">
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

  	  // Initialize the datepicker
  	  $('#datepicker').datepicker({
  	    dateFormat: 'mm/dd', // Format to show month and day
  	    changeMonth: true,    // Allow the month to be changed
  	    changeYear: false,    // Disable the year change
  	    showButtonPanel: true, // Show button panel to close the calendar
  	    minDate: null,        // Remove the minimum date restriction (allow previous months)
  	    maxDate: null,        // No maximum date restriction
  	    beforeShow: function(input, inst) {
  	      // Hide the day of the month and year
  	      $(inst.dpDiv).find('.ui-datepicker-year').hide();
  	      $(inst.dpDiv).find('.ui-datepicker-day').hide();
  	    }
  	  });

    	// hide elements on first load of the registration page
        $("#designation_senator_dropdown").hide();
        $("#designation_hor_dropdown").hide();
        $("#designation_op_dropdown").hide();
        $("#op_agency_dropdown").hide();
        $("#cabinet_subagency_dropdown").hide();
				$("#reg_sub_agency_dropdown").hide();
				$("#reg_senators_dropdown").hide();
				$("#reg_hor_dropdown").hide();
				$("#reg_congsec_type_dropdown").hide();
				$("#reg_committee_type_dropdown").hide();
				$("#reg_chairperson_dropdown").hide();
				$("#reg_standing_committee_dropdown").hide();
				$("#reg_special_committee_dropdown").hide();

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

	// Selections depends on user type
    $('#user_type').on('change', function(){
        let user_type = $(this).val();

        if (user_type < 5) {
        	$("#reg_designation_dropdown").show();

        	// lls
        	if (user_type == 1) {
            	$("#designation_lls_dropdown").show();
            	$("#designation_senator_dropdown").hide();
            	$("#designation_hor_dropdown").hide();
            	$("#designation_op_dropdown").hide();
	        		$("#reg_cluster_dropdown").show();
	        		$("#reg_agency_dropdown").show();
	        		$("#pllo_lls_agency_dropdown").show();
		    			$("#op_agency_dropdown").hide();
		    			$("#reg_sub_agency_dropdown").hide();
		    			$("#reg_senators_dropdown").hide();
							$("#reg_hor_dropdown").hide();
							$("#reg_congsec_type_dropdown").hide();
							$("#reg_committee_type_dropdown").hide();
							$("#reg_chairperson_dropdown").hide();
							$("#reg_standing_committee_dropdown").hide();
							$("#reg_special_committee_dropdown").hide();

				$('#agency_logo_holder').attr('placeholder', 'UPLOAD GOVERNMENT AGENCY LOGO');
        	}
        	// senator staff
        	if (user_type == 2) {
        		$("#designation_lls_dropdown").hide();
        		$("#designation_senator_dropdown").show();
        		$("#designation_hor_dropdown").hide();
        		$("#designation_op_dropdown").hide();
        		$("#reg_cluster_dropdown").hide();
        		$("#reg_agency_dropdown").hide();
        		$("#op_agency_dropdown").hide();
	    			$("#reg_sub_agency_dropdown").hide();
	    			$("#reg_senators_dropdown").show();
	    			$("#reg_hor_dropdown").hide();
	    			$("#reg_congsec_type_dropdown").hide();
						$("#reg_committee_type_dropdown").hide();
						$("#reg_chairperson_dropdown").hide();
						$("#reg_standing_committee_dropdown").hide();
						$("#reg_special_committee_dropdown").hide();

    				$('#agency_logo_holder').attr('placeholder', 'UPLOAD SENATE LOGO');
        	}
        	// hor staff
        	if (user_type == 3) {
        		$("#designation_lls_dropdown").hide();
        		$("#designation_senator_dropdown").hide();
        		$("#designation_hor_dropdown").show();
        		$("#designation_op_dropdown").hide();
        		$("#reg_cluster_dropdown").hide();
        		$("#reg_agency_dropdown").hide();
        		$("#op_agency_dropdown").hide();
						$("#reg_sub_agency_dropdown").hide();
	    			$("#reg_senators_dropdown").hide();
	    			$("#reg_hor_dropdown").show();
	    			$("#reg_congsec_type_dropdown").hide();
	    			$("#reg_committee_type_dropdown").hide();
	    			$("#reg_chairperson_dropdown").hide();
	    			$("#reg_standing_committee_dropdown").hide();
						$("#reg_special_committee_dropdown").hide();

				$('#agency_logo_holder').attr('placeholder', 'UPLOAD HREP LOGO');
        	}
        	// op proper
        	if (user_type == 4) {
        		$("#designation_lls_dropdown").hide();
        		$("#designation_senator_dropdown").hide();
        		$("#designation_hor_dropdown").hide();
        		$("#designation_op_dropdown").show();
        		$("#reg_cluster_dropdown").hide();
        		$("#reg_agency_dropdown").show();
        		$("#pllo_lls_agency_dropdown").hide();
        		$("#op_agency_dropdown").show();
        		$("#op_subagency_dropdown").show();
						$("#reg_sub_agency_dropdown").hide();
	    			$("#reg_senators_dropdown").hide();
	    			$("#reg_hor_dropdown").hide();
	    			$("#reg_congsec_type_dropdown").hide();
	    			$("#reg_committee_type_dropdown").hide();
	    			$("#reg_chairperson_dropdown").hide();
	    			$("#reg_standing_committee_dropdown").hide();
						$("#reg_special_committee_dropdown").hide();

				$('#agency_logo_holder').attr('placeholder', 'UPLOAD PHOTO (2X2 Picture with white background)');
        	}
        }
        // pllo
        else if(user_type == 6) {
        	$("#reg_cluster_dropdown").show();
        	$("#reg_designation_dropdown").show();
        	$("#reg_agency_dropdown").show();
        	$("#pllo_lls_agency_dropdown").show();
    			$("#op_agency_dropdown").hide();
					$("#reg_sub_agency_dropdown").hide(); 
					$("#reg_senators_dropdown").hide();
					$("#reg_hor_dropdown").hide();
					$("#reg_congsec_type_dropdown").hide();
					$("#reg_committee_type_dropdown").hide();
					$("#reg_chairperson_dropdown").hide();
					$("#reg_standing_committee_dropdown").hide();
					$("#reg_special_committee_dropdown").hide();

			$('#agency_logo_holder').attr('placeholder', 'UPLOAD PHOTO (2X2 Picture with white background)');
    	}
    	// congressional secretariat
    	else if (user_type == 5) {
    		$("#designation_lls_dropdown").hide();
        $("#reg_designation_dropdown").hide();
    		$("#designation_senator_dropdown").hide();
    		$("#designation_hor_dropdown").hide();
    		$("#designation_op_dropdown").hide();
    		$("#reg_cluster_dropdown").hide();
    		$("#reg_agency_dropdown").hide();
    		$("#pllo_lls_agency_dropdown").hide();
    		$("#op_agency_dropdown").hide();
    		$("#op_subagency_dropdown").hide();
				$("#reg_sub_agency_dropdown").hide();
				$("#reg_senators_dropdown").hide();
				$("#reg_hor_dropdown").hide();
				$("#reg_congsec_type_dropdown").show();
				$("#reg_committee_type_dropdown").show();
				$("#reg_chairperson_dropdown").show();
				$("#reg_standing_committee_dropdown").show();

			$('#agency_logo_holder').attr('placeholder', 'UPLOAD PHOTO (2X2 Picture with white background)');
        } else {
        	$("#reg_designation_dropdown").hide();
        	$("#reg_cluster_dropdown").hide();
        	$("#reg_agency_dropdown").hide();
        	$("#op_agency_dropdown").hide();
					$("#reg_sub_agency_dropdown").hide();
					$("#reg_senators_dropdown").hide();
					$("#reg_hor_dropdown").hide();
					$("#reg_congsec_type_dropdown").hide();
					$("#reg_committee_type_dropdown").hide();
					$("#reg_chairperson_dropdown").hide();
					$("#reg_standing_committee_dropdown").hide();
					$("#reg_special_committee_dropdown").hide();

			$('#agency_logo_holder').attr('placeholder', 'UPLOAD PHOTO (2X2 Picture with white background)');
        }
    });

    // Selections depends on user type
    $('#agency').on('change', function(){
        let agency_type = $(this).val();

        // op proper
        if (agency_type == 9) {
					$("#reg_sub_agency_dropdown").show();
        	$("#op_subagency_dropdown").show();
        	$("#cabinet_subagency_dropdown").hide();
        }

        // cabinet member
        if (agency_type == 10) {
        	$("#reg_sub_agency_dropdown").show();
        	$("#op_subagency_dropdown").hide();
        	$("#cabinet_subagency_dropdown").show();
        }

        // other government agency
        if (agency_type == 11) {
        	$("#reg_sub_agency_dropdown").val('0');
        	$("#reg_sub_agency_dropdown").hide();
        }


    });;

    // Activate Loading Screen
    $('#registration-form-body').submit(function(e) {
    	$("#loadingScreen").css('display', 'flex');
    });

    $('#committee_type').on('change', function(){
        let com_type = $(this).val();

        if (com_type == 'Standing Committee') {
        	$("#reg_standing_committee_dropdown").show();
        	$("#reg_special_committee_dropdown").hide();
        } else {
        	$("#reg_standing_committee_dropdown").hide();
        	$("#reg_special_committee_dropdown").show();
        }

    });

    const agreeChk = document.getElementById("agree_terms");
    const registerBtn = document.getElementById("register-submit");

    agreeChk.addEventListener("change", function () {
      registerBtn.disabled = !this.checked;

      if(agreeChk.checked) {
      	registerBtn.style.opacity = "1";
      } else {
      	registerBtn.style.opacity = ".7";
      }
    });

    const byClick = document.getElementById("by_click");

    byClick.addEventListener("click", function () {
    	agreeChk.checked = !agreeChk.checked;

    	registerBtn.disabled = !registerBtn.disabled;

      if(agreeChk.checked) {
      	registerBtn.style.opacity = "1";
      } else {
      	registerBtn.style.opacity = ".7";
      }
    });

</script>

<!-- 7/14/2025 script for custom datepicker-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI JS for the datepicker -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- End 7/14/2025 script for custom datepicker -->

@endsection