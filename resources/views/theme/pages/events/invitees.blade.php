@extends('theme.main')

@section('pagecss')

	<style>
		.bg-custom-primary {
			background-color: #3c5d90 !important;
		}

		.text-custom-primary {
			color: #3c5d90;
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
				<div class="col-12 d-flex justify-content-between align-items-center">
					<h3 class="form-title text-uppercase">{{ $page->name }}</h3>
				</div>
				<div class="col-12 mb-5">
					<p class="text-secondary">{{ $event->title }}</p>
				</div>

				<div class="col-12 mb-3">
					<table class="table table-hover ">
						<thead class="table-primary">
							<tr>
								<th width="100px">PICTURE</th>
								<th>NAME & POSITION</th>
								<th>AGENCY</th>
								<th>CONTACT</th>
								<th>STATUS</th>
							</tr>
						</thead>
						<tbody>
							@forelse($members as $member)
								@if(App\Models\Custom\Event::isUserInvited($member->id, $event->id))
									<tr>
										<td><img src="{{ asset($member->photo) }}" height="70px" onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"></td>
										<td><strong class="text-custom-primary">{{ $member->fullName }}</strong></td>
										<td>{{ App\Models\Agency::getAgencyName($member->agency)->agency_name }}</td>
										<td>
											{{ $member->contact_number }}<br>
											{!! $member->other_number ? $member->other_number . '<br>' : '' !!}
											<a href="javascript:void(0)" class="text-primary">{{ $member->email }}</a>
										</td>
										<td>
											<div class="d-flex align-items-center gap-1">
												<span class="badge badge-sm bg-success p-1 text-white rounded">INVITED</span>
												@if(App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id)->status == 1)
													<span class="badge badge-sm bg-success p-1 text-white rounded">CONFIRMED</span>
												@elseif(App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id) && App\Models\Custom\EventParticipant::hasRepliedInvitation($event->id, $member->id)->status == 0)
													<span class="badge badge-sm bg-danger p-1 text-white rounded">REGRETS</span>
												@else
													<span class="badge badge-sm bg-secondary p-1 text-white rounded">PENDING</span>
												@endif
											</div>
										</td>
									</tr>
								@endif
							@empty
							@endforelse
						</tbody>
					</table>
				</div>

			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection