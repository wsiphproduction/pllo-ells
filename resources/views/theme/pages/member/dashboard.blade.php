@extends('theme.main')

@section('pagecss')
<style>
    .profile-pic-preview-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #e9ebee; /* Facebook-like light gray */
        border: 3px solid #fff; /* White border */
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1); /* Subtle shadow around border */
        margin: 20px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-pic-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .btn-upload {
        background-color: #e5e5e5;
        border-color: #d7d7d7;
        border-radius: 8px;
        padding: 8px 15px;
        transition: background-color 0.2s ease;
        font-size: 14px;
    }
    .btn-upload:hover {
        background-color: #c3c3c3;
        border-color: #a1a1a1;
    }
    .form-control-file {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 8px 12px;
    }
    .file-input-wrapper {
        position: absolute;
        overflow: hidden;
        display: inline-block;
        cursor: pointer;
        text-align: center;
        transform: translate(25px, 75px);
    }
    .file-input-wrapper input[type=file] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .file-input-label {
        display: flex;
        background-color: #e4e6eb;
        color: #333;
        padding: 0px 0px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
    }
    .file-input-label:hover {
        background-color: #d8dade;
    }
    .file-input-wrapper.photo {
        transform: translate(25px, 108px);
    }
    ul#canvas-tab-border li.nav-item button.nav-link.active {
        color: #3c5d90 !important;;
        border: var(--bs-nav-tabs-border-width) solid var(--bs-nav-tabs-border-color) !important;
        border-bottom: none !important;
    }
    ul#canvas-tab-border li.nav-item button.nav-link:not(.active) {
        border: none;
        background-color: transparent;
    }
    .card-saved-contacts:hover {
        background-color: #e1e1e1;
    }
    .card-saved-contacts .delete-contact-btn {
        display: none;
    }
    .card-saved-contacts:hover .delete-contact-btn {
        display: block;
    }
    .card-saved-contacts .utility-btns {
        position: absolute;
        top: 0;
        right: 25px;
        display: none;
    }
    .card-saved-contacts:hover .utility-btns {
        position: absolute;
        top: 0;
        right: 25px;
        display: flex;
    }


</style>
@endsection

@section('content')

@php

@endphp

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="col-lg-12">

            <div class="heading-block border-0 mb-4 ">
               <!-- <h3>Welcome, {{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}!</h3> -->
            </div>

            <div class="row g-5">

                <div class="col-12 col-md-2">
                    <h4 class="form-title">USER PROFILE</h4>

                    <form action="{{ route('member.upload.logo') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-4 position-relative">
                            <div class="file-input-wrapper">
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                <label for="logo" class="file-input-label">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                      <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 18V8a1 1 0 0 1 1-1h1.5l1.707-1.707A1 1 0 0 1 8.914 5h6.172a1 1 0 0 1 .707.293L17.5 7H19a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/>
                                      <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </label>
                            </div>
                            <div class="profile-pic-preview-container">
                                <img id="imagePreviewLogo"
                                     src="{{ $memberDetails->logo ? asset('/' . $memberDetails->logo) : asset('images/user.png') }}"
                                     class="profile-pic-preview" alt="Profile Picture Preview"
                                     style="border-radius: 100%;">

                            </div>


                            @error('logo')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button id="logo_upload_btn" type="submit" class="btn btn-upload" style="display: none;">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2M12 4v12m0-12 4 4m-4-4L8 8"/>
                                </svg>
                                Upload Logo
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-10">

                    <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">

                        <!-- main profile trigger tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-profile-border-tab" data-bs-toggle="pill" data-bs-target="#profile-border" type="button" role="tab" aria-controls="tab-profile-border" aria-selected="true" onclick="tabSwitch(1)">

                                @if($memberDetails->userType->id == 1)
                                    <small><b>PROFILE</b></small>
                                @endif

                                @if($memberDetails->userType->id == 2 | $memberDetails->userType->id == 3)
                                    <small><b>SECRETARIE'S PROFILE</b></small>
                                @endif

                            </button>
                        </li>

                        <!-- agency trigger tab -->
                        @if(!empty($memberDetails->agency))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-agency-border-tab" data-bs-toggle="pill" data-bs-target="#agency-border" type="button" role="tab" aria-controls="tab-agency-border" aria-selected="false"><small><b>AGENCY PROFILE</b></small></button>
                        </li>
                        @endif 

                        <!-- senator trigger tab -->
                        @if(!empty($memberDetails->senator_id))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-senator-border-tab" data-bs-toggle="pill" data-bs-target="#senator-border" type="button" role="tab" aria-controls="tab-senator-border" aria-selected="false" onclick="tabSwitch(3)">
                                <small><b class="text-uppercase">{{ $memberDetails->senator->sen_firstname }} @if($memberDetails->senator->sen_middle_initial) {{ $memberDetails->senator->sen_middle_initial }}. @endif {{ $memberDetails->senator->sen_lastname }} {{ $memberDetails->senator->sen_suffix }}</b></small>
                            </button>
                        </li>
                        @endif

                        <!-- hor trigger tab -->
                        @if(!empty($memberDetails->hor_id))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-hor-border-tab" data-bs-toggle="pill" data-bs-target="#hor-border" type="button" role="tab" aria-controls="tab-hor-border" aria-selected="false" onclick="tabSwitch(4)">
                                <small><b class="text-uppercase">{{ $memberDetails->hor->hor_firstname }} {{ $memberDetails->hor->hor_middle_initial }} @if($memberDetails->hor->hor_middle_initial) . @endif {{ $memberDetails->hor->hor_lastname }}  {{ $memberDetails->hor->hor_suffix }}</b></small>
                            </button>
                        </li>
                        @endif

                        <!-- events trigger tab -->
                        @if($memberDetails->user_type != 7)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-events-border-tab" data-bs-toggle="pill" data-bs-target="#events-border" type="button" role="tab" aria-controls="tab-events-border" aria-selected="false"><small><b>EVENTS ATTENDED</b></small></button>
                        </li>
                        @endif
                        
                        @if($memberDetails->userType->id == 1 || $memberDetails->userType->id == 6)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-reference-border-tab" data-bs-toggle="pill" data-bs-target="#reference-border" type="button" role="tab" aria-controls="tab-reference-border" aria-selected="false"><small><b>REFERENCE MATERIALS</b></small></button>
                        </li>
                        @endif

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-policy-border-tab" data-bs-toggle="pill" data-bs-target="#policy-border" type="button" role="tab" aria-controls="tab-policy-border" aria-selected="false"><small><b>POLICY REFORMS</b></small></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-saved-border-tab" data-bs-toggle="pill" data-bs-target="#saved-border" type="button" role="tab" aria-controls="tab-saved-border" aria-selected="false"><small><b>SAVED CONTACTS</b></small></button>
                        </li>
                    </ul>
                    <div class="tab-content mb-3 relative">

                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-border" role="tabpanel" aria-labelledby="tab-profile-border-tab" tabindex="0">
                            <div class="row" id="default_profile_panel">
                                <div class="row">
                                    <small class="form-title mb-0"><b>MAIN ACCOUNT <i style="font-size: 12px;">({{ $memberDetails->designationDetails->name }})</i></b></small>
                                    <div class="col-12 col-md-2 d-flex align-items-start justify-content-center">
                                        <img class="mt-2" width="120" style="border-radius: 100%;
                                                            border-radius: 100%;
                                                            min-width: 120px;
                                                            height: 120px;
                                                            background-image: url('{{ Auth::user()->avatar ? asset('/' . Auth::user()->avatar) : asset('images/user.png') }}');
                                                            background-size: cover;
                                                            background-repeat: no-repeat;
                                                            background-position: center;">
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <table class="table-dotted table-striped">
                                            <tr>&nbsp;</tr>
                                            <tr>
                                                <td><span class="profile-label">Email Address:</span></td>
                                                <td><span>{{ $memberDetails->email }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="profile-label">Alt Email Address:</span></td>
                                                <td><span>information@dict.gov.ph</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="profile-label">Password:</span></td>
                                                <td><span>********</span></td>
                                            </tr>
                                        </table>
                                    </div>

                                    @if(!empty($memberDetails->cluster))
                                        <div class="col-12 col-md-5">
                                            <table class="table-dotted table-striped">
                                                <tr><small class="form-title"><b>CLUSTER</b></small></tr>

                                                @php
                                                    $cluster_arr = [];
                                                    $cluster_arr = explode('::', $memberDetails->cluster);
                                                @endphp

                                                @forelse($cluster_arr as $cluster)
                                                    <tr>
                                                        <td><span><small>{{ $memberDetails->getClusterName($cluster)->name }}</small></span></td>
                                                    </tr>
                                                @empty
                                                    <tr><td><span>No Cluster Details.</span></td></tr>
                                                @endforelse

                                            </table>
                                        </div>
                                    @endif
                                </div>
                                @foreach($userTypeMembers as $userTypeMember)
                                <div class="tab-content">
                                    <div class="row mt-4">
                                        @if($userTypeMember->designationDetails)
                                        <small class="form-title my-0" style="transform: translate(0px, 16px);">
                                            <b class="text-uppercase">{{ $userTypeMember->designationDetails->name }}</b>
                                        </small>
                                        @endif
                                        <div class="col-12 col-md-2 d-flex align-items-start justify-content-center">
                                            <img class="mt-4" width="120" style="border-radius: 100%;
                                                                border-radius: 100%;
                                                                min-width: 120px;
                                                                height: 120px;
                                                                background-image: url('{{ $userTypeMember->photo ? asset('/' . $userTypeMember->photo) : asset('images/user.png') }}');
                                                                background-size: cover;
                                                                background-repeat: no-repeat;
                                                                background-position: center;">
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <table class="table-dotted table-striped">
                                                <tr>&nbsp;</tr>
                                                <tr>
                                                    <td><span class="profile-label">Name:</span></td>
                                                    <td><span>{{ $userTypeMember->firstname }}  {{ $userTypeMember->suffix }} @if(!empty($userTypeMember->suffix)) . @endif {{ $userTypeMember->lastname }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Nickname:</span></td>
                                                    <td><span>{{ $userTypeMember->nickname }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Gender:</span></td>
                                                    <td><span>{{ $userTypeMember->memberGender->name }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Birthday:</span></td>
                                                    <td><span>{{ $userTypeMember->birthdate }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            @php
                                                $type_number_name = config('numbertype.'.$userTypeMember->type_number);
                                            @endphp 
                                            <table class="table-dotted table-striped">
                                                <tr>&nbsp;</tr>
                                                <tr>
                                                    <td><span class="profile-label">Email Address:</span></td>
                                                    <td><span>{{ $userTypeMember->email }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Cellphone Number:</span></td>
                                                    <td><span>{{ $userTypeMember->contact_number }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Viber Number:</span></td>
                                                    <td><span>@if($type_number_name == 'Viber' ) {{ $userTypeMember->other_number }} @else --- @endif</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="profile-label">Telegram Number:</span></td>
                                                    <td><span>@if($type_number_name == 'Telegram' ) {{ $userTypeMember->other_number }} @else --- @endif</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            <div class="row" id="edit_profile_panel" style="display: none;">
                                <form id="profile_update_form" action="{{ route('member.profile.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-2">
                                            <small class="form-title"><b>MAIN ACCOUNT</b></small>
                                            <br />
                                            <div class="text-center mb-4 position-relative">
                                                <div class="file-input-wrapper photo">
                                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                                    <label for="photo" class="file-input-label">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                          <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 18V8a1 1 0 0 1 1-1h1.5l1.707-1.707A1 1 0 0 1 8.914 5h6.172a1 1 0 0 1 .707.293L17.5 7H19a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/>
                                                          <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                        </svg>
                                                    </label>
                                                </div>
                                                <div class="profile-pic-preview-container">
                                                    <img id="imagePreviewPhoto"
                                                         src="{{ Auth::user()->avatar ? asset('/' . Auth::user()->avatar) : asset('images/user.png') }}"
                                                         class="profile-pic-preview" alt="Profile Picture Preview"
                                                         style="border-radius: 100%;">

                                                </div>


                                                @error('photo')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div>
                                                <input class="form-control mb-3" type="text" name="email" value="{{ $memberDetails->email }}">
                                                <input class="form-control mb-3" type="text" name="alt_email" value="{{ $memberDetails->alt_email }}" placeholder="ALT EMAIL ADDRESS">
                                                
                                                <div style="position: relative;">
                                                    <input class="form-control mb-3" type="password" name="password" value="{{ $memberDetails->password }}" placeholder="PASSWORD">
                                                    <svg style="right: 7px;" class="hide-password" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                </div>

                                                <div style="position: relative;">
                                                    <input class="form-control mb-3" type="password" name="confirm_password" value="" placeholder="CONFIRM PASSWORD">
                                                    <svg style="right: 7px;" class="hide-password" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                </div>

                                            </div>
                                            <small><i><span class="text-danger">Disclaimer:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</i></small>
                                        </div>

                                        @if(!empty($memberDetails->cluster))
                                        <div class="col-12 col-md-5">
                                            <div class="mb-2">
                                                @php
                                                    $cluster_arr = explode('::', $memberDetails->cluster);
                                                @endphp
                                                <select class="form-select" multiple aria-label="multiple select example" name="cluster[]">
                                                    @foreach($clustersList as $clusterItem)
                                                    <option value="{{ $clusterItem->id }}" @if(in_array($clusterItem->id, $cluster_arr)) selected @endif>{{ $clusterItem->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small><i>Press Control in keyboard and Left Click Mouse for changes and Multi Select. Changes in cluster needs approval.</i></small>
                                        </div>
                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Agency Tab -->
                        @if(!empty($memberDetails->agency))
                        <div class="tab-pane fade" id="agency-border" role="tabpanel" aria-labelledby="tab-agency-border-tab" tabindex="0">
                            <div class="row" id="default_agency_panel">
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr><small class="form-title"><b>{{ $memberAgency->agency_name }}</b></small></tr>
                                        <tr>
                                            <td colspan="2">
                                                <span>
                                                    <small>
                                                        <span class="profile-label">Main Office Address:</span>
                                                        <p>
                                                            {{ $memberAgency->agency_address }}
                                                        </p>
                                                    </small>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td><span><small>{{ $memberAgency->agency_email }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Landline Number:</small></span></td>
                                            <td><span><small>{{ $memberAgency->agency_landline }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number:</small></span></td>
                                            <td><span><small>{{ $memberAgency->agency_cellphone }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr><small class="form-title"><b>HEAD OF THE AGENCY</b></small></tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Name:</small></span></td>
                                            <td><span><small>{{ $memberAgency->head_name }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Nickname:</small></span></td>
                                            <td><span><small>{{ $memberAgency->head_nickname }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>{{ $memberAgency->getGenderName(1) }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Address: </small></span></td>
                                            <td><span><small>{{ $memberAgency->head_address }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Alt. Office Addres: </small></span></td>
                                            <td><span><small>{{ $memberAgency->head_alt_address }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Email Addres: </small></span></td>
                                            <td><span><small>{{ $memberAgency->head_email }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres: </small></span></td>
                                            <td><span><small>{{ $memberAgency->head_office_email }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number: </small></span></td>
                                            <td><span><small>{{ $memberAgency->head_cellphone }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Senators Tab -->
                        @if(!empty($memberDetails->senator_id))
                        <div class="tab-pane fade" id="senator-border" role="tabpanel" aria-labelledby="tab-senator-border-tab" tabindex="0">
                            <div class="row" id="default_senator_panel">
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Nickname:</small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_nickname }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->senator->sen_email_agree)
                                                        <small class="form-title"><b>{{ $memberDetails->senator->sen_email }}</b></small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Email hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Landline Number:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->senator->sen_landline_agree)
                                                        <small>{{ $memberDetails->senator->sen_landline }}</small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Office landline number hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->senator->sen_office_cellphone_agree)
                                                        <small>{{ $memberDetails->senator->sen_office_cellphone }}</small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Office cellphone number hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Main Room</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Room Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_main_room_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Direct Line: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_main_direct_line }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Fax Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_main_fax_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Trunk Local Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_main_trunk_local_number }}</small></span></td>
                                        </tr>
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Social Media</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Faceebook: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_facebook }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Twitter: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_twitter }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Instagram: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_instagram }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Youtube: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_youtube }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Senate Group:</small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_group }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Political Party:</small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_party }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>@if(!empty($memberDetails->senator->senGender->name)){{ $memberDetails->senator->senGender->name }}@endif</small></span></td>
                                        </tr>
                                        <tr>
                                            @php
                                                $sen_bday = explode('::',$memberDetails->senator->sen_birthday);
                                                $sen_month = $sen_bday[0];
                                                $sen_day = $sen_bday[1];
                                            @endphp
                                            <td><span class="profile-label"><small>BirthDate: </small></span></td>
                                            <td><span><small>{{ config('months.'.$sen_month) }} &nbsp; {{ $sen_day }}</small></span></td>
                                        </tr>
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Extension Room</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Room Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_extension_room_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Direct Line: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_extension_direct_line }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Fax Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_extension_fax_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Trunk Local Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senator->sen_extension_trunk_local_number }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row" id="edit_senator_panel" style="display: none;">
                                <form id="senator_update_form" action="{{ route('member.profile.senator.update', $memberDetails->senator->id ) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <small class="form-title"><b>DETAILS THAT ARE VISIBLE IN DIRECTORY</b></small>
                                        <br />
                                        <div class="col-12 d-flex">

                                            <div class="col-6">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="sen_firstname" value="{{ $memberDetails->senator->sen_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="sen_middle_initial" value="{{ $memberDetails->senator->sen_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="sen_lastname" value="{{ $memberDetails->senator->sen_lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="sen_suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option @if($memberDetails->senator->sen_nickname == 'Jr') selected  @endif>Jr</option>
                                                                <option @if($memberDetails->senator->sen_nickname == 'Sr') selected  @endif>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_nickname" value="{{ $memberDetails->senator->sen_nickname }}" placeholder="NICKNAME">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_email" value="{{ $memberDetails->senator->sen_email }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="sen_email_agree" @if($memberDetails->senator->sen_email_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_landline" value="{{ $memberDetails->senator->sen_landline }}" placeholder="OFFICE LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="sen_landline_agree" @if($memberDetails->senator->sen_landline_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_office_cellphone" value="{{ $memberDetails->senator->sen_office_cellphone }}" placeholder="OFFICE CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="sen_office_cellphone_agree" @if($memberDetails->senator->sen_office_cellphone_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <select class="form-select" name="sen_group">
                                                        <option selected disabled>MAJORITY/MINORITY/INDEPENDENT</option>
                                                        <option @if($memberDetails->senator->sen_group == 'MAJORITY') selected  @endif>MAJORITY</option>
                                                        <option @if($memberDetails->senator->sen_group == 'MINORITY') selected  @endif>MINORITY</option>
                                                        <option @if($memberDetails->senator->sen_group == 'INDEPENDENT') selected  @endif>INDEPENDENT</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-select" name="sen_party">
                                                        <option selected disabled>POLITICAL PARTY</option>
                                                        <option>PDP</option>
                                                        <option>LIBERAL</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        @php
                                                            $sen_bday = explode('::',$memberDetails->senator->sen_birthday);
                                                            $sen_month = $sen_bday[0];
                                                            $sen_day = $sen_bday[1];
                                                        @endphp
                                                        <div class="col-6">
                                                            <select class="form-select" name="sen_gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->senator->sen_gender == $gender->id) selected @endif value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <div class="d-flex">
                                                                <select class="form-select" aria-label="select month" name="sen_month" style="width: 70%">
                                                                    <option value="0">BIRTHMONTH</option>
                                                                    @foreach(Config::get('months') as $key => $month)
                                                                    <option @if($sen_month == $key) selected @endif value="{{ $key }}">{{ $month }}</option>
                                                                    @endforeach
                                                                </select>
                                                                &nbsp;
                                                                <select class="form-select" aria-label="select day" name="sen_day" style="width: 30%">
                                                                    <option value="0">BIRTHDAY</option>
                                                                    @for($d = 1; $d <= 31; $d++)
                                                                    <option @if($sen_day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <br />
                                        <small class="form-title"><b>SOCIAL MEDIA</b></small>
                                        <br />
                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_facebook" value="{{ $memberDetails->senator->sen_facebook }}" placeholder="FACEBOOK">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_twitter" value="{{ $memberDetails->senator->sen_twitter }}" placeholder="TWITTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_instagram" value="{{ $memberDetails->senator->sen_instagram }}" placeholder="INSTAGRAM">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_youtube" value="{{ $memberDetails->senator->sen_youtube }}" placeholder="YOUTUBE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br />
                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <small class="form-title"><b>MAIN ROOM</b></small>
                                                <br />
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_main_room_number" value="{{ $memberDetails->senator->sen_main_room_number }}" placeholder="ROOM NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_main_direct_line" value="{{ $memberDetails->senator->sen_main_direct_line }}" placeholder="DIRECT LINE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_main_fax_number" value="{{ $memberDetails->senator->sen_main_fax_number }}" placeholder="FAX NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_main_trunk_local_number" value="{{ $memberDetails->senator->sen_main_trunk_local_number }}" placeholder="TRUNK LOCAL NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="form-title"><b>EXTENSION ROOM</b></small>
                                                <br />
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_extension_room_number" value="{{ $memberDetails->senator->sen_extension_room_number }}" placeholder="ROOM NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_extension_direct_line" value="{{ $memberDetails->senator->sen_extension_direct_line }}" placeholder="DIRECT LINE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_extension_fax_number" value="{{ $memberDetails->senator->sen_extension_fax_number }}" placeholder="FAX NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_extension_trunk_local_number" value="{{ $memberDetails->senator->sen_extension_trunk_local_number }}" placeholder="TRUNK LOCAL NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br />
                                        <small class="form-title"><b>DETAILS THAT ARE NOT VISIBLE IN DIRECTORY</b></small>
                                        <small class="form-title"><b>SPOUSE</b></small>
                                        <br />
                                        <div class="col-12 d-flex">

                                            <div class="col-6">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="sen_spouse_firstname" value="{{ $memberDetails->senator->sen_spouse_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="sen_spouse_middle_initial" value="{{ $memberDetails->senator->sen_spouse_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="sen_spouse_lastname" value="{{ $memberDetails->senator->sen_spouse_lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="sen_spouse_suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option>Jr</option>
                                                                <option>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-select" name="sen_spouse_gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->senator->sen_spouse_gender == $gender->id) selected @endif value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="sen_spouse_birthday" value="{{ $memberDetails->senator->sen_spouse_birthday }}" placeholder="BIRTHDAY">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- need changes here soon -->
                                                <div class="form-group">
                                                    <select class="form-select" name="sen_spouse_profession">
                                                        <option selected disabled>PROFESSION</option>
                                                        <option>TEACHER</option>
                                                        <option>TECHNOLOGY</option>
                                                        <option>GOVERNMENT</option>
                                                    </select>
                                                </div>
                                               
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_spouse_office_address" value="{{ $memberDetails->senator->sen_spouse_office_address }}" placeholder="OFFICE ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_spouse_email_address" value="{{ $memberDetails->senator->sen_spouse_email_address }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_spouse_landline_number" value="{{ $memberDetails->senator->sen_spouse_landline_number }}" placeholder="LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="sen_spouse_cellphone_number" value="{{ $memberDetails->senator->sen_spouse_cellphone_number }}" placeholder="CELLPHONE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Hors Tab -->
                        @if(!empty($memberDetails->hor_id))
                        <div class="tab-pane fade" id="hor-border" role="tabpanel" aria-labelledby="tab-hor-border-tab" tabindex="0">
                            <div class="row" id="default_hor_panel">
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Nickname:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_nickname }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->hor->hor_email_agree)
                                                        <small class="form-title"><b>{{ $memberDetails->hor->hor_email }}</b></small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Email hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Landline Number:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->hor->hor_landline_agree)
                                                        <small>{{ $memberDetails->hor->hor_landline }}</small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Office landline number hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->hor->hor_office_cellphone_agree)
                                                        <small>{{ $memberDetails->hor->hor_office_cellphone }}</small>
                                                    @else
                                                        <small class="form-title">
                                                            <i disabled>(<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                                                            </svg>
                                                            Office cellphone number hidden)
                                                            </i>
                                                        </small>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Social Media</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Faceebook: </small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_facebook }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Twitter: </small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_twitter }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Instagram: </small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_instagram }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Youtube: </small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_youtube }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Province | Partylist:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_province }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>District:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_district }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Region:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_region }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Senate Group:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_group }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Political Party:</small></span></td>
                                            <td><span><small>{{ $memberDetails->hor->hor_party }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>@if(!empty($memberDetails->hor->gender->name)){{ $memberDetails->hor->gender->name }}@endif</small></span></td>
                                        </tr>
                                        <tr>
                                            @php
                                                $hor_bday = explode('::',$memberDetails->hor->hor_birthday);
                                                $hor_month = $hor_bday[0];
                                                $hor_day = $hor_bday[1];
                                            @endphp
                                            <td><span class="profile-label"><small>BirthDate: </small></span></td>
                                            <td><span><small>{{ config('months.'.$hor_month) }} &nbsp; {{ $hor_day }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            <div class="row" id="edit_hor_panel" style="display: none;">
                                <form id="hor_update_form" action="#" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <small class="form-title"><b>DETAILS THAT ARE VISIBLE IN DIRECTORY</b></small>
                                        <br />
                                        <div class="col-12 d-flex">

                                            <div class="col-6">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="hor_firstname" value="{{ $memberDetails->hor->hor_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="hor_middle_initial" value="{{ $memberDetails->hor->hor_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="hor_lastname" value="{{ $memberDetails->hor->hor_lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="hor_suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option @if($memberDetails->hor->sen_nickname == 'Jr') selected  @endif>Jr</option>
                                                                <option @if($memberDetails->hor->sen_nickname == 'Sr') selected  @endif>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_nickname" value="{{ $memberDetails->hor->hor_nickname }}" placeholder="NICKNAME">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_email" value="{{ $memberDetails->hor->hor_email }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="hor_email_agree" @if($memberDetails->hor->hor_email_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_landline" value="{{ $memberDetails->hor->hor_landline }}" placeholder="OFFICE LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="hor_landline_agree" @if($memberDetails->hor->hor_landline_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_office_cellphone" value="{{ $memberDetails->hor->hor_office_cellphone }}" placeholder="OFFICE CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="hor_office_cellphone_agree" @if($memberDetails->hor->hor_office_cellphone_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <select class="form-select" name="hor_group">
                                                        <option selected disabled>MAJORITY/MINORITY/INDEPENDENT</option>
                                                        <option @if($memberDetails->hor->sen_group == 'MAJORITY') selected  @endif>MAJORITY</option>
                                                        <option @if($memberDetails->hor->sen_group == 'MINORITY') selected  @endif>MINORITY</option>
                                                        <option @if($memberDetails->hor->sen_group == 'INDEPENDENT') selected  @endif>INDEPENDENT</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-select" name="hor_party">
                                                        <option selected disabled>POLITICAL PARTY</option>
                                                        <option>PDP</option>
                                                        <option>LIBERAL</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        @php
                                                            $hor_bday = explode('::',$memberDetails->hor->hor_birthday);
                                                            $hor_month = $hor_bday[0];
                                                            $hor_day = $hor_bday[1];
                                                        @endphp
                                                        <div class="col-6">
                                                            <select class="form-select" name="hor_gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->hor->hor_gender == $gender->id) selected @endif value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <div class="d-flex">
                                                                <select class="form-select" aria-label="select month" name="hor_month" style="width: 70%">
                                                                    <option value="0">BIRTHMONTH</option>
                                                                    @foreach(Config::get('months') as $key => $month)
                                                                    <option @if($hor_month == $key) selected @endif value="{{ $key }}">{{ $month }}</option>
                                                                    @endforeach
                                                                </select>
                                                                &nbsp;
                                                                <select class="form-select" aria-label="select day" name="hor_day" style="width: 30%">
                                                                    <option value="0">BIRTHDAY</option>
                                                                    @for($d = 1; $d <= 31; $d++)
                                                                    <option @if($hor_day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <br />
                                        <small class="form-title"><b>SOCIAL MEDIA</b></small>
                                        <br />
                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_facebook" value="{{ $memberDetails->hor->hor_facebook }}" placeholder="FACEBOOK">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_twitter" value="{{ $memberDetails->hor->hor_twitter }}" placeholder="TWITTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_instagram" value="{{ $memberDetails->hor->hor_instagram }}" placeholder="INSTAGRAM">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_youtube" value="{{ $memberDetails->hor->hor_youtube }}" placeholder="YOUTUBE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <small class="form-title"><b>DETAILS THAT ARE NOT VISIBLE IN DIRECTORY</b></small>
                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <small class="form-title"><b>RESIDENTIAL ADDRESS</b></small>
                                                <br />
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_adress" value="{{ $memberDetails->hor->hor_resident_adress }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_email" value="{{ $memberDetails->hor->hor_resident_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_landline" value="{{ $memberDetails->hor->hor_resident_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_cellphone" value="{{ $memberDetails->hor->hor_resident_cellphone }}" placeholder="CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="form-title"><b>PROVINCIAL ADDRESS</b></small>
                                                <br />
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_adress" value="{{ $memberDetails->hor->hor_province_adress }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_email" value="{{ $memberDetails->hor->hor_province_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_landline" value="{{ $memberDetails->hor->hor_province_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_cellphone" value="{{ $memberDetails->hor->hor_province_cellphone }}" placeholder="CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br />
                                        <small class="form-title"><b>DIRECT ADDRESS</b></small>
                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_adress" value="{{ $memberDetails->hor->hor_resident_adress }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_resident_email" value="{{ $memberDetails->hor->hor_resident_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_landline" value="{{ $memberDetails->hor->hor_province_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_province_cellphone" value="{{ $memberDetails->hor->hor_province_cellphone }}" placeholder="CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex gap-4">
                                            <div class="col-6">
                                                <small class="form-title"><b>SCHOOL | WORK</b></small>
                                                <br />
                                                <div class="form-group mt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_highest_education" value="{{ $memberDetails->hor->hor_highest_education }}" placeholder="HIGHEST EDUCATIONAL ATTAINMENT COURSE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_school" value="{{ $memberDetails->hor->hor_school }}" placeholder="SCHOOL">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_prev_work_gov" value="{{ $memberDetails->hor->hor_prev_work_gov }}" placeholder="PREVIOUS WORK: GOVERNMENT">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_prev_work_private" value="{{ $memberDetails->hor->hor_prev_work_private }}" placeholder="PREVIOUS WORK: PRIVATE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_religion" value="{{ $memberDetails->hor->hor_religion }}" placeholder="RELIGION">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_civic" value="{{ $memberDetails->hor->hor_civic }}" placeholder="CIVIC ORGANIZATIONAL AFFILIATION">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="form-title"><b>SPOUSE</b></small>
                                                <br />
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="hor_spouse_firstname" value="{{ $memberDetails->hor->hor_spouse_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="hor_spouse_middle_initial" value="{{ $memberDetails->hor->hor_spouse_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control" type="text" name="hor_spouse_lastname" value="{{ $memberDetails->hor->hor_spouse_lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="hor_spouse_suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option>Jr</option>
                                                                <option>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input class="form-control" type="date" name="hor_spouse_wedding_aniv" value="{{ $memberDetails->hor->hor_spouse_wedding_aniv }}" placeholder="WEDDING ANNIVERSARY">
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="hor_spouse_birthday" value="{{ $memberDetails->hor->hor_spouse_birthday }}" placeholder="BIRTHDAY">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_spouse_civic" value="{{ $memberDetails->hor->hor_spouse_civic }}" placeholder="CIVIC ORGANIZATIONAL AFFILIATION">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                   <input class="form-control" type="text" name="hor_spouse_profession" value="{{ $memberDetails->hor->hor_spouse_profession }}" placeholder="PROFESSION">
                                                </div>
                                               
                                            </div>
                                        </div>

                                        <br />
                                        <small class="form-title"><b>CHILDREN</b></small>
                                        <!-- add fucntion to create another children fields -->
                                        <div class="col-12 d-flex flex-wrap">
                                            <div class="col-6 mb-4 px-3">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_child_name" value="{{ $memberDetails->hor->hor_child_name }}" placeholder="NAME">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_child_email" value="{{ $memberDetails->hor->hor_child_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_child_landline" value="{{ $memberDetails->hor->hor_child_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_child_cellphone" value="{{ $memberDetails->hor->hor_child_cellphone }}" placeholder="CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="hor_child_profession" value="{{ $memberDetails->hor->hor_child_profession }}" placeholder="PROFESSION">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="col-12 d-flex">
                                            <button class="w-100 btn btn-secondary rounded shadow text-center"> ADD CHILDREN </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Events Tab -->
                        @if($memberDetails->user_type != 7)
                        <div class="tab-pane fade" id="events-border" role="tabpanel" aria-labelledby="tab-events-border-tab" tabindex="0">
                            <div class="col-12">
                                <table class="table-dotted table-striped">
                                    <tr>
                                        <small>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            <br>
                                            &nbsp;
                                        </small>
                                    </tr>
                                    @forelse($events as $event)
                                    <tr>
                                        <td><span><small>{{ $event->event->date }}</small></span></td>
                                        <td><span class="primary-text-color"><small>{{ $event->event->title }}</small></span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>No events attended for now.</td>
                                    </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Reference Materials -->
                        @if($memberDetails->userType->id == 1 || $memberDetails->userType->id == 6)
                        <div class="tab-pane fade" id="reference-border" role="tabpanel" aria-labelledby="tab-reference-border-tab" tabindex="0">
                            <div class="col-12">
                                <table class="table-dotted table-striped">
                                    <tr>
                                        <small>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        <br>
                                        &nbsp;
                                        </small>
                                    </tr>
                                    
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">SSS Position on House Joint Resolution (HJR) No. 1 Mandating the implementat ion of the second tranche increase in pension</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 11, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">Department of Finance-Bureau of Local Government Finance Real Property Valuaঞon Bil</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 29, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">Act Requiring Local Government Units to Allocate Land for the Establishment of Muslim Filipino Public Cemetery</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>June 5, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">New Emancipation Act / New Agrarian Emancipation Act / Agrarian Reform Emancipation and Condonation of Land Amortization act</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>June 19, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">Expand the purposes and application of the Special Educaঞon Fund (SEF)</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>June 26, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">Postponement of the December 2022 Barangay and Sangguniang Kabataan Election</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>July 15, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">Unified System of Separation, Retirement and Pension - Military and Uniformed Personnel (MUP</a></small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>July 30, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small><a href="#" class="primary-text-color">BSP Proposed Amendment to Section 3 of the Consolidated Common Dra[ E-Governance / EGovernment Legislative Measures</a></small></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Policy Reforms Tab -->
                        <div class="tab-pane fade" id="policy-border" role="tabpanel" aria-labelledby="tab-policy-border-tab" tabindex="0">
                            <div class="col-12">
                                <table class="table-dotted table-striped">
                                    <tr>
                                        <small>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        <br>
                                        <br>
                                        <small><b class="primary-text-color">MY SAVED BILL/S</b></small>
                                        </small>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <span class="primary-text-color"><small><a href="#" class="primary-text-color">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</a></small></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-text-color"><small><a href="#" class="primary-text-color">Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab</a></small></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-text-color"><small><a href="#" class="primary-text-color">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</a></small></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-text-color"><small><a href="#" class="primary-text-color">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</a></small></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Saved Contacts Tab -->
                        <div class="tab-pane fade" id="saved-border" role="tabpanel" aria-labelledby="tab-saved-border-tab" tabindex="0">
                            <div class="col-12">
                                <small>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 1labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                <br>
                                </small>
                                <div class="my-2 d-flex flex-wrap">
                                    @forelse($saved_contacts as $saved_contact)
                                        <div class="col-6">
                                            <div class="saved-container">
                                                <div class="card border-0 card-saved-contacts cursor-pointer">
                                                    <div class="card-body">
                                                        <!-- <div class="row mb-2">
                                                            <small><b class="primary-text-color">CONGRESS COMMITTEE SECRETARY</b></small>
                                                        </div> -->
                                                        <div class="col-12 d-flex">
                                                            <div class="col-3 text-center">
                                                                <img class="rounded"
                                                                src="{{ $saved_contact->member->photo ? asset('/' . $saved_contact->member->photo) : asset('images/user.png') }}"
                                                                width="120px">
                                                            </div>
                                                            <div class="col-9">
                                                                <ul class="list-unstyled">
                                                                    <li>
                                                                        <small>
                                                                            <b class="primary-text-color">{{ $saved_contact->member->userType->name }}</b>
                                                                        </small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-user" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color">{{ $saved_contact->member->FullName }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-users" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp;
                                                                        <small style="display: inline-grid;">
                                                                            {{ $saved_contact->member->FullAgencyName }}
                                                                            @if($saved_contact->member->subAgency)
                                                                            <br>
                                                                            <p style="font-size: 10px;">{{ $saved_contact->member->subAgency->name }}</p>
                                                                            @endif
                                                                        </small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-call" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp;<small>{{ $saved_contact->member->contact_number }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-envelope" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color">{{ $saved_contact->member->email }}</small>
                                                                    </li>
                                                                </ul>

                                                                <div class="utility-btns align-items-center gap-2">
                                                                    <a href="#" title="Message" style="color: gray !important;"><i class="icon-chat"></i></a>
                                                                    <a href="#" title="Call" style="color: gray !important;"><i class="icon-mobile"></i></a>
                                                                    <a class="cursor-pointer trash-contact-btn" data-bs-toggle="modal" data-bs-target="#removeContactModal" data-id="{{ $saved_contact->member->id }}" title="Remove" style="color: #ff4d4d !important;"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p>No saved contacts for now.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <small><i><span class="text-danger">Disclaimer for Data Privacy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</i></small>
                    </div>

                    <!-- Action buttons -->
                    <div class="row">
                        <div class="button-group d-flex justify-content-end mt-4">
                            <button class="btn btn-secondary text-white" id="edit_profile_btn"><small class="text-uppercase">edit profile</small></button>
                            &nbsp;
                            &nbsp;
                            <div id="save_cancel_pane" style="display: none;">
                                <button class="btn btn-primary text-white" id="save_profile_btn" onclick="submitProfileUpdate()"><small class="text-uppercase">SAVE</small></button>
                                &nbsp;
                                &nbsp;
                                <button class="btn btn-secondary text-white" id="cancel_profile_btn"><small class="text-uppercase">CANCEL</small></button>
                                &nbsp;
                                &nbsp;
                            </div>
                            <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteAccountModal"><small class="text-uppercase">delete account</small></button>
                        </div>
                    </div>

                    <input type="hidden" id="current-tab" value="1">

                    <!-- Delete Account Modal -->
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteAccountModalLabel">Delete Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete your account?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="#" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user() }}">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Trash Contact -->
                    <div class="modal fade" id="removeContactModal" tabindex="-1" aria-labelledby="removeContactLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="removeContactModalLabel">Remove Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to remove this contact?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="{{ route('member.profile.remove.contact') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" id="trash-user-id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="contact_id" id="trash-contact-id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>

            </div>
            
        </div>
    </div>
</div>

@endsection

@section('pagejs')
	<script>
        $(document).ready(function() {
            // Get the image input and the preview image element
            const logoInput = $('#logo');
            const photoInput = $('#photo');
            const imagePreviewLogo = $('#imagePreviewLogo');
            const imagePreviewPhoto = $('#imagePreviewPhoto');

            // Listen for changes on the file input on Logo
            logoInput.on('change', function() {
                // Get the selected file
                const file = this.files[0];

                $('#logo_upload_btn').show();

                if (file) {
                    // Create a FileReader object
                    const reader = new FileReader();

                    // Set the onload event handler for the FileReader
                    reader.onload = function(e) {
                        // Set the src attribute of the image preview to the data URL
                        imagePreviewLogo.attr('src', e.target.result);
                    };

                    // Read the file as a Data URL (Base64 encoded string)
                    reader.readAsDataURL(file);
                } else {
                    // If no file is selected, revert to default or placeholder image
                    imagePreviewLogo.attr('src', '{{ Auth::user()->logo ? asset('storage/' . Auth::user()->logo) : 'https://placehold.co/150x150/e9ebee/333333?text=No+Image' }}');
                }
            });

                    // Listen for changes on the file input on Logo
            photoInput.on('change', function() {
                // Get the selected file
                const file = this.files[0];

                if (file) {
                    // Create a FileReader object
                    const reader = new FileReader();

                    // Set the onload event handler for the FileReader
                    reader.onload = function(e) {
                        // Set the src attribute of the image preview to the data URL
                        imagePreviewPhoto.attr('src', e.target.result);
                    };

                    // Read the file as a Data URL (Base64 encoded string)
                    reader.readAsDataURL(file);
                } else {
                    // If no file is selected, revert to default or placeholder image
                    imagePreviewPhoto.attr('src', '{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://placehold.co/150x150/e9ebee/333333?text=No+Image' }}');
                }
            });
        });

        // Profile Edit
        $('#edit_profile_btn').on('click', function() {
            // for main profile tab
            $('#edit_profile_panel').css("display", "flex");
            $('#default_profile_panel').css("display", "none");

            // for senator tab
            $('#edit_senator_panel').css("display", "flex");
            $('#default_senator_panel').css("display", "none");

            // for hor tab
            $('#edit_hor_panel').css("display", "flex");
            $('#default_hor_panel').css("display", "none");

            // buttons
            $('#save_cancel_pane').css("display", "flex");
            $('#edit_profile_btn').css("display", "none");
        });

        // Cancel Edit hide all active tabs
        $('#cancel_profile_btn').on('click', function() {
            // for main profile
            $('#edit_profile_panel').css("display", "none");
            $('#default_profile_panel').css("display", "flex");

            // for senator
            $('#edit_senator_panel').css("display", "none");
            $('#default_senator_panel').css("display", "flex");

            // for hor
            $('#edit_hor_panel').css("display", "none");
            $('#default_hor_panel').css("display", "flex");

            // for buttons
            $('#save_cancel_pane').css("display", "none");
            $('#edit_profile_btn').css("display", "flex");
        });

        // tab switch determinant
        function tabSwitch(num) {
            $('#current-tab').val(num);
        }

        // submit condition before process
        function submitProfileUpdate() {

            // catch tab hidden value
            let tab = $('#current-tab').val();

            if(tab == 1) {
                $('#profile_update_form').submit();
            } else if(tab == 3) {
                $('#senator_update_form').submit();
            } else if(tab == 4) {
                $('#hor_update_form').submit();
            } else {
                // nothing for now.
            }

        }

        // trash a contact
        $('.trash-contact-btn').on('click', function() {
            let num = $(this).attr('data-id');
            $('#trash-contact-id').val(num);
        });


	</script>
@endsection

