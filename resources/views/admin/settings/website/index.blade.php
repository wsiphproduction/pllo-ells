@extends('admin.layouts.app')

@section('pagetitle')
    Website Settings
@endsection

@section('pagecss')
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
                        <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Website Settings</h4>
            </div>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">Social Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="privacy-tab" data-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false">Data Privacy</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="ecommerce-tab" data-toggle="tab" href="#ecommerce" role="tab" aria-controls="ecommerce" aria-selected="false">Ecommerce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="paynamics-tab" data-toggle="tab" href="#paynamics" role="tab" aria-controls="paynamics" aria-selected="false">Paynamics Accepted Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="false">Third Party Sign-in</a>
                    </li> -->
                </ul>
                <div class="tab-content rounded bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-6 mg-t-15">
                            <form method="POST" action="{{ route('website-settings.update') }}" enctype="multipart/form-data" id="selectForm2" class="parsley-style-1" data-parsley-validate novalidate>
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <div id="company" class="parsley-input">
                                        <label>Company Name <span class="tx-danger">*</span></label>
                                        <input type="text" name="company_name" data-toggle="tooltip" data-placement="right" data-title="The company name will appear at the footer of your website" class="form-control" value="{{ old('company_name',$web->company_name) }}" data-parsley-class-handler="#company" required @htmlValidationMessage({{__('standard.empty_all_field')}}) maxlength="150">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="website" class="parsley-input">
                                        <label>Website Name <span class="tx-danger">*</span></label>
                                        <input type="text" name="website_name" data-toggle="tooltip" data-placement="right" data-title="The website name will appear at the login page of your CMS" class="form-control" value="{{ old('website_name',$web->website_name) }}" data-parsley-class-handler="#website" required @htmlValidationMessage({{__('standard.empty_all_field')}}) maxlength="150">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="copyright" class="parsley-input">
                                        <label>Copyright year <span class="tx-danger">*</span></label>
                                        <input required type="text" name="copyright" class="form-control" data-parsley-class-handler="#copyright" value="{{ old('copyright',$web->copyright) }}" @htmlValidationMessage({{__('standard.empty_all_field')}}) maxlength="150">
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('company_logo') ? 'has-error' : '' }}">
                                    <label class="d-block">Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="company_logo" name="company_logo">
                                        <span class="text-danger tx-12">{{ $errors->first('company_logo') }}</span>
                                    </div>
                                    <p class="tx-10">
                                        Maximum file size: 1MB <br /> File extension: PNG, JPG, SVG
                                    </p>
                                    @if(empty($web->company_logo))
                                        <div id="image_div" style="display:none;">
                                            <img src="" id="img_temp" height="100" width="300" alt="Company Logo">  <br /><br />
                                        </div>
                                    @else
                                        <div>
                                            <img src="{{ asset('storage/logos/'.$web->company_logo) }}" id="img_temp" height="100" width="300" alt="Company Logo" style="max-width: 100%;">  <br /><br />
                                            <button type="button" class="btn btn-danger btn-xs btn-uppercase remove-logo" type="button" data-id=""><i data-feather="x"></i> Remove Logo</button>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('web_favicon') ? 'has-error' : '' }}">
                                    <label class="d-block">Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="web_favicon" name="web_favicon" >
                                        <span class="text-danger tx-12">{{ $errors->first('web_favicon') }}</span>
                                    </div>
                                    <p class="tx-10">
                                        Required image dimension: 128px by 128px <br /> Maximum file size: 100KB <br/> File extension: ICO
                                    </p>
                                    @if(empty($web->website_favicon))
                                        <div id="icon_div" style="display:none;">
                                            <img src="" height="50" width="100" id="icon_temp" alt="Website Favicon">  <br /><br />
                                        </div>
                                    @else
                                        <div>
                                            <img src="{{ asset('storage/icons/'.$web->website_favicon) }}" height="50" width="100" id="icon_temp" alt="Website Favicon">  <br /><br />
                                            <button type="button" class="btn btn-danger btn-xs btn-uppercase remove-icon" type="button"><i data-feather="x"></i> Remove Icon</button>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="d-block">Google Analytics Tracking Code</label>
                                    <textarea rows="3" name="g_analytics_code" class="form-control">{{ old('g_analytics_code',$web->google_analytics) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="d-block">Google Map</label>
                                    <textarea rows="6" name="g_map" class="form-control">{{ old('g_map',$web->google_map) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="d-block">Google reCaptcha Code <span class="tx-danger">*</span></label>
                                    <textarea required rows="3" name="g_recaptcha_sitekey" class="form-control" @htmlValidationMessage({{__('standard.empty_all_field')}})>{{ old('g_recaptcha_sitekey',$web->google_recaptcha_sitekey) }}</textarea>
                                </div>

                                <div class="col-lg-12 mg-t-30 ">
                                    <button class="btn btn-primary btn-sm btn-uppercase " type="submit ">Save Settings</button>
                                    <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Contact Tab -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-md-6 mg-t-15">
                            <p class="tx-13 mg-b-40"><i data-feather="zap" class="wd-12"></i><strong> Tip</strong> <br />{{__('standard.settings.website.tip_helper')}}</p>
                            <form  method="POST" action="{{route('website-settings.update-contacts')}}" id="selectForm2" class="parsley-style-1" data-parsley-validate novalidate>
                                @csrf
                                <div class="form-group">
                                    <label>Company Address<span class="tx-danger">*</span></label>
                                    <textarea id="company_address" name="company_address" class="form-control" required @htmlValidationMessage({{__('standard.empty_all_field')}})>{{ $web->company_address }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div id="mob_no" class="parsley-input">
                                        <label>Mobile Number/s <span class="tx-danger">*</span></label>
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="{{ $web->mobile_no }}" data-parsley-class-handler="#mob_no" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Fax Number</label>
                                    <input type="text" id="fax_no" name="fax_no" class="form-control" value="{{ $web->fax_no }}">
                                </div>
                                <div class="form-group">
                                    <div id="tel_no" class="parsley-input">
                                        <label>Telephone Number/s <span class="tx-danger">*</span></label>
                                        <input type="text" id="telephone_no" name="tel_no" class="form-control" value="{{ $web->tel_no }}" data-parsley-class-handler="#tel_no" placeholder="000 000-0000" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="email" class="parsley-input">
                                        <label>Email Address/es <span class="tx-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ $web->email }}" data-parsley-class-handler="#email" required  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                    </div>
                                </div>
                                <div class="col-lg-12 mg-t-30 ">
                                    <button class="btn btn-primary btn-sm btn-uppercase " type="submit ">Save Settings</button>
                                    <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Social Tab -->
                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-lg-12 mg-t-15">
                            <div class="col-md-6">
                                <div class="form-group multiple-form-group">
                                    <label>Social Media Accounts</label>
                                    <form method="post" action="{{route('website-settings.update-media-accounts')}}">
                                        @csrf
                                        @forelse($medias as $media)
                                            <div class="form-group input-group input-icon">
                                                <input type="hidden" value="{{$media->id}}" name="mid[]">
                                                <select name="social_media[]"  class="form-control">
                                                    <option value="">Choose One</option>
                                                    <option @if($media->name == 'facebook') selected @endif value="facebook">Facebook</option>
                                                    <option @if($media->name == 'twitter') selected @endif value="twitter">Twitter</option>
                                                    <option @if($media->name == 'instagram') selected @endif value="instagram">Instagram</option>
                                                    <option @if($media->name == 'youtube') selected @endif value="youtube">Youtube</option>
                                                    <option @if($media->name == 'linkedin') selected @endif value="linkedin">LinkedIn</option>
                                                    <option @if($media->name == 'google') selected @endif value="google">Google</option>
                                                    {{--<option @if($media->name == 'dribble') selected @endif value="dribble">Dribble</option>--}}
                                                </select>
                                                &nbsp;
                                                <input type="text" class="form-control" name="url[]" value="{{ $media->media_account }}">
                                                <span class="input-group-btn">&nbsp;<button type="button" data-mid="{{$media->id}}" class="btn btn-danger remove-media">x</button></span>
                                            </div>
                                        @empty

                                        @endforelse
                                        <div class="form-group input-group input-icon">
                                            <input type="hidden" name="mid[]">
                                            <select name="social_media[]"  class="form-control">
                                                <option value="">Choose One</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="twitter">Twitter</option>
                                                <option value="instagram">Instagram</option>
                                                <option value="youtube">Youtube</option>
                                                <option value="linkedin">LinkedIn</option>
                                                <option value="google">Google</option>
                                                {{--<option value="dribble">Dribble</option>--}}
                                            </select>
                                            &nbsp;
                                            <input type="text" class="form-control" name="url[]" placeholder="URL">
                                            <span class="input-group-btn">&nbsp;<button type="button" class="btn btn-sm btn-primary btn-add"><i>+</i>
                                        </button></span>
                                        </div>
                                        <div class="col-lg-12 mg-t-30 ">
                                            <button class="btn btn-primary btn-sm btn-uppercase " type="submit ">Save Settings</button>
                                            <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Privacy Tab -->
                    <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                        <div class="col-lg-12 mg-t-15">
                            <form action="{{route('website-settings.update-data-privacy')}}" method="post" class="parsley-style-1" data-parsley-validate novalidate>
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div id="title" class="parsley-input">
                                            <label>Page Title <span class="tx-danger">*</span></label>
                                            <input type="text" name="privacy_title" class="form-control" data-parsley-class-handler="#title" value="{{ old('privacy_title',$web->data_privacy_title) }}" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="pop_up" class="parsley-input">
                                            <label>Pop-up Content <span class="tx-danger">*</span></label>
                                            <textarea rows="3" name="pop_up_content" class="form-control" data-parsley-class-handler="#pop_up" required @htmlValidationMessage({{__('standard.empty_all_field')}})>{{ old('pop_up_content',$web->data_privacy_popup_content) }}</textarea>
                                            <small><i data-feather="alert-circle" width="13"></i> {{__('standard.settings.website.pop-up_helper')}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="d-block">Content <span class="tx-danger">*</span></label>
                                        <textarea required name="content" id="editor1" rows="10" cols="80">
                                        {!! old('content',$web->data_privacy_content) !!}
                                    </textarea>
                                        <span class="invalid-feedback" role="alert" id="contentRequired" style="...">
                                        <strong>The content field is required</strong>
                                    </span>
                                        <script>
                                            // Replace the <textarea id="editor1"> with a CKEditor
                                            // instance, using default configuration.
                                            var options = {
                                                filebrowserImageBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Images',
                                                filebrowserImageUpload: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
                                                filebrowserBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Files',
                                                filebrowserUploadUrl: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
                                                allowedContent: true,
                                            };
                                            let editor = CKEDITOR.replace('content', options);
                                            editor.on('required', function (evt) {
                                                if($('.invalid-feedback').length == 1){
                                                    $('#contentRequired').show();
                                                }
                                                $('#cke_editor1').addClass('is-invalid');
                                                evt.cancel();
                                            });
                                        </script>
                                        @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="alert alert-danger" id="contentRequired" style="display: none;">The content field is required</div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mg-t-30">
                                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Settings</button>
                                    <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Ecommerce Tab -->
                    <div class="tab-pane fade @if(session()->has('tabname') && session('tabname') == 'ecommerce') show active @endif" id="ecommerce" role="tabpanel" aria-labelledby="ecommerce-tab">
                        <div class="col-lg-12 mg-t-15">
                            <div class="col-md-6">
                                <form method="post" action="{{route('website-settings.update-coupont-settings')}}">
                                    @csrf
                                    <h4 class="mg-t-50">Coupon Settings</h4>
                                    <div class="form-group">
                                        <div id="coupon_limit" class="parsley-input">      
                                            <label>Coupon Limit *</label>                                      
                                            <input type="number" name="coupon_limit" class="form-control" data-parsley-class-handler="#coupon_limit" value="{{ old('coupon_limit',$web->coupon_limit) }}" min="1">
                                            <small>Number of Coupons to be used in every transaction.</small>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div id="coupon_discount_limit" class="parsley-input">      
                                            <label>Coupon Discount Limit *</label>                                      
                                            <input type="number" name="coupon_discount_limit" class="form-control" data-parsley-class-handler="#coupon_discount_limit" value="{{ old('coupon_discount_limit',$web->coupon_discount_limit) }}" min="1">
                                            <small>Total coupon discount limit to be used in every transaction.</small>
                                        </div>
                                    </div>

                                    <h4 class="mg-t-50">Cart Settings</h4>
                                    <div class="form-group">
                                        <div id="cart_notification_duration" class="parsley-input">      
                                            <label>Cart Notification Duration (hrs) *</label>                                      
                                            <input type="number" name="cart_notification_duration" class="form-control" data-parsley-class-handler="#cart_notification_duration" value="{{ old('cart_notification_duration',$web->cart_notification_duration) }}" min="1">
                                            <small>The duration wherein the system verifies and notifies the customer that the items in the cart have not been checked out.</small>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div id="cart_product_duration" class="parsley-input">      
                                            <label>Product Cart Duration (hrs) *</label>                                      
                                            <input type="number" name="cart_product_duration" class="form-control" data-parsley-class-handler="#cart_product_duration" value="{{ old('cart_product_duration',$web->cart_product_duration) }}" min="1">
                                            <small>The duration wherein the system will automatically remove the items inside the cart.  Once the item has been removed it will be added back to the inventory count. <br>
                                            Note:  The Product Cart Duration should have a longer duration (hrs.) than the Cart Email Notification Duration (hrs.). </small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-xs btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Paynamics Tab -->
                    <div class="tab-pane fade" id="paynamics" role="tabpanel" aria-labelledby="paynamics-tab">
                        <div class="col-lg-12 mg-t-15">
                            <form action="{{route('website-settings.update-paynamics')}}" method="post" class="parsley-style-1" data-parsley-validate novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <h4>Payment Method List</h4>
                                    @php
                                        $payments = explode(",",$web->accepted_payments);
                                    @endphp
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th>Active</th>
                                                <th>Type</th>
                                                <th>Code</th>
                                                <th>Description</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="bdootc" 
                                                    @if(in_array('bdootc', $payments)) checked="checked" @endif></td>
                                                <td>Bank - over the counter</td>
                                                <td>bdootc</td>
                                                <td>Banco De Oro Bank Philippine Branches</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="pnbotc" 
                                                    @if(in_array('pnbotc', $payments)) checked="checked" @endif></td>
                                                <td>Bank - over the counter</td>
                                                <td>pnbotc</td>
                                                <td>Philippine National Bank Branches</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ucpbotc" 
                                                    @if(in_array('ucpbotc', $payments)) checked="checked" @endif></td>
                                                <td>Bank - over the counter</td>
                                                <td>ucpbotc</td>
                                                <td>United Coconut Planters Bank Branches</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="sbcotc" 
                                                    @if(in_array('sbcotc', $payments)) checked="checked" @endif></td>
                                                <td>Bank - over the counter</td>
                                                <td>sbcotc</td>
                                                <td>Security Bank Branches</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ecpay" 
                                                    @if(in_array('ecpay', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>ecpay</td>
                                                <td>Ecpay Network Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="da5" 
                                                    @if(in_array('da5', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>da5</td>
                                                <td>Direct Agents 5 Network Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="expresspay" 
                                                    @if(in_array('expresspay', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>expresspay</td>
                                                <td>Expresspay Network Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="dp" 
                                                    @if(in_array('dp', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>dp</td>
                                                <td>DragonPay Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="7eleven" 
                                                    @if(in_array('7eleven', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>7eleven</td>
                                                <td>711 Network Philippines</td>
                                            </tr>
                                            
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="cliqq" 
                                                    @if(in_array('cliqq', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>cliqq</td>
                                                <td>711 Cliqq Network Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ml" 
                                                    @if(in_array('ml', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>ml</td>
                                                <td>Mlhuillier Pawnshop Network</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ceb" 
                                                    @if(in_array('ceb', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>ceb</td>
                                                <td>Cebuana Pawnshop Network</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="sm" 
                                                    @if(in_array('sm', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>sm</td>
                                                <td>SM Bills Payment Network</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="truemoney" 
                                                    @if(in_array('truemoney', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>truemoney</td>
                                                <td>True Money Network</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="posible" 
                                                    @if(in_array('posible', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>posible</td>
                                                <td>Posible.net Network</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="etap" 
                                                    @if(in_array('etap', $payments)) checked="checked" @endif></td>
                                                <td>Non Bank - over the counter</td>
                                                <td>etap</td>
                                                <td>Etap Network</td>
                                            </tr>

                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="cc" 
                                                    @if(in_array('cc', $payments)) checked="checked" @endif></td>
                                                <td>Credit Card</td>
                                                <td>cc</td>
                                                <td>Credit Card</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="bdoobp" 
                                                    @if(in_array('bdoobp', $payments)) checked="checked" @endif></td>
                                                <td>Online Bills Payment</td>
                                                <td>bdoobp</td>
                                                <td>BDO Online Bills Payment</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ubpobp" 
                                                    @if(in_array('ubpobp', $payments)) checked="checked" @endif></td>
                                                <td>Online Bills Payment</td>
                                                <td>ubpobp</td>
                                                <td>Unionbank Online Bills Payment</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="pnbobp" 
                                                    @if(in_array('pnbobp', $payments)) checked="checked" @endif></td>
                                                <td>Online Bills Payment</td>
                                                <td>pnbobp</td>
                                                <td>Philippine National Bank Online Bills Payment</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ucpbobp" 
                                                    @if(in_array('ucpbobp', $payments)) checked="checked" @endif></td>
                                                <td>Online Bills Payment</td>
                                                <td>ucpbobp</td>
                                                <td>United Coconut Planters Online Bills Payment</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="sbobp" 
                                                    @if(in_array('sbobp', $payments)) checked="checked" @endif></td>
                                                <td>Online Bills Payment</td>
                                                <td>sbobp</td>
                                                <td>Security Bank Online Bills Payment</td>
                                            </tr>

                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="bn" 
                                                    @if(in_array('bn', $payments)) checked="checked" @endif></td>
                                                <td>Online Bank Transfer</td>
                                                <td>bn</td>
                                                <td>Bancnet Philippines</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="ents" 
                                                    @if(in_array('ents', $payments)) checked="checked" @endif></td>
                                                <td>Online Bank Transfer</td>
                                                <td>ents</td>
                                                <td>Enets Singapore</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="eghl" 
                                                    @if(in_array('eghl', $payments)) checked="checked" @endif></td>
                                                <td>Online Bank Transfer</td>
                                                <td>eghl</td>
                                                <td>E-GHL Thailand and Malaysia</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="poli" 
                                                    @if(in_array('poli', $payments)) checked="checked" @endif></td>
                                                <td>Online Bank Transfer</td>
                                                <td>poli</td>
                                                <td>Polipayments Australia and New Zealand</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="bpionline" 
                                                    @if(in_array('bpionline', $payments)) checked="checked" @endif></td>
                                                <td>Online Bank Transfer</td>
                                                <td>bpionline</td>
                                                <td>Bank of the Philippine Islands</td>
                                            </tr>

                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="pp" 
                                                    @if(in_array('pp', $payments)) checked="checked" @endif></td>
                                                <td>Wallet</td>
                                                <td>pp</td>
                                                <td>Paypal</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="vcard" 
                                                    @if(in_array('vcard', $payments)) checked="checked" @endif></td>
                                                <td>Wallet</td>
                                                <td>vcard</td>
                                                <td>Virtual Card</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="gc"  
                                                    @if(in_array('gc', $payments)) checked="checked" @endif></td>
                                                <td>Wallet</td>
                                                <td>gc</td>
                                                <td>Gcash</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="accepted_payments[]" value="bdoinstall"                      
                                                    @if(in_array('bdoinstall', $payments)) checked="checked" @endif></td>
                                                <td>Installment</td>
                                                <td>bdoinstall</td>
                                                <td>BDO Installment</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-lg-12 mg-t-30">
                                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Settings</button>
                                    <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Signin Tab -->
                    <div class="tab-pane fade" id="signin" role="tabpanel" aria-labelledby="siginin-tab">
                        <div class="col-lg-12 mg-t-15">
                            <form action="{{ route('website-settings.update-signin') }}" method="post" class="parsley-style-1" data-parsley-validate novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <h4>Third Party Sign-in List</h4>
                                    @php
                                        $third_party_signins = explode(",",$web->third_party_signin);
                                    @endphp
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th width="1%"></th>                                        
                                                <th>Name</th>                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" name="third_party_signins[]" value="google" 
                                                    @if(in_array('google', $third_party_signins)) checked="checked" @endif></td>
                                                <td>Google</td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" name="third_party_signins[]" value="facebook" 
                                                    @if(in_array('facebook', $third_party_signins)) checked="checked" @endif></td>
                                                <td>Facebook</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="col-lg-12 mg-t-30">
                                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Settings</button>
                                    <a href="{{ route('website-settings.edit') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Discard Changes</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    @include('admin.settings.website.modal')
@endsection

@section('pagejs')
    <script src="{{ asset('lib/cleave.js/cleave.min.js')}}"></script>
    <script src="{{ asset('lib/cleave.js/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('lib/parsleyjs/parsley.min.js') }}"></script>
@endsection

@section('customjs')

    <script>
        $('#min_order_is_allowed').change(function(){
            if (this.checked) {
                // the checkbox is now checked 
                $('#div1').show();
                $('#min_order').attr('min', '1');
            } else {
                // the checkbox is now no longer checked
                $('#min_order').removeAttr('min');
                $('#div1').hide();
            }
        });
        (function ($) {
            $(function () {

                var addFormGroup = function (event) {
                    event.preventDefault();

                    var $formGroup = $(this).closest('.form-group');
                    var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                    var $formGroupClone = $formGroup.clone();
                    $(this)
                        .toggleClass('btn-add btn-sm btn-danger btn-remove')
                        .html('x');
                    $formGroupClone.find('input').val('');
                    $formGroupClone.insertAfter($formGroup);
                };

                var removeFormGroup = function (event) {
                    event.preventDefault();

                    var $formGroup = $(this).closest('.form-group');
                    var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                    $formGroup.remove();
                };

                $(document).on('click', '.btn-add', addFormGroup);
                $(document).on('click', '.btn-remove', removeFormGroup);
            });
        })
        (jQuery);


        $(document).ready(function(){
            var i = 1;
            $('#add').on('click', function(){
                i++;
                var input = $(
                    '<tr id="row'+i+'">'
                    + '<td><input type="text" class="form-control" name="name[]" placeholder="Enter here..."/></td>'
                    + '<td><button type="button" id="'+i+'"class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></button></td>'
                    + '</tr>'
                );
                $('#dynamic_input').append(input);
            });

            $(document).on('click', '.remove', function(){
                var btn_id = $(this).attr("id");
                $('#row'+btn_id+'').remove();
            })
        });
    </script>

    <script>
        $(document).on('click', '.remove-logo', function() {
            $('#prompt-remove-logo').modal('show');
        });

        $(document).on('click', '.remove-icon', function() {
            $('#prompt-remove-icon').modal('show');
        });

        $(document).on('click', '.remove-media', function() {
            $('#prompt-delete-social').modal('show');
            $('#mid').val($(this).data('mid'));
        });

        // Company Logo
        $("#company_logo").change(function() {
            readLogo(this);
        });

        function readLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img_temp').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
                $('#image_div').show();
                $('.remove-logo').hide();
            }
        }

        // Web Favicon
        $("#web_favicon").change(function() {
            readIcon(this);
        });

        $("#min_order").change(function() {
            if($(this).val() > 0){
                $('#promo_header').show();
            }
            else{
                $('#promo_header').hide();
            }
        });

        function readIcon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#icon_temp').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
                $('#icon_div').show();
                $('.remove-icon').hide();
            }
        }

        
    </script>
@endsection
