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
                     
                    </ul>
                    <div class="tab-content mb-3 relative">

                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-border" role="tabpanel" aria-labelledby="tab-profile-border-tab" tabindex="0">
                            <div class="row" id="default_profile_panel">
                                <div class="row">

                                    @if($memberDetails->user_type == 5 || $memberDetails->user_type == 7)
                                        <!-- nothing for now -->
                                    @else
                                        <small class="form-title mb-0"><b>MAIN ACCOUNT @if(!empty($memberDetails->designationDetails))<i style="font-size: 12px;">({{ $memberDetails->designationDetails->name }})</i>@endif</b></small>

                                        <div class="col-12 col-md-2 d-flex align-items-start justify-content-center">
                                            <img class="mt-2" width="120" style="border-radius: 100%;
                                                                border-radius: 100%;
                                                                min-width: 120px;
                                                                height: 120px;
                                                                background-image: url('{{ $memberDetails->photo ? asset('/' . $memberDetails->photo) : asset('images/user.png') }}');
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
	
@endsection

