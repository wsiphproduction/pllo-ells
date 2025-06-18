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
	</style>
@endsection

@section('content')
	<section id="registration-form">
		<div class="container">
			<div class="row p-4 mb-4">
				<div class="col-12 mb-5">
					<h3 class="form-title">{{ $page->name }}</h3>
				</div>

				<div class="col-12 mt-5 text-center">
					<div class="d-inline-flex justify-content-center align-items-center gap-3">
						<img src="{{ asset('theme/addons/images/logos/bp-logo.png') }}" height="120">
						<img src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" height="120">
						<img src="{{ asset('theme/addons/images/logos/pllo-logo.png') }}" height="120">
					</div>
					
					<h3 class="text-roman text-black m-0" style="font-size: 38px;">Legislative Liaison System</h2>
					<h2 class="text-roman text-black mb-0" style="border-top: 1px solid #a1a1a1;">Presidential Legislative Liaison Office</h3>

					<img src="{{ asset($event->event_img )}}" width="70%">
				</div>

				<div class="col-8 offset-2 mt-5 mb-3">

					<p>Hi, Ferdinand Palaspas!</p>

					<p>
						I have the honor to inform the esteemed Secretaries that the Presidential
						Legislative Liaison Office (PLLO) will conduct a Focus Group Discussion on
						the proposed bill seeking to amend the Republic Act known as 
						<span class="text-primary">{{ $event->title }}</span>.
					</p>

					<div style="padding-left: 0.5rem;">
						<ul class="mb-0 ps-3">
							<li><strong>Cluster</strong>: {{ $event->cluster->name }}</li>
							<li><strong>Date</strong>: {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</li>
							<li><strong>Time</strong>: {{ $event->time }}</li>
							<li><strong>Location</strong>: {{ $event->location }}</li>
						</ul>
					</div>

					<p>You can download the Invitaঞon Leer and other Materials for the event.</p>

					<div style="padding-left: 0.5rem;">
						<ul class="mb-0 ps-3">
							<li><a class="text-primary" href="#">Invitation Letter</a></li>
							<li><a class="text-primary" href="#">Attachment 1</a></li>
							<li><a class="text-primary" href="#">Attachment 2</a></li>
						</ul>
					</div>

					<button class="btn form-control mt-5 text-white bg-custom-primary">REGISTER NOW</button>

				</div>

			</div>
		</div>

	</section>
@endsection

@section('pagejs')
@endsection