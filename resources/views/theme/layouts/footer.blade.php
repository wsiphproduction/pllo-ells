@php
    $contents = Setting::getFooter()->contents;

    $socmed = \App\Models\MediaAccounts::all();

    $socmedHTML = '<div class="mt-4 clearfix">';
    	foreach($socmed as $sm){
    		$socmedHTML .= '
    			<a href="'.$sm->media_account.'" class="social-icon si-small si-rounded si-colored si-'.$sm->name.'" title="'.$sm->name.'" target="_blank">
	                <i class="icon-'.$sm->name.'"></i>
	                <i class="icon-'.$sm->name.'"></i>
	            </a>
    		';
    	}

    $socmedHTML .= '</div>';


    $keywords   = ['{Social Media Icons}'];
    $variables  = [$socmedHTML];

    $footerContents = str_replace($keywords,$variables,$contents);

@endphp

<section id="footer-header" style="background-color: #f7f7f7 !important; border-top: 1px solid #e7e7e7; padding-top: 40px; padding-bottom: 25px;" class="no-print">
	<div class="wrapper" style="margin-left: 7%; margin-right: 7%;">
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="d-flex">
					<img src="{{ asset('theme/addons/images/logos/pllo-bp.png') }}" width="160" style="height: 100%; margin-right: 14px;">
					<div>
						<p class="text-fade">
							Our office serves as a bridge between government agencies and stakeholders, ensuring smooth communication and efficient coordination. We are committed to providing transparent, reliable, and timely assistance in addressing government-related concerns.
						</p>
						<br />
						<p class="text-fade">
							<img src="{{ asset('theme/addons/images/logos/fb.png') }}" width="20" style="height: 100%; margin-right: 5px;">
							Stay connected with us for updates and announcements — follow our official Facebook page for the latest news and information.
						</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="row">
					<div class="col-12 col-md-6" style="padding-left: 30px">
						<h4 class="form-title">
							Main Menu
						</h4>
						<div class="row">
							<div class="col-12 col-md-6">
								<ul>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Home
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											About us
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Events
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Position Paper
										</a>
									</li>
									</li>
								</ul>
							</div>
							<div class="col-12 col-md-6">
								<ul>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Report
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Directory
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Crowdsourcing
										</a>
									</li>
									<li class="text-fade list-unstyled d-flex align-items-center">
										<a href="/home" class="text-fade padb-4">
											<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
											  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
											</svg>
											Contact us
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6" style="padding-left: 30px">
						<h4 class="form-title">
							Help
						</h4>
						<div class="row">
							<ul>
								<li class="text-fade list-unstyled d-flex align-items-center">
									<a href="/home" class="text-fade padb-4">
										<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
										  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
										</svg>
										Sitemap
									</a>
								</li>
								<li class="text-fade list-unstyled d-flex align-items-center">
									<a href="/home" class="text-fade padb-4">
										<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
										  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
										</svg>
										Terms and Conditions
									</a>
								</li>
								<li class="text-fade list-unstyled d-flex align-items-center">
									<a href="/home" class="text-fade padb-4">
										<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
										  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
										</svg>
										Privacy Policy
									</a>
								</li>
								<li class="text-fade list-unstyled d-flex align-items-center">
									<a href="/home" class="text-fade padb-4">
										<svg class="mb-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
										  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
										</svg>
										FAQ
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	
<div class="no-print">
{!! $footerContents !!}
</div>


<!-- Subscribe Form modal
============================================= -->

<div class="modal1 mfp-hide" id="modal-subscribe">
	<div class="card mx-auto" style="max-width: 540px;">
		<div class="card-body" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.3)), url('images/misc/subscribe.jpeg') no-repeat center center / cover; padding: 60px 50px; border: 12px solid #FFF">
			<div class="d-flex justify-content-between">
				<h2 class="card-title text-white font-body">Subscribe to our Newsletter!</h2>
			</div>
			<p class="text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum nisi beatae temporibus nobis optio eos?</p>

			<div class="subscribe-widget" data-loader="button">

				<div class="widget-subscribe-form-result"></div>

				<form action="{{route('mailing-list.front.subscribe')}}" role="form" method="post" class="mb-0">
					@csrf
					<label for="subscriber_name" class="text-light">Name <span>*</span></label>
					<input type="text" name="name" id="subscriber_name" class="form-control required not-dark" placeholder="your name" required>

					<label for="subscriber_email" class="text-light">Email Address <span>*</span></label>
					<input type="email" name="email" id="subscriber_email" class="form-control required not-dark" placeholder="name@email.com" required>

					<button class="btn rounded btn-danger py-2 mt-3 w-100 text-uppercase ls1 fw-semibold" type="submit">Subscribe</button>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- Subscribe form end modal -->