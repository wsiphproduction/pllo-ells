@extends('theme.main')

@section('pagecss')
<style>

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
                    @if(auth()->user()->avatar === null)
                        <img src="{{ asset('images/user.png') }}">
                    @else
                        <img src="">Profile Picture here..
                    @endif
                </div>

                <div class="col-12 col-md-10">

                    <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-profile-border-tab" data-bs-toggle="pill" data-bs-target="#profile-border" type="button" role="tab" aria-controls="tab-profile-border" aria-selected="true"><small><b>PROFILE</b></small></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-agency-border-tab" data-bs-toggle="pill" data-bs-target="#agency-border" type="button" role="tab" aria-controls="tab-agency-border" aria-selected="false"><small><b>AGENCY PROFILE</b></small></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-events-border-tab" data-bs-toggle="pill" data-bs-target="#events-border" type="button" role="tab" aria-controls="tab-events-border" aria-selected="false"><small><b>EVENTS ATTENDED</b></small></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-reference-border-tab" data-bs-toggle="pill" data-bs-target="#reference-border" type="button" role="tab" aria-controls="tab-reference-border" aria-selected="false"><small><b>REFERENCE MATERIALS</b></small></button>
                        </li>
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
                                <div class="col-12 col-md-2">
                                    <small class="form-title"><b>MAIN ACCOUNT</b></small>
                                    <br />
                                    <img class="mt-4" src="{{ asset('images/user.png') }}" width="120">
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
                            </div>

                            <div class="row" id="edit_profile_panel" style="display: none;">
                                <div class="col-12 col-md-2">
                                    <small class="form-title"><b>MAIN ACCOUNT</b></small>
                                    <br />
                                    <img class="mt-4" src="{{ asset('images/user.png') }}" width="120">
                                </div>
                                <div class="col-12 col-md-5">
                                    <div>
                                        <input class="form-control mb-3" type="text" name="email" value="{{ $memberDetails->email }}">
                                        <input class="form-control mb-3" type="text" name="alt_email" value="{{ $memberDetails->alt_email }}" placeholder="ALT EMAIL ADDRESS">
                                        
                                        <div style="position: relative;">
                                            <input class="form-control mb-3" type="password" name="alt_email" value="{{ $memberDetails->password }}" placeholder="PASSWORD">
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
                                <div class="col-12 col-md-5">
                                    <div class="mb-2">
                                        <select class="form-select" multiple aria-label="multiple select example" name="cluster[]">
                                            @foreach($clustersList as $clusterItem)
                                            <option value="{{ $clusterItem->id }}">{{ $clusterItem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small><i>Press Control in keyboard and Left Click Mouse for changes and Multi Select. Changes in cluster needs approval.</i></small>
                                </div>
                            </div>

                            <!-- <div class="row mt-4">
                                <small class="form-title my-0" style="transform: translate(0px, 16px);"><b>DLLS - HREP DEPARTMENT LEGISLATIVE LIAISON STAFF</b></small>
                                <div class="col-12 col-md-2">
                                    <img class="mt-4" src="{{ asset('images/user.png') }}" width="120">
                                </div>
                                <div class="col-12 col-md-5">
                                    <table class="table-dotted table-striped">
                                        <tr>&nbsp;</tr>
                                        <tr>
                                            <td><span class="profile-label">Name:</span></td>
                                            <td><span>Karla Mae Gutierrez</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Nickname:</span></td>
                                            <td><span>Karla</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Gender:</span></td>
                                            <td><span>Female</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Birthday:</span></td>
                                            <td><span>November 15</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-5">
                                    <table class="table-dotted table-striped">
                                        <tr>&nbsp;</tr>
                                        <tr>
                                            <td><span class="profile-label">Email Address:</span></td>
                                            <td><span>karlamae@dict.gov.ph</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Cellphone Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Viber Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label">Telegram Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div> -->

                        </div>

                        <!-- Agency Tab -->
                        <div class="tab-pane fade" id="agency-border" role="tabpanel" aria-labelledby="tab-agency-border-tab" tabindex="0">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr><small class="form-title"><b>GOVERNMENT AGENCY</b></small></tr>
                                        <tr>
                                            <td colspan="2">
                                                <span>
                                                    <small>
                                                        <span class="profile-label">Main Office Address:</span>
                                                        <p>
                                                            Department of Information and Communications Technology C.P Garcia Ave., Diliman, Quezon City Philippines 1101
                                                        </p>
                                                    </small>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                            <td><span><small>information@dict.gov.ph</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Landline Number:</small></span></td>
                                            <td><span><small>8920-0101</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number:</small></span></td>
                                            <td><span><small>0917-8920-0101</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-6">
                                    <table class="table-dotted table-striped">
                                        <tr><small class="form-title"><b>HEAD OF THE AGENCY</b></small></tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Name:</small></span></td>
                                            <td><span><small>Sec. Ivan John E. Us</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Nickname:</small></span></td>
                                            <td><span><small>Ivans</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Gender: </small></span></td>
                                            <td><span><small>Males</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Address: </small></span></td>
                                            <td><span><small>Office of the Assistant Secretary for Legal Affairs </small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Alt. Office Addres: </small></span></td>
                                            <td><span><small>Office of the Assistant Secretary for Management Information Systems Services</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Email Addres: </small></span></td>
                                            <td><span><small>sec@dict.gov.phs</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Email Addres: </small></span></td>
                                            <td><span><small>osec@dict.gov.phs</small></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="profile-label"><small>Office Cellphone Number: </small></span></td>
                                            <td><span><small>0917-8920-010s</small></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Events Tab -->
                        <div class="tab-pane fade" id="events-border" role="tabpanel" aria-labelledby="tab-events-border-tab" tabindex="0">
                            <div class="col-12">
                                <table class="table-dotted table-striped">
                                    <tr>
                                        <small>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        </small>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span><small>March 3, 2023</small></span></td>
                                        <td><span class="primary-text-color"><small>Focus Group Discussion: Natural Gas Industry</small></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reference-border" role="tabpanel" aria-labelledby="tab-reference-border-tab" tabindex="0">
                            <p class="mb-0">Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master
                                cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party
                                locavore wolf cliche high life echo park Austin.</p>
                        </div>
                        <div class="tab-pane fade" id="policy-border" role="tabpanel" aria-labelledby="tab-policy-border-tab" tabindex="0">
                            <p class="mb-0">Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master
                                cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party
                                locavore wolf cliche high life echo park Austin.</p>
                        </div>
                        <div class="tab-pane fade" id="saved-border" role="tabpanel" aria-labelledby="tab-saved-border-tab" tabindex="0">
                            <p class="mb-0">Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master
                                cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party
                                locavore wolf cliche high life echo park Austin.</p>
                        </div>
                    </div>

                    <div class="row">
                        <small><i><span class="text-danger">Disclaimer for Data Privacy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</i></small>
                    </div>

                    <div class="row">
                        <div class="button-group d-flex justify-content-end mt-4">
                            <button class="btn btn-secondary text-white" id="edit_profile_btn"><small class="text-uppercase">edit profile</small></button>
                            &nbsp;
                            &nbsp;
                            <div id="save_cancel_pane" style="display: none;">
                                <button class="btn btn-primary text-white" id="save_profile_btn"><small class="text-uppercase">SAVE</small></button>
                                &nbsp;
                                &nbsp;
                                <button class="btn btn-secondary text-white" id="cancel_profile_btn"><small class="text-uppercase">CANCEL</small></button>
                                &nbsp;
                                &nbsp;
                            </div>
                            <button class="btn btn-danger text-white"><small class="text-uppercase">delete account</small></button>
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
        $('#edit_profile_btn').on('click', function() {
            $('#edit_profile_panel').css("display", "flex");
            $('#default_profile_panel').css("display", "none");
            $('#save_cancel_pane').css("display", "flex");
            $('#edit_profile_btn').css("display", "none");
        });

        $('#cancel_profile_btn').on('click', function() {
            $('#edit_profile_panel').css("display", "none");
            $('#default_profile_panel').css("display", "flex");
            $('#save_cancel_pane').css("display", "none");
            $('#edit_profile_btn').css("display", "flex");
        });
	</script>
@endsection

