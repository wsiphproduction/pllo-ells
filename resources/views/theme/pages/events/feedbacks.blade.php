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

				<div class="col-7 mb-3">
					<table class="table table-hover ">
						<thead class="table-transparent">
							<tr>
								<th>Questions</th>
								<th width="70px" class="text-center"><i class="bi-emoji-laughing text-success text-center fa-2x"></i></th>
								<th width="70px" class="text-center"><i class="bi-emoji-expressionless text-warning text-center fa-2x"></i></th>
								<th width="70px" class="text-center"><i class="bi-emoji-frown text-danger text-center fa-2x"></i></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>How would you rate the over-all quality of the services provided by the PLLO in this activity?</td>
								@for($i=3; $i >= 1; $i--)
									<td class="text-center">{{ App\Models\Custom\EventFeedback::where('event_id', $event->id)->where('q1', $i)->count() }}</td>
								@endfor
							</tr>
							<tr>
								<td>Did you find the facilities and materials provided sufficient and useful?</td>
								@for($i=3; $i >= 1; $i--)
									<td class="text-center">{{ App\Models\Custom\EventFeedback::where('event_id', $event->id)->where('q2', $i)->count() }}</td>
								@endfor
							</tr>
							<tr>
								<td>How would you rate the presentations / discussions?</td>
								@for($i=3; $i >= 1; $i--)
									<td class="text-center">{{ App\Models\Custom\EventFeedback::where('event_id', $event->id)->where('q3', $i)->count() }}</td>
								@endfor
							</tr>
							<tr>
								<td>Was the objective/s of the activity achieved?</td>
								@for($i=3; $i >= 1; $i--)
									<td class="text-center">{{ App\Models\Custom\EventFeedback::where('event_id', $event->id)->where('q4', $i)->count() }}</td>
								@endfor
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col-5 mb-3">
					<table class="table table-hover ">
						<thead class="table-transparent">
							<tr>
								<th>How did you learn about PLLO?</th>
								<th width="70px" class="text-center"><i class="bi-question text-transparent text-center fa-2x"></i></th>
							</tr>
						</thead>
						<tbody>
							@php
								$platforms = ['Google', 'Social Media', 'Friends', 'Advertiesement', 'Others'];
							@endphp
							
							@foreach($platforms as $platform)
								<tr>
									<td>{{ $platform }}</td>
									<td class="text-center">{{ App\Models\Custom\EventFeedback::where('event_id', $event->id)->where('q5', $platform)->count() }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="col-12 mb-3">
					<table class="table table-hover ">
						<thead class="table-transparent">
							<tr>
								<th>Suggestions/Comments</th>
							</tr>
						</thead>
						<tbody>
							@foreach($feedbacks as $feedback)
								@if($feedback->comments)
									<tr>
										<td>{{ $feedback->comments }}</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection