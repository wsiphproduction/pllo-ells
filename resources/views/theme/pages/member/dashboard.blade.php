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
    #add_messaging:hover {
        color: #005ded;
        text-decoration: underline;
    }
    .select-type-number {
        position: absolute;
        width: fit-content;
        border: none;
        top: 1px;
        left: 14px;
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
                    @if($memberDetails->user_type != 5)
                        <h4 class="form-title">USER PROFILE</h4>
                    @else
                        <h4 class="form-title">PROFILE</h4>
                    @endif

                    <!-- Need adjustment for user_type 5 CongSec -->
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
                                @if($memberDetails->user_type == 5 || $memberDetails->user_type == 7)
                                <img id="imagePreviewLogo"
                                     src="{{ $memberDetails->photo ? asset('/' . $memberDetails->photo) : asset('images/user.png') }}"
                                     class="profile-pic-preview" alt="Profile Picture Preview"
                                     style="border-radius: 100%;">
                                @else
                                    <img id="imagePreviewLogo"
                                         src="{{ $memberDetails->logo ? asset('/' . $memberDetails->logo) : asset('images/user.png') }}"
                                         class="profile-pic-preview" alt="Profile Picture Preview"
                                         style="border-radius: 100%;">
                                @endif
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
                                @if($memberDetails->user_type == 5 || $memberDetails->user_type == 7)
                                    Upload Photo ID
                                @else
                                    Upload Logo
                                @endif
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-10">

                    <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">

                        <!-- main profile trigger tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-profile-border-tab" data-bs-toggle="pill" data-bs-target="#profile-border" type="button" role="tab" aria-controls="tab-profile-border" aria-selected="true" onclick="tabSwitch(1)">

                                @if($memberDetails->userType->id == 1 || $memberDetails->userType->id == 4 || $memberDetails->userType->id == 5 || $memberDetails->userType->id == 6 || $memberDetails->userType->id == 7)
                                    <small><b>PROFILE</b></small>
                                @endif

                                @if($memberDetails->userType->id == 2 | $memberDetails->userType->id == 3)
                                    <small><b>SECRETARIE'S PROFILE</b></small>
                                @endif

                            </button>
                        </li>

                        <!-- agency trigger tab -->
                        @if(!empty($memberDetails->agency) && $memberDetails->user_type != 2)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-agency-border-tab" data-bs-toggle="pill" data-bs-target="#agency-border" type="button" role="tab" aria-controls="tab-agency-border" aria-selected="false"><small><b>AGENCY PROFILE</b></small></button>
                        </li>
                        @endif 

                        <!-- senator trigger tab -->
                        @if(!empty($memberDetails->senator_id))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-senator-border-tab" data-bs-toggle="pill" data-bs-target="#senator-border" type="button" role="tab" aria-controls="tab-senator-border" aria-selected="false" onclick="tabSwitch(3)">
                                <small><b class="text-uppercase">Sen. {{ $memberDetails->senatorOfficial->firstname }} @if($memberDetails->senatorOfficial->middle_initial) {{ $memberDetails->senatorOfficial->middle_initial }}. @endif {{ $memberDetails->senatorOfficial->lastname }} {{ $memberDetails->senatorOfficial->suffix }}</b></small>
                            </button>
                        </li>
                        @endif

                        <!-- hor trigger tab -->
                        @if(!empty($memberDetails->hor_id))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-hor-border-tab" data-bs-toggle="pill" data-bs-target="#hor-border" type="button" role="tab" aria-controls="tab-hor-border" aria-selected="false" onclick="tabSwitch(4)">
                                <small><b class="text-uppercase">Cong. {{ $memberDetails->horOfficial->firstname }} {{ $memberDetails->horOfficial->middle_initial }} @if($memberDetails->horOfficial->middle_initial) . @endif {{ $memberDetails->horOfficial->lastname }}  {{ $memberDetails->horOfficial->suffix }}</b></small>
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

                                    @if($memberDetails->user_type == 5 || $memberDetails->user_type == 7)
                                        <!-- nothing for now -->
                                    @else
                                        <small class="form-title mb-0"><b>MAIN ACCOUNT</b></small>
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
                                    @endif

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
                                            @if($memberDetails->user_type == 5)
                                            <tr>
                                                <td><span class="profile-label">Gender:</span></td>
                                                <td><span>{{ $memberDetails->memberGender->name }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="profile-label">Birthday:</span></td>
                                                <td><span>{{ $memberDetails->birthdate }}</span></td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>

                                    @if($memberDetails->user_type == 5)
                                    @php
                                        $type_number_name = config('numbertype.'.$memberDetails->type_number);
                                    @endphp 
                                    <div class="col-12 col-md-5">
                                        <table class="table-dotted table-striped">
                                            <tr>&nbsp;</tr>
                                            <tr>
                                                <td><span class="profile-label">Cellphone Number:</span></td>
                                                <td><span>{{ $memberDetails->contact_number }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="profile-label">Viber Number:</span></td>
                                                <td><span>@if($type_number_name == 'Viber' ) {{ $memberDetails->other_number }} @else --- @endif</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="profile-label">Telegram Number:</span></td>
                                                <td><span>@if($type_number_name == 'Telegram' ) {{ $memberDetails->other_number }} @else --- @endif</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    @endif

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

                                <!-- For usertype that has staff only -->
                                @if($memberDetails->user_type < 5)
                                    @if(!empty($staffs))
                                        @foreach($staffs as $staff)
                                        <div class="tab-content">
                                            <div class="row mt-4">
                                                <small class="form-title my-0" style="transform: translate(0px, 16px);">
                                                    <b class="text-uppercase">{{ $staff->designation }}</b>
                                                </small>
                                                <div class="col-12 col-md-2 d-flex align-items-start justify-content-center">
                                                    <img class="mt-4" width="120" style="border-radius: 100%;
                                                                        border-radius: 100%;
                                                                        min-width: 120px;
                                                                        height: 120px;
                                                                        background-image: url('{{ $staff->photo ? asset('/' . $staff->photo) : asset('images/user.png') }}');
                                                                        background-size: cover;
                                                                        background-repeat: no-repeat;
                                                                        background-position: center;">
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <table class="table-dotted table-striped">
                                                        <tr>&nbsp;</tr>
                                                        <tr>
                                                            <td><span class="profile-label">Name:</span></td>
                                                            <td><span class="text-uppercase">{{ $staff->firstname }}  {{ $staff->suffix }} @if(!empty($staff->suffix)) . @endif {{ $staff->lastname }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="profile-label">Nickname:</span></td>
                                                            <td><span class="text-uppercase">{{ $staff->nickname }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="profile-label">Gender:</span></td>
                                                            <td>
                                                                <span>
                                                                    @if(!empty($staff->gender))
                                                                    {{ $staff->personGender->name }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="profile-label">Birthday:</span></td>
                                                            <td>
                                                                <span>
                                                                    @if($staff->birthday == '0 0')
                                                                        ---
                                                                    @elseif($staff->birthday == '12 0')
                                                                        ---
                                                                    @else
                                                                        {{ $staff->birthday }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    @if(!empty($staff->other_number))
                                                        @php
                                                            $type_number_name = config('numbertype.'.$staff->type_number);
                                                        @endphp 
                                                    @endif
                                                    <table class="table-dotted table-striped">
                                                        <tr>&nbsp;</tr>
                                                        <tr>
                                                            <td><span class="profile-label">Email Address:</span></td>
                                                            <td>
                                                                <span class="d-flex justify-content-between">
                                                                    {{ $staff->email }}
                                                                    @if(!empty($staff->contact_number))
                                                                        <a href="mailto:{{ $staff->email }}" title="send an email"><i class="icon-envelope px-1"></i></a>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="profile-label">Cellphone Number:</span></td>
                                                            <td>
                                                                <span class="d-flex justify-content-between">
                                                                    {{ $staff->contact_number }}
                                                                    @if(!empty($staff->contact_number))
                                                                        <a href="tel:{{ $staff->contact_number }}" title="Call"><i class="icon-mobile px-2"></i></a>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @if(!empty($staff->other_number))
                                                            @php
                                                                $number_arrs = explode('::', $staff->other_number);
                                                                $type_arrs = explode('::', $staff->type_number);
                                                                $type_number_name = config('numbertype.'.$staff->type_number);
                                                                $count = count($number_arrs);
                                                            @endphp

                                                            @for($a = 0; $a < $count; $a++)
                                                            <tr>
                                                                <td><span class="profile-label">{{config('numbertype.'.$type_arrs[$a])}} Number:</span></td>
                                                                <td>
                                                                    <span>
                                                                        {{$number_arrs[$a]}}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @endfor
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <p>No staff for this old user.</p>
                                    @endif
                                @endif

                                <!-- For usertype no staff only -->
                                @if($memberDetails->user_type > 4)
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
                                                        <td><span class="text-uppercase">{{ $userTypeMember->firstname }}  {{ $userTypeMember->suffix }} @if(!empty($userTypeMember->suffix)) . @endif {{ $userTypeMember->lastname }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="profile-label">Nickname:</span></td>
                                                        <td><span class="text-uppercase">{{ $userTypeMember->nickname }}</span></td>
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
                                                        <td>
                                                            <span class="d-flex justify-content-between">
                                                                {{ $userTypeMember->email }}
                                                                <a href="mailto:{{ $userTypeMember->email }}" title="send an email"><i class="icon-envelope px-1"></i></a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="profile-label">Cellphone Number:</span></td>
                                                        <td>
                                                            <span class="d-flex justify-content-between">
                                                                {{ $userTypeMember->contact_number }}
                                                                <a href="tel:{{ $userTypeMember->contact_number }}" title="Call"><i class="icon-mobile px-2"></i></a>
                                                            </span>
                                                        </td>
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
                                @endif

                            </div>

                            <div class="row" id="edit_profile_panel" style="display: none;">
                                <form id="profile_update_form" action="{{ route('member.profile.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                        @if($memberDetails->user_type == 5 || $memberDetails->user_type == 7)
                                            <!-- nothing for now.. -->
                                        @else
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
                                        @endif

                                        <!-- 1st Column -->
                                        <div class="col-12 col-md-5">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <input class="form-control text-uppercase" type="text" name="firstname" value="{{ $memberDetails->firstname }}" placeholder="FIRST NAME">
                                                    </div>
                                                    <div class="col-2" style="padding-left: 0px;">
                                                        <input class="form-control" type="text" name="middle_initial" value="{{ $memberDetails->middle_initial }}" placeholder="M.I.">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <input class="form-control text-uppercase" type="text" name="lastname" value="{{ $memberDetails->lastname }}" placeholder="LAST NAME">
                                                    </div>
                                                    <div class="col-2" style="padding-left: 0px;">
                                                        <select class="form-select" name="suffix">
                                                            <option selected disabled>SUFFIX</option>
                                                            <option @if($memberDetails->suffix == 'Jr') selected  @endif>Jr</option>
                                                            <option @if($memberDetails->suffix == 'Sr') selected  @endif>Sr</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="form-control" type="text" name="nickname" value="{{ $memberDetails->nickname }}" placeholder="NICKNAME">
                                                    </div>
                                                </div>
                                            </div>
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

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="form-control" type="text" name="contact_number" value="{{ $memberDetails->contact_number }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    @php
                                                        $bday = explode(' ',$memberDetails->birthdate);
                                                        $month = $bday[0];
                                                        $day = $bday[1];
                                                    @endphp
                                                    <div class="col-6">
                                                        <select class="form-select" name="gender">
                                                            <option selected disabled>GENDER</option>
                                                            @foreach($genders as $gender)
                                                                <option @if($memberDetails->gender == $gender->id) selected @endif value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6" style="padding-left: 0px;">
                                                        <div class="d-flex">
                                                            <select class="form-select" aria-label="select month" name="month" style="width: 70%">
                                                                <option value="0">BIRTHMONTH</option>
                                                                @foreach(Config::get('months') as $key => $month)
                                                                <option @if($month == $month) selected @endif value="{{ $key }}">{{ $month }}</option>
                                                                @endforeach
                                                            </select>
                                                            &nbsp;
                                                            <select class="form-select" aria-label="select day" name="day" style="width: 30%">
                                                                <option value="0">BIRTHDAY</option>
                                                                @for($d = 1; $d <= 31; $d++)
                                                                <option @if($day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!$memberDetails->user_type == 5)
                                            <small><i><span class="text-danger">Disclaimer:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</i></small>
                                            @endif

                                        </div>

                                        <!-- 2nd Column -->
                                        <div class="col-12 col-md-5">

                                            @if(!empty($memberDetails->cluster))
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
                                            @endif

                                            @if($memberDetails->user_type == 5)
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 d-flex flex-column">
                                                        <input class="form-control mb-3" type="text" name="user_type" value="{{ $memberDetails->userType->name }}">
                                                        <input class="form-control mb-3" type="text" name="congsec_type" value="{{ $memberDetails->congsec_type }}">
                                                        <input class="form-control mb-3" type="text" name="committee_type" value="{{ $memberDetails->committee_type }}">
                                                        <input class="form-control mb-3" type="text" name="committee_standing" value="{{ $memberDetails->committee_standing }}">
                                                        <input class="form-control mb-3" type="text" name="committee_special" value="{{ $memberDetails->committee_special }}">
                                                        <input class="form-control mb-3" type="text" name="chairperson" value="{{ $memberDetails->chairperson }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </div>

                                        <!-- Edit for usertypes that has staff only -->
                                        @if($memberDetails->user_type < 5)
                                            @if(!empty($staffs))
                                                @foreach($staffs as $index => $staff)
                                                    <div class="tab-content">
                                                        <div class="row mt-4">
                                                            <input type="hidden" id="staffProfPic{{$index}}" name="staff[{{$index}}][staff_id]" value="{{ $staff->id }}">
                                                            <small class="form-title my-0" style="transform: translate(0px, -6px);">
                                                                <b class="text-uppercase">{{ $staff->designation }}</b>
                                                            </small>
                                                            <div class="col-12 col-md-2 d-flex align-items-start justify-content-center">
                                                                <div class="text-center mb-4 position-relative">
                                                                    <div class="file-input-wrapper photo">
                                                                        <input type="file" class="form-control staff-prof-pic" data-index="{{ $index }}" id="photo{{$index}}" name="staff[{{$index}}][photo]" accept="image/*">
                                                                        <label for="photo" class="file-input-label">
                                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                              <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 18V8a1 1 0 0 1 1-1h1.5l1.707-1.707A1 1 0 0 1 8.914 5h6.172a1 1 0 0 1 .707.293L17.5 7H19a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z"/>
                                                                              <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                                            </svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class="profile-pic-preview-container">
                                                                        <img id="imagePreviewPhoto{{$index}}"
                                                                             src="{{ $staff->photo ? asset('/' . $staff->photo) : asset('images/user.png') }}"
                                                                             class="profile-pic-preview" alt="Profile Picture Preview"
                                                                             style="border-radius: 100%;">

                                                                    </div>
                                                                    @error('photo')
                                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-5">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-10">
                                                                            <input class="form-control text-uppercase" type="text" name="staff[{{$index}}][firstname]" value="{{ $staff->firstname }}" placeholder="FIRST NAME">
                                                                        </div>
                                                                        <div class="col-2" style="padding-left: 0px;">
                                                                            <input class="form-control" type="text" name="staff[{{$index}}][middle_initial]" value="{{ $staff->middle_initial }}" placeholder="M.I.">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-10">
                                                                            <input class="form-control text-uppercase" type="text" name="staff[{{$index}}][lastname]" value="{{ $staff->lastname }}" placeholder="LAST NAME">
                                                                        </div>
                                                                        <div class="col-2" style="padding-left: 0px;">
                                                                            <select class="form-select" name="staff[{{$index}}][suffix]">
                                                                                <option selected disabled value="">SUFFIX</option>
                                                                                <option @if($staff->suffix == 'Jr') selected  @endif>Jr</option>
                                                                                <option @if($staff->suffix == 'Sr') selected  @endif>Sr</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text" name="staff[{{$index}}][nickname]" value="{{ $staff->nickname }}" placeholder="NICKNAME">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        @if(!empty($staff->birthday))
                                                                            @php
                                                                                $bday = explode(' ',$staff->birthday);
                                                                                $month = $bday[0];
                                                                                $day = $bday[1];
                                                                            @endphp
                                                                        @endif
                                                                        <div class="col-6">
                                                                            <select class="form-select" name="staff[{{$index}}][gender]">
                                                                                <option selected disabled value="0">GENDER</option>
                                                                                @if(!empty($staff->gender))
                                                                                    @foreach($genders as $gender)
                                                                                        <option @if($staff->gender == $gender->id) selected @endif value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                                                    @endforeach
                                                                                @else
                                                                                    @foreach($genders as $gender)
                                                                                        <option value="{{ $gender->id }}" >{{$gender->name}}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6" style="padding-left: 0px;">
                                                                            <div class="d-flex">
                                                                                <select class="form-select" aria-label="select month" name="staff[{{$index}}][month]" style="width: 70%">
                                                                                    <option @if($month == 0) selected @endif value="0">BIRTHMONTH</option>
                                                                                    @if(!empty($staff->birthday))
                                                                                        @foreach(Config::get('months') as $key => $month)
                                                                                            <option @if($month == $month) selected @endif value="{{ $key }}">{{ $month }}</option>
                                                                                        @endforeach
                                                                                    @else
                                                                                        @foreach(Config::get('months') as $key => $month)
                                                                                            <option value="{{ $key }}">{{ $month }}</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                                &nbsp;
                                                                                <select class="form-select" aria-label="select day" name="staff[{{$index}}][day]" style="width: 30%">
                                                                                    <option value="0">BIRTHDAY</option>
                                                                                    @if(!empty($staff->birthday))
                                                                                        @for($d = 1; $d <= 31; $d++)
                                                                                            <option @if($day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
                                                                                        @endfor
                                                                                    @else
                                                                                        @for($d = 1; $d <= 31; $d++)
                                                                                            <option value="{{ $d }}">{{ $d }}</option>
                                                                                        @endfor
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-5">

                                                                <input class="form-control" type="text" name="staff[{{$index}}][email]" value="{{ $staff->email }}" placeholder="EMAIL">
                                                                <div class="row mb-3">
                                                                    <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                                        <input type="checkbox" name="staff[{{$index}}][agree_email]" @if($staff->agree_email) checked @endif>
                                                                        <small class="my-2">Agree to show email in <span class="text-primary ">Directory</span></small>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="text" name="staff[{{$index}}][contact_number]" value="{{ $staff->contact_number }}" placeholder="CONTACT NUMBER">
                                                                <div class="row mb-3">
                                                                    <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                                        <input type="checkbox" name="staff[{{$index}}][agree_contact_number]" @if($staff->agree_contact_number) checked @endif>
                                                                        <small class="my-2">Agree to show contact number in <span class="text-primary ">Directory</span></small>
                                                                    </div>
                                                                </div>

                                                                @if(!empty($staff->other_number))
                                                                    @php
                                                                        $type_arrs = explode('::', $staff->type_number);
                                                                        $number_arrs = explode('::', $staff->other_number);
                                                                        $type_number_name = config('numbertype.'.$staff->type_number);
                                                                        $count = count($number_arrs);
                                                                    @endphp

                                                                    @for($ar = 0; $ar < $count; $ar++)
                                                                    <div class="row form-group">
                                                                        <div class="col-12 relative">
                                                                            <select id="select_number_solo{{$index}}" class="form-select select-type-number" aria-label="select type of number" name="staff[{{$index}}][type_number][]">
                                                                                <option @if($type_arrs[$ar] == 1) selected @endif value="1">Viber</option>
                                                                                <option @if($type_arrs[$ar] == 2) selected @endif value="2">WhatsApp</option>
                                                                                <option @if($type_arrs[$ar] == 3) selected @endif value="3">Telegram</option>
                                                                                <option @if($type_arrs[$ar] == 4) selected @endif value="4">Signal</option>
                                                                                <option @if($type_arrs[$ar] == 5) selected @endif value="5">WeChat</option>
                                                                            </select>
                                                                            <input class="form-control" type="text" name="staff[{{$index}}][other_number][]" required style="padding-left: 140px;" value="{{$number_arrs[$ar]}}">
                                                                            <div id="messaging_container{{$index}}">
                                                                                <!-- area for additional fields -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endfor
                                                                @else
                                                                <div class="row form-group">
                                                                    <div class="col-12 relative">
                                                                        <select id="select_number_solo{{$index}}" class="form-select select-type-number" aria-label="select type of number" name="staff[{{$index}}][type_number][]">
                                                                            <option value="1">Viber</option>
                                                                            <option value="2">WhatsApp</option>
                                                                            <option value="3">Telegram</option>
                                                                            <option value="4">Signal</option>
                                                                            <option value="5">WeChat</option>
                                                                        </select>
                                                                        <input class="form-control" type="text" name="staff[{{$index}}][other_number][]" required style="padding-left: 140px;">
                                                                        <div id="messaging_container{{$index}}">
                                                                            <!-- area for additional fields -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <small onclick="add_messaging({{$index}})" id="add_messaging" class="primary-text-color float-end pt-1 cursor-pointer">Add Instant Messaging Number</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                            <p>No staff for this old user.</p>
                                            @endif
                                        @endif
                                        <!-- End Edit Senators Staff and HoR Staff only -->

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
                                            <td><span><small>{{ $memberDetails->senatorOfficial->nickname }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->senatorOfficial->email_agree)
                                                        <small class="form-title"><b>{{ $memberDetails->senatorOfficial->email }}</b></small>
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
                                                    @if($memberDetails->senatorOfficial->landline_agree)
                                                        <small>{{ $memberDetails->senatorOfficial->landline }}</small>
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
                                                    @if($memberDetails->senatorOfficial->office_cellphone_agree)
                                                        <small>{{ $memberDetails->senatorOfficial->office_cellphone }}</small>
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
                                            <td><span><small>{{ $memberDetails->senatorOfficial->main_room_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Direct Line: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->main_direct_line }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Fax Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->main_fax_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Trunk Local Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->main_trunk_local_number }}</small></span></td>
                                        </tr>
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Social Media</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Facebook: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->facebook }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Twitter: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->twitter }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Instagram: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->instagram }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Youtube: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->youtube }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Senate Group:</small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->group }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Political Party:</small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->party }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->gender }}</small></span></td>
                                        </tr>
                                        @if(!empty($memberDetails->senatorOfficial->month) && !empty($memberDetails->senatorOfficial->day))
                                        <tr>
                                            <td><span class="profile-label"><small>BirthDate: </small></span></td>
                                            <td>
                                                <span>
                                                    <small>
                                                        {{ config('months.'.$memberDetails->senatorOfficial->month) }} &nbsp; {{ $memberDetails->senatorOfficial->day }}
                                                    </small>
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>

                                    <small class="form-title"><b class="text-uppercase">Extension Room</b></small>
                                    <table class="table-dotted table-striped mt-2">
                                        <tr>
                                            <td><span class="profile-label"><small>Room Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->extension_room_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Direct Line: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->extension_direct_line }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Fax Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->extension_fax_number }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Trunk Local Number: </small></span></td>
                                            <td><span><small>{{ $memberDetails->senatorOfficial->extension_trunk_local_number }}</small></span></td>
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
                                                            <input class="form-control text-uppercase" type="text" name="firstname" value="{{ $memberDetails->senatorOfficial->firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="middle_initial" value="{{ $memberDetails->senatorOfficial->middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control text-uppercase" type="text" name="lastname" value="{{ $memberDetails->senatorOfficial->lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option @if($memberDetails-> senatorOfficial->suffix == 'Jr') selected  @endif>Jr</option>
                                                                <option @if($memberDetails-> senatorOfficial->suffix == 'Sr') selected  @endif>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="nickname" value="{{ $memberDetails->senatorOfficial->nickname }}" placeholder="NICKNAME">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="email" value="{{ $memberDetails->senatorOfficial->email }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="email_agree" @if($memberDetails->senatorOfficial->email_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="landline" value="{{ $memberDetails->senatorOfficial->landline }}" placeholder="OFFICE LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="landline_agree" @if($memberDetails->senatorOfficial->sen_landline_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="office_cellphone" value="{{ $memberDetails->senatorOfficial->office_cellphone }}" placeholder="OFFICE CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="office_cellphone_agree" @if($memberDetails->senatorOfficial->office_cellphone_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <select class="form-select" name="group">
                                                        <option selected disabled>MAJORITY/MINORITY/INDEPENDENT</option>
                                                        <option @if($memberDetails->senatorOfficial->group == 'MAJORITY') selected  @endif>MAJORITY</option>
                                                        <option @if($memberDetails->senatorOfficial->group == 'MINORITY') selected  @endif>MINORITY</option>
                                                        <option @if($memberDetails->senatorOfficial->group == 'INDEPENDENT') selected  @endif>INDEPENDENT</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-select" name="party">
                                                        <option selected disabled>POLITICAL PARTY</option>
                                                        <option @if($memberDetails->senatorOfficial->party == 'PDP') selected  @endif>PDP</option>
                                                        <option @if($memberDetails->senatorOfficial->party == 'LIBERAL') selected  @endif>LIBERAL</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-select" name="gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->senatorOfficial->gender == $gender->name) selected @endif value="{{ $gender->name }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if(!empty($memberDetails->senatorOfficial->month))
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <div class="d-flex">
                                                                <select class="form-select" aria-label="select month" name="month" style="width: 70%">
                                                                    <option value="0">BIRTHMONTH</option>
                                                                    @foreach(Config::get('months') as $key => $cmonth)
                                                                    <option @if($month == $cmonth) selected @endif value="{{ $month }}">{{ $cmonth }}</option>
                                                                    @endforeach
                                                                </select>
                                                                &nbsp;
                                                                <select class="form-select" aria-label="select day" name="day" style="width: 30%">
                                                                    <option value="0">BIRTHDAY</option>
                                                                    @for($d = 1; $d <= 31; $d++)
                                                                    <option @if($day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @endif
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
                                                            <input class="form-control" type="text" name="facebook" value="{{ $memberDetails->senatorOfficial->facebook }}" placeholder="FACEBOOK">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="twitter" value="{{ $memberDetails->senatorOfficial->twitter }}" placeholder="TWITTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="instagram" value="{{ $memberDetails->senatorOfficial->instagram }}" placeholder="INSTAGRAM">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="youtube" value="{{ $memberDetails->senatorOfficial->youtube }}" placeholder="YOUTUBE">
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
                                                            <input class="form-control" type="text" name="main_room_number" value="{{ $memberDetails->senatorOfficial->main_room_number }}" placeholder="ROOM NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="main_direct_line" value="{{ $memberDetails->senatorOfficial->main_direct_line }}" placeholder="DIRECT LINE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="main_fax_number" value="{{ $memberDetails->senatorOfficial->main_fax_number }}" placeholder="FAX NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="main_trunk_local_number" value="{{ $memberDetails->senatorOfficial->main_trunk_local_number }}" placeholder="TRUNK LOCAL NUMBER">
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
                                                            <input class="form-control" type="text" name="extension_room_number" value="{{ $memberDetails->senatorOfficial->extension_room_number }}" placeholder="ROOM NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="extension_direct_line" value="{{ $memberDetails->senatorOfficial->extension_direct_line }}" placeholder="DIRECT LINE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="extension_fax_number" value="{{ $memberDetails->senatorOfficial->extension_fax_number }}" placeholder="FAX NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="extension_trunk_local_number" value="{{ $memberDetails->senatorOfficial->extension_trunk_local_number }}" placeholder="TRUNK LOCAL NUMBER">
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
                                                            <input class="form-control text-uppercase" type="text" name="spouse_firstname" value="{{ $memberDetails->senatorOfficial->spouse_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="spouse_middle_initial" value="{{ $memberDetails->senatorOfficial->spouse_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control text-uppercase" type="text" name="spouse_lastname" value="{{ $memberDetails->senatorOfficial->spouse_lastname }}" placeholder="LAST NAME">
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
                                                            <select class="form-select" name="spouse_gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->senatorOfficial->spouse_gender == $gender->name) selected @endif value="{{ $gender->name }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="spouse_birthday" value="{{ $memberDetails->senatorOfficial->spouse_birthday }}" placeholder="BIRTHDAY">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- need changes here soon -->
                                                <div class="form-group">
                                                    <select class="form-select" name="spouse_profession">
                                                        <option selected disabled>PROFESSION</option>
                                                        <option value="TEACHE">TEACHER</option>
                                                        <option value="TECHNOLOG">TECHNOLOGY</option>
                                                        <option value="GOVERNMEN">GOVERNMENT</option>
                                                    </select>
                                                </div>
                                               
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="spouse_office_address" value="{{ $memberDetails->senatorOfficial->spouse_office_address }}" placeholder="OFFICE ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="spouse_email_address" value="{{ $memberDetails->senatorOfficial->spouse_email_address }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="spouse_landline_number" value="{{ $memberDetails->senatorOfficial->spouse_landline_number }}" placeholder="LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="spouse_cellphone_number" value="{{ $memberDetails->senatorOfficial->spouse_cellphone_number }}" placeholder="CELLPHONE NUMBER*" required>
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
                                            <td><span><small>{{ $memberDetails->horOfficial->nickname }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td>
                                                <span>
                                                    @if($memberDetails->horOfficial->email_agree)
                                                        <small class="form-title"><b>{{ $memberDetails->horOfficial->email }}</b></small>
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
                                                    @if($memberDetails->horOfficial->landline_agree)
                                                        <small>{{ $memberDetails->horOfficial->landline }}</small>
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
                                                    @if($memberDetails->horOfficial->office_cellphone_agree)
                                                        <small>{{ $memberDetails->horOfficial->office_cellphone }}</small>
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
                                            <td><span><small>{{ $memberDetails->horOfficial->facebook }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Twitter: </small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->twitter }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Instagram: </small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->instagram }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Youtube: </small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->youtube }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr>
                                            <td><span class="profile-label"><small>Province | Partylist:</small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->province }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>District:</small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->district }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Region:</small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->region }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Senate Group:</small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->group }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Political Party:</small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->party }}</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>@if(!empty($memberDetails->horOfficial->gender)){{ $memberDetails->horOfficial->gender}}@endif</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>BirthDate: </small></span></td>
                                            <td><span><small>{{ $memberDetails->horOfficial->month }} &nbsp; {{ $memberDetails->horOfficial->day }}</small></span></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            <div class="row" id="edit_hor_panel" style="display: none;">
                                <form id="hor_update_form" action="{{ route('member.profile.hor.update', $memberDetails->horOfficial->id ) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <small class="form-title"><b>DETAILS THAT ARE VISIBLE IN DIRECTORY</b></small>
                                        <br />
                                        <div class="col-12 d-flex">

                                            <div class="col-6">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control text-uppercase" type="text" name="firstname" value="{{ $memberDetails->horOfficial->firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="middle_initial" value="{{ $memberDetails->horOfficial->middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control text-uppercase" type="text" name="lastname" value="{{ $memberDetails->horOfficial->lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option @if($memberDetails->horOfficial->suffix == 'Jr') selected  @endif>Jr</option>
                                                                <option @if($memberDetails->horOfficial->suffix == 'Sr') selected  @endif>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="nickname" value="{{ $memberDetails->horOfficial->nickname }}" placeholder="NICKNAME">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="email" value="{{ $memberDetails->horOfficial->email }}" placeholder="EMAIL ADDRESS*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="email_agree" @if($memberDetails->horOfficial->email_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="landline" value="{{ $memberDetails->horOfficial->landline }}" placeholder="OFFICE LANDLINE NUMBER*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="landline_agree" @if($memberDetails->horOfficial->landline_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="office_cellphone" value="{{ $memberDetails->horOfficial->office_cellphone }}" placeholder="OFFICE CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-start gap-2">
                                                            <input type="checkbox" name="office_cellphone_agree" @if($memberDetails->horOfficial->office_cellphone_agree) checked @endif>
                                                            <small class="my-2">Agree to show in <span class="text-primary ">Senator's Directory</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 px-4">
                                                <div class="form-group">
                                                    <select class="form-select" name="group">
                                                        <option selected disabled>MAJORITY/MINORITY/INDEPENDENT</option>
                                                        <option @if($memberDetails->horOfficial->group == 'MAJORITY') selected  @endif>MAJORITY</option>
                                                        <option @if($memberDetails->horOfficial->group == 'MINORITY') selected  @endif>MINORITY</option>
                                                        <option @if($memberDetails->horOfficial->group == 'INDEPENDENT') selected  @endif>INDEPENDENT</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-select" name="party">
                                                        <option selected disabled>POLITICAL PARTY</option>
                                                        <option value="PDP">PDP</option>
                                                        <option value="LIBERAL">LIBERAL</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-select" name="gender">
                                                                <option selected disabled>GENDER</option>
                                                                @foreach($genders as $gender)
                                                                    <option @if($memberDetails->horOfficial->gender == $gender->name) selected @endif value="{{ $gender->name }}" >{{$gender->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <div class="d-flex">
                                                                <select class="form-select" aria-label="select month" name="month" style="width: 70%">
                                                                    <option value="0">BIRTHMONTH</option>
                                                                    @foreach(Config::get('months') as $cmonth)
                                                                    <option @if($memberDetails->horOfficial->$month == $cmonth) selected @endif value="{{ $cmonth }}">{{ $cmonth }}</option>
                                                                    @endforeach
                                                                </select>
                                                                &nbsp;
                                                                <select class="form-select" aria-label="select day" name="day" style="width: 30%">
                                                                    <option value="0">BIRTHDAY</option>
                                                                    @for($d = 1; $d <= 31; $d++)
                                                                    <option @if($memberDetails->horOfficial->$day == $d) selected @endif value="{{ $d }}">{{ $d }}</option>
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
                                                            <input class="form-control" type="text" name="facebook" value="{{ $memberDetails->horOfficial->facebook }}" placeholder="FACEBOOK">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="twitter" value="{{ $memberDetails->horOfficial->twitter }}" placeholder="TWITTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="instagram" value="{{ $memberDetails->horOfficial->instagram }}" placeholder="INSTAGRAM">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="youtube" value="{{ $memberDetails->horOfficial->youtube }}" placeholder="YOUTUBE">
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
                                                            <input class="form-control" type="text" name="resident_address" value="{{ $memberDetails->horOfficial->resident_address }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="resident_email" value="{{ $memberDetails->horOfficial->resident_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="resident_landline" value="{{ $memberDetails->horOfficial->resident_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="resident_cellphone" value="{{ $memberDetails->horOfficial->resident_cellphone }}" placeholder="CELLPHONE NUMBER">
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
                                                            <input class="form-control" type="text" name="province_address" value="{{ $memberDetails->horOfficial->province_address }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="province_email" value="{{ $memberDetails->horOfficial->province_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="province_landline" value="{{ $memberDetails->horOfficial->province_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="province_cellphone" value="{{ $memberDetails->horOfficial->province_cellphone }}" placeholder="CELLPHONE NUMBER">
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
                                                            <input class="form-control" type="text" name="resident_address" value="{{ $memberDetails->horOfficial->resident_address }}" placeholder="ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="resident_email" value="{{ $memberDetails->horOfficial->resident_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="province_landline" value="{{ $memberDetails->horOfficial->province_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="province_cellphone" value="{{ $memberDetails->horOfficial->province_cellphone }}" placeholder="CELLPHONE NUMBER">
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
                                                            <input class="form-control" type="text" name="highest_education" value="{{ $memberDetails->horOfficial->highest_education }}" placeholder="HIGHEST EDUCATIONAL ATTAINMENT COURSE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="school" value="{{ $memberDetails->horOfficial->school }}" placeholder="SCHOOL">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="prev_work_gov" value="{{ $memberDetails->horOfficial->prev_work_gov }}" placeholder="PREVIOUS WORK: GOVERNMENT">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="prev_work_private" value="{{ $memberDetails->horOfficial->prev_work_private }}" placeholder="PREVIOUS WORK: PRIVATE">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="religion" value="{{ $memberDetails->horOfficial->religion }}" placeholder="RELIGION">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="civic" value="{{ $memberDetails->horOfficial->civic }}" placeholder="CIVIC ORGANIZATIONAL AFFILIATION">
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
                                                            <input class="form-control text-uppercase" type="text" name="spouse_firstname" value="{{ $memberDetails->horOfficial->spouse_firstname }}" placeholder="FIRST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="spouse_middle_initial" value="{{ $memberDetails->horOfficial->spouse_middle_initial }}" placeholder="M.I.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <input class="form-control text-uppercase" type="text" name="spouse_lastname" value="{{ $memberDetails->horOfficial->spouse_lastname }}" placeholder="LAST NAME">
                                                        </div>
                                                        <div class="col-2" style="padding-left: 0px;">
                                                            <select class="form-select" name="spouse_suffix">
                                                                <option selected disabled>SUFFIX</option>
                                                                <option>Jr</option>
                                                                <option>Sr</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <small><i>Wedding Aniversary</i></small>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input class="form-control" type="date" name="spouse_wedding_aniv" value="{{ $memberDetails->horOfficial->spouse_wedding_aniv }}" placeholder="WEDDING ANNIVERSARY">
                                                        </div>
                                                        <div class="col-6" style="padding-left: 0px;">
                                                            <input class="form-control" type="text" name="spouse_birthday" value="{{ $memberDetails->horOfficial->spouse_birthday }}" placeholder="BIRTHDAY">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="spouse_civic" value="{{ $memberDetails->horOfficial->spouse_civic }}" placeholder="CIVIC ORGANIZATIONAL AFFILIATION">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                   <input class="form-control" type="text" name="spouse_profession" value="{{ $memberDetails->horOfficial->spouse_profession }}" placeholder="PROFESSION">
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
                                                            <input class="form-control" type="text" name="child_name" value="{{ $memberDetails->horOfficial->child_name }}" placeholder="NAME">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="child_email" value="{{ $memberDetails->horOfficial->child_email }}" placeholder="EMAIL ADDRESS">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="child_landline" value="{{ $memberDetails->horOfficial->child_landline }}" placeholder="LANDLINE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="child_cellphone" value="{{ $memberDetails->horOfficial->child_cellphone }}" placeholder="CELLPHONE NUMBER">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input class="form-control" type="text" name="child_profession" value="{{ $memberDetails->horOfficial->child_profession }}" placeholder="PROFESSION">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="col-12 d-flex">
                                            <button type="button" class="w-100 btn btn-secondary rounded shadow text-center"> ADD CHILDREN </button>
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
                                            Attending key events provides valuable opportunities for knowledge sharing, networking, and collaboration, enhancing capacity to implement effective and informed policy reforms.
                                            <br>
                                            &nbsp;
                                        </small>
                                    </tr>
                                    @forelse($events as $event)
                                    <tr>
                                        <td><span><small>{{ $event->event->date }}</small></span></td>
                                        <td>
                                            <span class="primary-text-color">
                                                <small>
                                                    <a href="/events/view/{{ $event->event->id }}">{{ $event->event->title }}</a>
                                                </small>
                                            </span>
                                        </td>
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
                                            Reference materials serve as essential tools for informed decision-making, offering evidence-based insights, best practices, and contextual understanding to support effective policy development and implementation.
                                        <br>
                                        &nbsp;
                                        </small>
                                    </tr>
                                    @forelse($references as $reference)
                                    <tr>
                                        <td><span><small>{{ date('F d, Y', strtotime($reference->created_at)) }}</small></span></td>
                                        <td><span class="primary-text-color"><small class="primary-text-color">{{ $reference->subject }}</small></span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <small><i>No reference materials for now.</i></small>
                                        </td>
                                    </tr>
                                    @endforelse
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
                                            Policy reform is essential to modernize outdated systems, promote transparency and equity, and ensure that governance remains responsive, inclusive, and sustainable in addressing current and future societal needs.
                                        <br>
                                        <br>
                                        <small><b class="primary-text-color">MY SAVED BILL/S</b></small>
                                        </small>
                                    </tr>
                                    @forelse($policy_reforms as $policy_reform)
                                    <tr>
                                        <td>
                                            <span class="primary-text-color">
                                                <small>
                                                    <a href="/policy-reform-view/{{ $policy_reform->policyReform->id }}" class="primary-text-color">
                                                        {{ $policy_reform->policyReform->title }}
                                                    </a>
                                                </small>
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <br />
                                    <small><i style="opacity: .7;">No saved bill/s for now.</i></small>
                                    @endforelse
                                </table>
                            </div>
                        </div>

                        <!-- Saved Contacts Tab -->
                        <div class="tab-pane fade" id="saved-border" role="tabpanel" aria-labelledby="tab-saved-border-tab" tabindex="0">
                            <div class="col-12">
                                <small>
                                    Saved contacts are crucial for building a strong network of stakeholders, enabling continued collaboration, information exchange, and support for policy reform initiatives.
                                <br>
                                </small>
                                <div class="my-2 d-flex flex-wrap">

                                    <!-- Members normal users list of contacts -->
                                    @forelse($saved_contacts as $saved_contact)
                                        <div class="col-6">
                                            <div class="saved-container">
                                                <div class="card border-0 card-saved-contacts cursor-pointer">
                                                    <div class="card-body">
                                                        <div class="col-12 d-flex">
                                                            <div class="col-3 text-center">
                                                                <img class="rounded border-none shadow" width="120" style="border-radius: 100%;
                                                                                    min-width: 120px;
                                                                                    height: 120px;
                                                                                    background-image: url('{{ $saved_contact->member->photo ? asset('/' . $saved_contact->member->photo) : asset('images/user.png') }}');
                                                                                    background-size: cover;
                                                                                    background-repeat: no-repeat;
                                                                                    background-position: center;
                                                                                    ">
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
                                                                        &nbsp; <small class="primary-text-color text-capitalize">{{ $saved_contact->member->FullName }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-users" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp;
                                                                        <small style="display: inline-grid;" class="text-uppercase">
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
                                                                    <!-- <a data-bs-toggle="modal" data-bs-target="#sendMessageModal" title="Message" style="color: gray !important;"><i class="icon-chat"></i></a> -->
                                                                    <a href="tel:{{$saved_contact->member->contact_number}}" title="Call" style="color: gray !important;"><i class="icon-mobile"></i></a>
                                                                    <a class="cursor-pointer trash-contact-btn" data-bs-toggle="modal" data-bs-target="#removeContactModal" data-id="{{ $saved_contact->member->id }}" title="Remove" style="color: #ff4d4d !important;"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <!-- nothing for now -->
                                    @endforelse

                                    <!-- Officials list of cantacts-->
                                    @forelse($saved_contacts_official as $saved_contact_official)
                                        <div class="col-6">
                                            <div class="saved-container">
                                                <div class="card border-0 card-saved-contacts cursor-pointer">
                                                    <div class="card-body">
                                                        <div class="col-12 d-flex">
                                                            <div class="col-3 text-center">
                                                                <img class="rounded border-none shadow" width="120" style="border-radius: 100%;
                                                                                    min-width: 120px;
                                                                                    height: 120px;
                                                                                    background-image: url('{{ $saved_contact_official->official->image_url ? asset('/' . $saved_contact_official->official->image_url) : asset('images/user.png') }}');
                                                                                    background-size: cover;
                                                                                    background-repeat: no-repeat;
                                                                                    background-position: center;
                                                                                    ">
                                                            </div>
                                                            <div class="col-9">
                                                                <ul class="list-unstyled">
                                                                    <li>
                                                                        <small>
                                                                            <b class="primary-text-color text-uppercase">{{ $saved_contact_official->official->position }}</b>
                                                                        </small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-user" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color text-capitalize">{{ $saved_contact_official->official->FullName }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-call" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp;<small>{{ $saved_contact_official->official->office_cellphone }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-envelope" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color">{{ $saved_contact_official->official->email }}</small>
                                                                    </li>
                                                                </ul>

                                                                <div class="utility-btns align-items-center gap-2">
                                                                    <!-- <a data-bs-toggle="modal" data-bs-target="#sendMessageModal" title="Message" style="color: gray !important;"><i class="icon-chat"></i></a> -->
                                                                    <a href="tel:{{$saved_contact_official->official->office_cellphone}}" title="Call" style="color: gray !important;"><i class="icon-mobile"></i></a>
                                                                    <a class="cursor-pointer trash-contact-official-btn" data-bs-toggle="modal" data-bs-target="#removeContactOfficialModal" data-id="{{ $saved_contact_official->official->id }}" title="Remove" style="color: #ff4d4d !important;"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <!-- nothing for now -->
                                    @endforelse

                                    <!-- Staffs list of contacts -->
                                    @forelse($saved_contacts_staff as $saved_contact_staff)
                                        <div class="col-6">
                                            <div class="saved-container">
                                                <div class="card border-0 card-saved-contacts cursor-pointer">
                                                    <div class="card-body">
                                                        <div class="col-12 d-flex">
                                                            <div class="col-3 text-center">
                                                                <img class="rounded border-none shadow" width="120" style="border-radius: 100%;
                                                                                    min-width: 120px;
                                                                                    height: 120px;
                                                                                    background-image: url('{{ $saved_contacts_staff->staff->image_url ? asset('/' . $saved_contacts_staff->staff->image_url) : asset('images/user.png') }}');
                                                                                    background-size: cover;
                                                                                    background-repeat: no-repeat;
                                                                                    background-position: center;
                                                                                    ">
                                                            </div>
                                                            <div class="col-9">
                                                                <ul class="list-unstyled">
                                                                    <li>
                                                                        <small>
                                                                            <b class="primary-text-color text-uppercase">{{ saved_contacts_staff->staff->position }}</b>
                                                                        </small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-user" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color text-capitalize">{{ saved_contacts_staff->staff->FullName }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-call" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp;<small>{{ saved_contacts_staff->staff->office_cellphone }}</small>
                                                                    </li>
                                                                    <li>
                                                                        <i class="icon-envelope" style="font-size: 14px; color: gray;"></i>
                                                                        &nbsp; <small class="primary-text-color">{{ saved_contacts_staff->staff->email }}</small>
                                                                    </li>
                                                                </ul>

                                                                <div class="utility-btns align-items-center gap-2">
                                                                    <!-- <a data-bs-toggle="modal" data-bs-target="#sendMessageModal" title="Message" style="color: gray !important;"><i class="icon-chat"></i></a> -->
                                                                    <a href="tel:{{saved_contacts_staff->staff->office_cellphone}}" title="Call" style="color: gray !important;"><i class="icon-mobile"></i></a>
                                                                    <a class="cursor-pointer trash-contact-official-btn" data-bs-toggle="modal" data-bs-target="#removeContactStaffModal" data-id="{{ saved_contacts_staff->staff->id }}" title="Remove" style="color: #ff4d4d !important;"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <!-- nothing for now -->
                                    @endforelse

                                    @if(count($saved_contacts) < 1 && count($saved_contacts_official) < 1 && count($saved_contacts_staff) < 1)
                                        <p>No contacts saved for now.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <small><i><span class="text-danger">Disclaimer for Data Privacy: </span>All personal data collected will be handled in accordance with applicable data privacy laws and will be used solely for legitimate and authorized purposes.</i></small>
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
                            <form method="post" action="{{ route('member.profile.account.delete') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="member_id" value="{{ $memberDetails->id }}">
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

                    <!-- Trash Contact Official -->
                    <div class="modal fade" id="removeContactOfficialModal" tabindex="-1" aria-labelledby="removeContactOfficialLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="removeContactOfficialModalLabel">Remove Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to remove this contact?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="{{ route('member.profile.remove.contact.official') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" id="trash-user-id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="official_id" id="trash-contact-official-id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Trash Contact Staff -->
                    <div class="modal fade" id="removeContactStaffModal" tabindex="-1" aria-labelledby="removeContactStaffLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="removeContactStaffModalLabel">Remove Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to remove this contact?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="{{ route('member.profile.remove.contact.official') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" id="trash-user-id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="staff_id" id="trash-contact-staff-id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Send Message Modal -->
                    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="sendMessageModalLabel">Coming Soon..</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

            $('body').on('click', '#remove_new_field', function(e){
                e.preventDefault();
                $(this).parent('div').remove();
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

        // trash a contact official
        $('.trash-contact-official-btn').on('click', function() {
            let num = $(this).attr('data-id');
            $('#trash-contact-official-id').val(num);
        });

        // trash a contact official
        $('.trash-contact-staff-btn').on('click', function() {
            let num = $(this).attr('data-id');
            $('#trash-contact-staff-id').val(num);
        });

        // add new field for dynamic staff
        function add_messaging(id) {
                var newFieldHtml = `<div style="position: relative; margin-top: 4px;"><select id="select_number" class="form-select select-type-number" aria-label="select type of number" name="staff[`+id+`][type_number][]" style="left: 0px;">
                                        <option value="1">Viber</option>
                                        <option value="2">WhatsApp</option>
                                        <option value="3">Telegram</option>
                                        <option value="4">Signal</option>
                                        <option value="5">WeChat</option>
                                    </select>
                                    <input class="form-control" type="text" name="staff[`+id+`][other_number][]" placeholder="" required style="padding-left: 140px;">
                                    <svg id="remove_new_field" style="position: absolute;right: 12px; top: 12px; cursor: pointer;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                                      <path stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    </div>
                                    `;
            $("#messaging_container"+id).append(newFieldHtml);
        }

        // dynamic change profipic for staff --- pak this code takes too much brain cells!
        document.querySelectorAll('.staff-prof-pic').forEach(input => {
            input.addEventListener('change', function () {
                const index = this.dataset.index;
                const file = this.files[0];
                const preview = document.getElementById('imagePreviewPhoto' + index);

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '/images/user.png'; // fallback image
                }
            });
        });

	</script>
@endsection

