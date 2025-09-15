<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="UTF-8">
		<title>PLLO Event Invitation</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			body {
				font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
				background: #f9f9f9;
				margin: 0;
				padding: 0;
			}

			.container {
				max-width: 700px;
				margin: 30px auto;
				background: #ffffff;
				padding: 30px 40px;
			}

			.text-center {
				text-align: center;
			}

			h2, h3 {
				margin: 10px 0;
				font-weight: normal;
			}

			ul {
				padding-left: 20px;
			}

			a {
				color: #0d6efd;
				text-decoration: none;
			}

			.text-primary {
				color: #0d6efd;
			}

			.logo-group img {
				height: 80px;
				margin: 0 10px;
			}

			.btn {
				background-color: #3c5d90;
				color: #fff;
				padding: 10px 20px;
				text-decoration: none;
				display: inline-block;
				margin-top: 30px;
				border-radius: 4px;
			}

			.footer {
				text-align: center;
				font-size: 12px;
				color: #999;
				margin-top: 30px;
				padding: 20px;
				border-top: 1px solid #eee;
			}

			.banner {
				width: 100%;
				max-width: 500px;
				margin: 20px auto;
				display: block;
			}

		</style>
	</head>

	<body>

		<div class="container">

			<div class="text-center logo-group">
                <img src="{{ asset('theme/addons/images/logos/bp-logo.png') }}" alt="BP Logo">
                <img src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" alt="LLS Logo">
                <img src="{{ asset('theme/addons/images/logos/pllo-logo.png') }}" alt="PLLO Logo">
			</div>

			<div class="text-center">
				<h3 style="font-size: 28px;">Legislative Liaison System</h3>
				<h2 style="font-size: 22px; border-top: 1px solid #aaa; padding-top: 10px;">Presidential Legislative Liaison Office</h2>
			</div>

			<p>Hi, {{ $recipient->firstname }}!</p>

			<p>
				Thanks for submitting a feedback for the recent event entitled, 
				<span class="text-primary"><strong>{{ $event['title'] }}</strong></span>.
			</p>

			<p>You can now download the materials, photos, and certificates.</p>

            @php
    			$attachments = json_decode($downloadables?->attachments ?? '[]', true);
				// if($downloadables->attachments){
                // 	$attachments = json_decode($downloadables->attachments, true);
				// }
            @endphp

			@if (!empty($attachments))
				<strong style="font-size:14px;">Post-Activity Downloadable Materials</strong>
				<ul>
                    @foreach ($attachments as $index => $file)
                        <li>
                            <a class="text-primary" href="{{ asset($file) }}" target="_blank" download>
                                Attachment {{ $index + 1 }} : {{ basename($file) }}
                            </a>
                        </li>
                    @endforeach
				</ul>
			@endif

			<br>

            @php
    			$certificate = json_decode($certificates?->attachments ?? '[]', true);
    			$member_id = json_decode($certificates?->member_id ?? '[]', true);
				// if($certificates->attachments){
                // 	$certificate = json_decode($certificates->attachments, true);
				// 	$member_id = json_decode($certificates->member_id ?? [], true);
				// }
            @endphp

			@if (!empty($certificate))
				<strong style="font-size:14px;">Certificates</strong>
				<ul>
					@foreach ($certificate as $index => $file)
						@if(App\Models\Custom\Event::isMemberInSameGroup($member_id[$index]))
							<li>
								<a class="text-primary" href="{{ asset($file) }}" target="_blank" download>
									<strong class="custom-text-primary">{{  \App\Models\Member::getMemberName($member_id[$index]) }} : </strong> {{ basename($file) }}
								</a>
							</li>
						@endif
                    @endforeach
				</ul>
			@endif

			<br><br>

			<div class="text-center">
				{{ QrCode::size(200)->generate(route('events.view', $event->id)) }}
			</div>

			<div class="text-center">
				<a href="{{ route('events.view', $event->id) }}" class="btn">VIEW EVENT</a>
			</div>

			<div class="footer">
				Presidential Legislative Liaison Office <br>
				National Government Center, Quezon City, Philippines <br>
				+63 (02) 1234 5678 | info@pllo.gov.ph
			</div>

		</div>

	</body>

</html>
