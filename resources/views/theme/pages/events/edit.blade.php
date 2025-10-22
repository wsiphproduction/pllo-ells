@extends('theme.main')

@section('pagecss')

	<link rel="stylesheet" href="{{ asset('theme/css/components/select-boxes.css') }}">

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
		textarea {
			all: unset;
			resize: none; /* optional: disables resizing */
		}
	</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-12 mb-3">
					<h3 class="form-title text-uppercase">{{ $page->name }}</h3>
					<p>Create an event and invite members by cluster, by agency, or select members one by one.</p>
				</div>

				<form action="{{ route('events.update', $event->id) }}" method="post" enctype="multipart/form-data">
					@method('put')
					@csrf
					
					<div class="row p-4 mb-4">

						<div class="col-6">

							<h6 class="text-secondary">EVENT DETAILS</h6>
								
							<div class="row form-group">
								<div class="col-12">
									<small class="col-12 text-uppercase">TITLE <span class="text-danger">*</span></small>
									<input class="form-control" type="text" name="title" value="{{ $event->title }}" required>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-12">
									<small class="col-12 text-uppercase">DESCRIPTION <span class="text-danger">*</span></small>
									<textarea class="form-control" name="description" style="width: 97%;">{{ $event->description }}</textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12">
									<small class="col-12 text-uppercase">EVENT CLUSTER <span class="text-danger">*</span></small>
									<select name="event_cluster_id" class="form-select" aria-hidden="true" style="width:100%;" required>
										<option selected disabled>-- SELECT CLUSTER --</option>
										@foreach($clusters as $cluster)
											<option value="{{ $cluster->id }}" {{ in_array($cluster->id, (array) json_decode($event->event_cluster_id ?? '[]', true)) ? 'selected' : '' }}>{{ $cluster->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-6">
									<small class="col-12 text-uppercase">EVENT DATE <span class="text-danger">*</span></small>
									<input class="form-control" type="date" name="date" min="{{ \Carbon\Carbon::now()->toDateString() }}" value="{{ $event->date }}" required>
								</div>
								<div class="col-3">
									<small class="col-12 text-uppercase">START TIME <span class="text-danger">*</span></small>
									<input class="form-control" type="time" name="start_time" value="{{ $event->start_time }}" required>
								</div>
								<div class="col-3">
									<small class="col-12 text-uppercase">END TIME <span class="text-danger">*</span></small>
									<input class="form-control" type="time" name="end_time" value="{{ $event->end_time }}" required>
								</div>

								{{-- <div class="col-6">
									<input class="form-control @error('time') error @enderror" type="text" id="time_range" name="time" placeholder="SET TIME (8:00 - 12:00)" value="{{ $event->time }}" readonly>
									@error('time')
										<small class="text-danger">{{ $message }}</small>
									@enderror
								</div> 

								<!-- Hidden native time inputs -->
								<input type="time" id="time_start" value="08:00" hidden>
								<input type="time" id="time_end" value="12:00" hidden> --}}

							</div>
							<div class="row form-group">
								<div class="col-12">
									<small class="col-12 text-uppercase">LOCATION <span class="text-danger">*</span></small>
									<input class="form-control" type="text" name="location" value="{{ $event->location }}" required>
								</div>
							</div>

							<div id="attachments_input" class="row form-group" @if(!is_null($event->attachments)) style="display: none" @endif>
								<small class="col-12 text-uppercase">UPLOAD OTHER MATERIALS</small>
								<div class="col-12">
									<input class="form-control" type="file" name="attachments[]" multiple>
								</div>
							</div>

							<div id="attachments_display" class="form-group row" @if(is_null($event->attachments)) style="display: none" @endif>
								<small class="col-12 text-uppercase">UPLOAD OTHER MATERIALS</small>
								<div class="col-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="bi-paperclip"></i>
											</span>
										</div>
										<input type="text" value="{{ count(json_decode($event->attachments ?? '[]', true)) }} file(s)" class="form-control" readonly>
										<div class="input-group-append">
											<button type="button" class="btn btn-outline-danger" onclick="remove_file('#attachments_display', '#attachments_input')">
												<i class="bi-trash"></i>
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<small class="col-sm-12 text-uppercase">LINK FOR OTHER MATERIALS</small>
								<div class="col-sm-12">
									@php
										$links = json_decode($event->other_links, true) ?? [];
									@endphp

									<select class="select-tags form-select" name="other_links[]" multiple style="width:100%;">
										@foreach ($links as $link)
											<option value="{{ $link }}" selected>{{ $link }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div id="event_img_input" class="row form-group" style="margin-top: -57px; @if(!is_null($event->event_img)) display: none; @endif">
								<small class="col-12 text-uppercase">UPLOAD IMAGE</small>
								<div class="col-12">
									<input class="form-control" type="file" name="event_img" accept=".png, .jpg, .jpeg">
								</div>
							</div>

							<div id="event_img_display" class="form-group row" style="margin-top: -57px; @if(is_null($event->event_img)) display: none; @endif">
								<small class="col-12 text-uppercase">UPLOAD IMAGE</small>
								<div class="col-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="bi-image"></i>
											</span>
										</div>
										<input type="text" value="{{ basename($event->event_img) }}" class="form-control" readonly>
										<div class="input-group-append">
											<button type="button" class="btn btn-outline-danger" onclick="remove_file('#event_img_display', '#event_img_input')">
												<i class="bi-trash"></i>
											</button>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="col-6">

							<h6 class="text-secondary">PARTICIPANTS</h6>
							
							<div class="row form-group">
								<div class="col-12">
									
									<div class="form-group row">
										<small class="col-sm-12 text-uppercase">Cluster</small>
										<div class="col-sm-12">
											<select name="cluster_id[]" class="select-tags form-select" multiple aria-hidden="true" style="width:100%;">
												@foreach($clusters as $cluster)
													<option value="{{ $cluster->id }}" {{ in_array($cluster->id, old('cluster_id', $invitees->where('type', 'cluster')->pluck('invited')->toArray())) ? 'selected' : '' }}>
														{{ $cluster->name }}
													</option>
												@endforeach
											</select>                                                                                                                                                  
										</div>
									</div>

									<div id="agency-container" class="form-group" style="margin-top: -57px;">
										<small class="col-sm-12 text-uppercase">Agency</small> <span class="text-secondary" style="font-size:12px;">(0 value means no limit or free for all agency members)</span>

										@foreach($invitees->where('type', 'agency') as $invited_agency)
											
											<div class="row agency-row" style="margin-top: 10px;">
												<div class="col-sm-10 agency-select d-flex align-items-center gap-2">
													<i class="text-secondary fa fa-times" style="cursor: pointer;" onclick="removeAgencyRow(this)"></i>
													
													<select name="agency_id[]" class="form-select">
														@foreach($agencies as $agency)
															<option value="{{ $agency->id }}"
																{{ in_array($agency->id, (array) json_decode($invited_agency->invited ?? '[]', true)) ? 'selected' : '' }}>
																{{ $agency->agency_name }}
															</option>
														@endforeach
													</select>
												</div>

												<div class="col-sm-2 participant-limit">
													<input class="form-control" name="participant_limit[]" type="number" min="0" onclick="select()" oninput="this.value = this.value || 0;" value="{{ $invited_agency->participant_limit }}" placeholder="LIMIT">
												</div>
											</div>
											
										@endforeach

									</div>

									<div class="form-group row" style="margin-top: -7px;">
										<div class="row mb-1">
											<span class="text-primary text-end" style="font-size:12px; cursor: pointer;" id="add-agency">Add agency selection <i class="fa fa-plus"></i></span>
										</div>
										<div class="col-sm-12 d-flex align-items-center gap-2 flex-wrap">
											<div id="universal-limit-wrapper">
												<input class="form-control" type="number" id="universal-limit" title="Set limit for all" min="0" onclick="select()" oninput="this.value = this.value || 0;" value="0" placeholder="SET LIMIT FOR ALL" style="width:60px;">
											</div>

											<span style="font-size:12px; cursor: pointer;" id="add-agency">Limit for all Agency or select option for different limit per agency</span>

											<select id="limit-mode" class="border-0 bg-transparent p-0 text-primary"
												style="appearance: none; -webkit-appearance: none; box-shadow: none; font-size: 12px;">
												<option class="text-dark" value="all">Set limit for all</option>
												<option class="text-dark" value="per" selected>Set limit per agency</option>
											</select>
										</div>
									</div>

									{{-- <div class="form-group row" style="margin-top: -7px;">
										<div class="row mb-2 ml-2">
											<span class="text-primary" style="font-size:12px; cursor: pointer;" id="add-agency">Add agency selection <i class="fa fa-plus"></i></span>
										</div>
										<div class="col-sm-1" id="universal-limit-wrapper">
											<div class="col-sm-12 agency-select d-flex align-items-center gap-2">
												<input class="" type="number" id="universal-limit" title="Set limit for all" min="0" onclick="select()" oninput="this.value = this.value || 0;" value="0" placeholder="SET LIMIT FOR ALL" style="width:60px;">
											</div>
										</div>
										<div class="col-sm-11">
											<div class="d-inline-flex align-items-center">
												<span class="" style="font-size:12px; cursor: pointer;" id="add-agency">Limit for all Agency or select option for different limit per agency </span>
												<select id="limit-mode" class="border-0 bg-transparent p-0 text-primary" style="appearance: none; -webkit-appearance: none; box-shadow: none; font-size: 12px; margin-left: 10px;">
													<option class="text-dark" value="all">Set limit for all</option>
													<option class="text-dark" value="per" selected>Set limit per agency</option>
												</select>
											</div>
										</div>
									</div> --}}

									<div class="form-group row">
										<small class="col-sm-12 text-uppercase">BY MEMBER</small>
										<div class="col-sm-12">
											<select name="member_id[]" class="select-tags form-select" multiple aria-hidden="true" style="width:100%;">
												@foreach($members as $member)
													<option value="{{ $member->id }}" {{ in_array($member->id, old('member_id', $invitees->where('type', 'member')->pluck('invited')->toArray())) ? 'selected' : '' }}>
														{{ $member->email }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="form-group" style="margin-top: -57px;">
										{{-- <small class="col-12 text-uppercase">UPLOAD INVITATION FILE </small>
										<div class="col-12">
											<input class="form-control" type="file" name="invitation_file" required>
										</div> --}}

										<div id="invitation_file_input" @if(!is_null($event->invitation_file)) style="display: none;" @endif>
											<small class="col-12 text-uppercase">UPLOAD INVITATION FILE </small>
											<div class="col-12">
												<input class="form-control" type="file" name="invitation_file" >
											</div>
										</div>

										<div id="invitation_file_display" class="form-group row" @if(is_null($event->invitation_file)) style="display: none;" @endif>
											<small class="col-12 text-uppercase">UPLOAD INVITATION FILE </small>
											<div class="col-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="bi-envelope"></i>
														</span>
													</div>
													<input type="text" value="{{ basename($event->invitation_file) }}" class="form-control" readonly>
													<div class="input-group-append">
														<button type="button" class="btn btn-outline-danger" onclick="remove_file('#invitation_file_display', '#invitation_file_input')">
															<i class="bi-trash"></i>
														</button>
													</div>
												</div>
											</div>
										</div>



										<small class="col-12" style="font-size:12px;"><span class="text-primary" style="cursor:pointer;" id="open-agency-modal">Click here</span> for different invitation letter per agency (Select first the participants before uploading invitation letter per agency)</small>
										<p class="text-danger mt-2" style="font-size:12px;">Note: You need to reupload the invitation file/s upon updating</p>

										<div class="modal fade" id="agencyModal" tabindex="-1" aria-labelledby="agencyModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title text-uppercase">Upload Invitation Letters per Agency</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body" id="agency-modal-body">
														<!-- Dynamic content will be inserted here -->
													</div>
													<div class="modal-footer">
														<button class="btn btn-sm btn-primary" data-bs-dismiss="modal">SAVE</button>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>

						</div>

						<div class="col-12 text-end mt-2">
							<button class="btn btn-primary">UPDATE</button>
						</div>

					</div>
				</form>
				<div class="col-2"></div>
			</div>
		</div>

	</section>
@endsection

@section('pagejs')
	<script>
		jQuery(document).ready( function(){
			// select Tags
			jQuery(".select-tags").select2({
				tags: true
			});
		});
	</script>
	<script>
		document.getElementById('time_range').addEventListener('click', function () {
			// Create virtual inputs
			const startTime = prompt("Enter start time (HH:MM)", document.getElementById('time_start').value);
			if (!startTime) return;

			const endTime = prompt("Enter end time (HH:MM)", document.getElementById('time_end').value);
			if (!endTime) return;

			// Update hidden inputs
			document.getElementById('time_start').value = startTime;
			document.getElementById('time_end').value = endTime;

			// Display formatted range
			const formatAMPM = (timeStr) => {
				let [hour, minute] = timeStr.split(':').map(Number);
				const ampm = hour >= 12 ? 'PM' : 'AM';
				hour = hour % 12 || 12;
				return `${hour}:${minute.toString().padStart(2, '0')}${ampm}`;
			};

			document.getElementById('time_range').value = `${formatAMPM(startTime)} - ${formatAMPM(endTime)}`;
		});
	</script>
	<script>
		$(document).ready(function () {
			let agencies = @json($agencies);

			$('#add-agency').on('click', function () {
				let agencyOptions = agencies.map(agency => 
					`<option value="${agency.id}">${agency.agency_name}</option>`
				).join('');

				let newRow = `
				<div class="row agency-row" style="margin-top: 10px;">
					<div class="col-sm-12 agency-select d-flex align-items-center gap-2">
						<i class="text-secondary fa fa-times" style="cursor: pointer;" onclick="removeAgencyRow(this)"></i>
						<select name="agency_id[]" class="form-select" required>
							<option selected disabled>SELECT AGENCY</option>
							${agencyOptions}
						</select>
					</div>

					<div class="col-sm-2 participant-limit">
						<input class="form-control" name="participant_limit[]" type="number" min="0" onclick="select()" oninput="this.value = this.value || 0;" value="0" placeholder="LIMIT">
					</div>
				</div>`;

				$('#agency-container').append(newRow);
				applyLimitMode($('#limit-mode').val());
			});

			$('#limit-mode').on('change', function () {
				applyLimitMode(this.value);
			});

			$('#universal-limit').on('input', function () {
				let value = $(this).val();
				$('.participant-limit input').val(value);
			});

			function applyLimitMode(mode) {
				if (mode === 'per') {
					$('#universal-limit-wrapper').hide();
					$('.agency-row').each(function () {
						$(this).find('.agency-select')
							.removeClass('col-sm-12')
							.addClass('col-sm-10');
						$(this).find('.participant-limit').show();
					});
				} else {
					$('#universal-limit-wrapper').show();
					let value = $('#universal-limit').val();
					$('.participant-limit input').val(value);
					$('.agency-row').each(function () {
						$(this).find('.agency-select')
							.removeClass('col-sm-10')
							.addClass('col-sm-12');
						$(this).find('.participant-limit').hide();
					});
				}
			}

			// Apply current mode on load
			applyLimitMode($('#limit-mode').val());
		});
		
		function removeAgencyRow(icon) {
			const row = icon.closest('.agency-row');
			if (row) row.remove();
		}
	</script>
	<script>
		document.getElementById('open-agency-modal').addEventListener('click', function () {
			const selectedAgencies = [];

			document.querySelectorAll('select[name="agency_id[]"]').forEach(select => {
				const selectedOption = select.options[select.selectedIndex];
				if (selectedOption && selectedOption.value) {
					selectedAgencies.push({
						id: selectedOption.value,
						agency_name: selectedOption.text
					});
				}
			});

			let modalBody = '';
			if (selectedAgencies.length > 0) {
				selectedAgencies.forEach((agency, index) => {
					modalBody += `
						<div class="row mb-3 align-items-center">
							<div class="col-md-5">
								<strong>${agency.agency_name}</strong>
								<input type="hidden" name="individual_invitation_agency_ids[]" value="${agency.id}">
							</div>
							<div class="col-md-7">
								<input type="file" class="form-control" name="individual_invitation_file[${agency.id}]">
							</div>
						</div>
					`;
				});
			} else {
				modalBody = `<p class="text-danger">No agencies selected. Please select agencies first.</p>`;
			}

			document.getElementById('agency-modal-body').innerHTML = modalBody;
			const modal = new bootstrap.Modal(document.getElementById('agencyModal'));
			modal.show();
		});
	</script>
	<script>
		function remove_file(remove_div, show_div){
			$(remove_div).hide();
			$(show_div).show();
		}
	</script>

@endsection