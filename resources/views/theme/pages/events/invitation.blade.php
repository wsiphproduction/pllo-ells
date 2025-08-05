@extends('admin.layouts.app')

@section('pagetitle')
    {{ $page->name }}
@endsection

@section('pagecss')
    <link href="{{ asset('css/font-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/et-line.css') }}" rel="stylesheet">
    <link href="{{ asset('css/medical-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/realestate-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/grapesjs/dist/css/grapes.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/assets/css/custom-grapesjs.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/linearicon/css/linearicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tooltip.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/grapesjs-plugin-filestack.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-color-picker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-image-editor.min.css') }}" />

	

	<!-- Custom Blur Backdrop -->
	<style>
	.modal-backdrop.show {
		backdrop-filter: blur(5px);
		background-color: rgba(0, 0, 0, 0.4); /* Optional for dark tint */
	}
	</style>
@endsection

@section('section_header')
	<div class="content-header" style="width: 100%">
		<div class="content-search content-company">
			<img class="mr-2" src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" alt="logo" style="width: 35px;">
			<h3 class="tx-15 mg-b-0">{{ Setting::info()->company_name }} | LEGISLATIVE LIAISON SYSTEM</h3>
		</div>
	</div>
@endsection

@section('content')
	
	<div class="container">
		<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30 mb-5">
			<div>
				<h2 class="mg-b-0 tx-spacing--1 text-primary">{{ $event->title }}</h2><br>
				<h4 class="mg-b-0 tx-spacing--1">{{ $page->name }}</h4>
			</div>
		</div>

		<form id="emailForm" method="post" action="{{ route('events.invitation-update', $event->id) }}" enctype="multipart/form-data">
			@csrf
			<div class="row row-sm">
				<div class="col-lg-3">
					<h6 class="mg-b-0 tx-spacing--1">INSERT CODES</h6>

					<table class="mt-3 table table-hover table-borderless">
						<tr><td class="p-2"><strong style="font-size:14px;">{gender}</strong> <br> <i class="text-secondary">Gender of the Receiver</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{name}</strong> <br> <i class="text-secondary">Name of the Receiver</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{title_event}</strong> <br> <i class="text-secondary">Event Title</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{photo}</strong> <br> <i class="text-secondary">Photo</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{cluster}</strong> <br> <i class="text-secondary">Cluster</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{date}</strong> <br> <i class="text-secondary">Date of the Activity</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{time}</strong> <br> <i class="text-secondary">Time of the Activity</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{venue}</strong> <br> <i class="text-secondary">Venue of the Activity</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{invitation_letter}</strong> <br> <i class="text-secondary">Link of PDF of the Invitation Letter</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{other_materials}</strong> <br> <i class="text-secondary">Link of PDF of Other Materials</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{link_other_materials}</strong> <br> <i class="text-secondary">Link of Other Materials</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{qrcode_invitation}</strong> <br> <i class="text-secondary">QR Code of Event Invitation</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{link_invitation}</strong> <br> <i class="text-secondary">Link of Event Invitation</i></td></tr>
						{{-- <tr><td class="p-2"><strong style="font-size:14px;">{qrcode_form}</strong> <br> <i class="text-secondary">QR Code of Feedback Form</i></td></tr>
						<tr><td class="p-2"><strong style="font-size:14px;">{link_form}</strong> <br> <i class="text-secondary">Link of Feedback Form</i></td></tr> --}}
					</table>
				</div>
				<div class="col-lg-9">
					<div class="form-group">
						<label class="d-block" id="contentLabel">Content *</label>

						<div class="grid h-100 overflow-hidden" id="editor-area">
							<div class="grid-item grid-item--behavior-fixed" style="flex-basis: 275px;margin-left:-275px" id="layers">
								<div class="app-content--sidebar h-100" id="sidebar-inner-1">
									<div class="app-content--sidebar__content scrollbar-container">
										<div class="nav-header">
											<i class="lnr lnr-layers font-20px mr-3"></i>
											<span>Layers</span>
										</div>

										<div class="layer-view overflow-auto">
											<div class="layers-container"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="grid-item position-relative overflow-hidden" id="grapesjs-editor">
								<div class="app-header px-0">
									<div class="position-relative d-flex justify-content-start">
										<button class="gjs-panel-vw" data-toggle="tooltip" data-placement="right" title="Show Layers" id="layers-view-btn" type="button">
											<i class="lnr lnr-chevron-right font-16px"></i>
											<i class="lnr lnr-chevron-left font-16px"></i>
										</button>

										<button class="gjs-panel-add" data-toggle="tooltip" data-placement="bottom" title="Blocks" id="add-blocks-btn" type="button">
											<i class="fa fa-plus font-16px"></i>
										</button>

										<div class="gjs-panel-res gjs-pn-buttons">
											<button type="button" class="btn btn-link btn-hsm device-type mr-1 bg-neutral-first px-0" id="desktop-view" data-toggle="tooltip" data-placement="bottom" title="Desktop" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-screen font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type mr-1 px-0" id="tablet-view" data-toggle="tooltip" data-placement="bottom" title="Tablet" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-tablet font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type px-0" id="mobile-view" data-toggle="tooltip" data-placement="bottom" title="Mobile" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-phone font-16px"></i>
												</span>
											</button>
										</div>
									</div>
									<div class="position-relative d-flex justify-content-start">
										<div class="gjs-panel-tool gjs-pn-buttons">
											<button type="button" class="btn btn-link btn-hsm device-type mr-1 swv" id="sw-visibility" data-toggle="tooltip" data-placement="bottom" title="Show Borders" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-border-style font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type mr-1" id="editor-fullscreen" data-toggle="tooltip" data-placement="bottom" title="Fullscreen" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-expand font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Export" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center" data-toggle="modal" id="export" data-target="#editor-export">
													<i class="lnr lnr-code font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Import" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center" data-toggle="modal" id="export" data-target="#editor-import">
													<i class="lnr lnr-enter-down font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type" id="editor-undo" data-toggle="tooltip" data-placement="bottom" title="Undo" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-undo2 font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type" id="editor-redo" data-toggle="tooltip" data-placement="bottom" title="Redo" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-redo2 font-16px"></i>
												</span>
											</button>

											<button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Clear Canvas" id="canvas-clear" type="button">
												<span class="btn-wrapper--icon d-flex align-items-center">
													<i class="lnr lnr-trash2 font-16px"></i>
												</span>
											</button>
										</div>
										<button class="gjs-panel-vw" data-toggle="tooltip" data-placement="left" title="Show Styles & Properties" id="styles-view-btn" type="button">
											<i class="lnr lnr-chevron-left font-16px"></i>
											<i class="lnr lnr-chevron-right font-16px"></i>
										</button>
									</div>
								</div>
								<div id="gjs">

								</div>

								<!-- Export-modal -->
								<div class="modal fade" id="editor-export" tabindex="-1" role="dialog" aria-labelledby="modal-b4" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h6 class="modal-title" id="modal-title-default">
													<i class="lnr lnr-exit-right"></i>
													Export
												</h6>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
											</div>
											<div class="modal-body row">
												<div class="col-lg-12">
													<ul class="nav nav-line" id="myTab3" role="tablist">
														<li class="nav-item">
															<a class="nav-link" id="html-export-tab" data-toggle="tab" href="#html-export" role="tab" aria-controls="home" aria-selected="true">
																HTML
																<div class="divider"></div>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="css-export-tab" data-toggle="tab" href="#css-export" role="tab" aria-controls="profile" aria-selected="false">
																CSS
																<div class="divider"></div>
															</a>
														</li>
													</ul>

													<div class="tab-content p-2 pb-0">
														<div class="tab-pane fade" id="html-export" role="tabpanel" aria-labelledby="html-export-tab">

														</div>
														<div class="tab-pane fade" id="css-export" role="tabpanel" aria-labelledby="css-export-tab">

														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary ml-auto" id='gjs-export-zip'>
													<i class="lnr lnr-file-zip"></i>
													Export to ZIP
												</button>
											</div>
										</div>
									</div>
								</div>

								<!-- import modal -->
								<div class="modal fade" id="editor-import" tabindex="-1" role="dialog" aria-labelledby="modal-b4" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h6 class="modal-title" id="modal-title-default">
													<i class="lnr lnr-enter-right"></i>
													Import
												</h6>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
											</div>
											<div class="modal-body row">
												<div class="col-lg-12">

												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary ml-auto" id='import-component'>
													<i class="lnr lnr-check"></i>
													Import
												</button>
											</div>
										</div>
									</div>
								</div>

							</div>
							<div class="grid-item grid-item--behavior-fixed h-100" style="flex-basis: 280px;margin-right:-280px" id="styles-or-traits-mgr">
								<div class="nav-header">
									<i class="lnr lnr-palette font-20px mr-3"></i>
									<span>Styles & Properties</span>
								</div>
								<div class="style-view position-relative overflow-auto">
									<div id="selector-mgr">

									</div>
									<div id="traits-mgr">

									</div>
									<div id="styles-mgr">

									</div>
								</div>
							</div>

							<!-- block panel -->
							<div class="panel-blocks">
								<div id="gjsSearch" class="app-content--sidebar__header py-3 panel-blocks-header">
									<div class="grid grid--align-center">
										<div class="grid-item">
											<div class="input-group-container">
												<div id="searchDiv" class="position-relative">
													<input id="searchInputBlk" class="input-group__input--select input-box" type="text" placeholder="Search block" />
												</div>
												<div id="blocksDiv" class="position-relative">
													<select id="block-select" class="input-group__input--select input-box">
														<option value="1" selected>Basic Blocks</option>
														<option value="2">Built-in Blocks</option>
													</select>
													<i class="select-group__icon is-abs--r is-no-pointer icon fa fa-null"></i>
												</div>
											</div>
										</div>
										<div class="grid-item grid-item--behavior-fixed ml-2">
											<button type="button" class="btn btn-block btn-hinfo btn-sm px-2" id="searchBtn">
												<span class="btn-wrapper--icon">
													<i class="lnr lnr-magnifier"></i>
													<i class="lnr lnr-cross2"></i>
												</span>
											</button>
										</div>
									</div>
								</div>

								<div class="blocks-mgr">

								</div>
							</div>
						</div>

						<input type="hidden" name="json" id="json" value="{{ old('json', $event->json) }}">
						<input type="hidden" name="contents" id="contents" value="{{ old('contents', $event->contents) }}">
						<input type="hidden" name="styles" id="styles" value="{{ str_replace(array("'", "&#039;"), "", old('styles', $event->styles) ) }}">

						@error('contents')
							<span class="text-danger">{{ $message }}</span>
						@enderror
						<span class="invalid-feedback" role="alert" id="contentsRequired" style="display: none;">
							<strong>The content field is required</strong>
						</span>
					</div>

					<div class="form-group text-end mt-2">
						<a href="{{ route('events.view', $event->id) }}" class="btn btn-outline-secondary btn-sm btn-uppercase float-right m-1">Cancel</a>
						<input class="btn btn-primary btn-sm btn-uppercase float-right m-1" type="submit" value="Save & Send" onclick="document.getElementById('action').value=this.value;">
						<input class="btn btn-primary btn-sm btn-uppercase float-right m-1" type="submit" value="Save Only" onclick="document.getElementById('action').value=this.value;">
						<input type="hidden" name="action" id="action">
					</div>
				</div>

			</div>
		</form>
	</div>

	
	{{-- SEND EMAIL MODAL --}}

	<div id="sendEmailModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content shadow-lg rounded-4">
				<div class="modal-header bg-light border-0">
					<h5 class="modal-title fw-semibold">
					<i class="bi bi-envelope-paper me-2"></i>Send Invitation Mail?
					</h5>
				</div>
				<div class="modal-body text-center px-4 pb-4">
					<p class="mb-4 text-muted">Choose how you want to proceed the invitation email.</p>
					<div class="d-grid gap-2">
					<button id="sendNowBtn" class="btn btn-primary btn-lg">
						<i class="bi bi-send me-1"></i> Send Now
					</button>
					<button id="customizeBtn" class="btn btn-warning btn-lg text-white">
						<i class="bi bi-pencil-square me-1"></i> Customize
					</button>
					<a href="{{ session('new_event_id') ? route('events.view', session('new_event_id')) : route('events.index') }}" id="laterBtn" class="btn btn-secondary text-white btn-lg" data-bs-dismiss="modal">
						<i class="bi bi-clock me-1"></i> Do It Later
					</a>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection

@section('pagejs')
    <script>
        // jQuery Typing
        (function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);

        $(document).ready( function($){

            $('#icons-filter').typing({
                stop: function (event, $elem) {
                    var filterValue = $elem.val(),
                        count = 0;

                    if( $elem.val() ) {

                        $(".icons-list li").each(function(){
                            if ($(this).text().search(new RegExp(filterValue, "i")) < 0) {
                                $(this).fadeOut();
                            } else {
                                $(this).show();
                                count++
                            }
                        });
                    } else {
                        $(".icons-list li").show();
                    }

                    count = 0;
                },
                delay: 500
            });

        });
    </script>
	
    <script>
        @php
            $jsPage = json_encode(old('json', $event->json));
            echo "var jsPage = $jsPage;\n";
        @endphp
        @if(!old('json', $event->json) || old('json', $event->json) == "null")
            @php
                $jsHtml = old('contents', $event->contents ?? $default['contents']);
                echo "var jsHtml = `$jsHtml`;\n";
                $jsStyle = str_replace(array("'", "&#039;"), "", old('styles', $event->styles ?? $default['styles']) );
                echo "var jsStyle = `$jsStyle`;";
            @endphp
        @endif
    </script>
	
    {{-- <script>
        @php
            $jsPage = json_encode(old('json', $event->json));
            echo "var jsPage = $jsPage;\n";
        @endphp
        @if(!old('json', $event->json) || old('json', $event->json) == "null")
            @php
                $jsHtml = old('contents', $event->contents);
                echo "var jsHtml = `$jsHtml`;\n";
                $jsStyle = str_replace(array("'", "&#039;"), "", old('styles', $event->styles) );
                echo "var jsStyle = `$jsStyle`;";
            @endphp
        @endif
    </script> --}}
    <script src="{{ asset('lib/custom-grapesjs/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/file-upload-validation.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button-2.js') }}"></script>

    <script src="{{ asset('lib/custom-grapesjs/grapesjs/dist/grapes.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-blocks-basic.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-pkurg-bootstrap4-plugin.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-lory-slider.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-touch.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-parser-postcss.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-tooltip.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-tui-image-editor.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-typed.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-style-bg.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/tui-code-snippet.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/tui-color-picker.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-ckeditor.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-export.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-blocks-bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/b4bulder-custom-blocks.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-preset-webpage.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-animation.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-swiper-slider.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/assets/js/custom-grapesjs.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/assets/js/bamburgh.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.0/typed.min.js"></script>


	@if(session('new_event_id'))
		<script>
			$(document).ready(function () {
				$('#sendEmailModal').modal('show');

				// Optional handlers
				$('#sendNowBtn').on('click', function () {
					$('#action').val('Save & Send')
					$('#emailForm').submit();
				});

				$('#customizeBtn').on('click', function () {
					$('#sendEmailModal').modal('hide');
				});
			});
		</script>
	@endif
@endsection

