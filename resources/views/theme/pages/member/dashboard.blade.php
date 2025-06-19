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
                            <div class="row">
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
                                            <td><span>lls@dict.gov.ph</span></td>
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
                                        <tr>
                                            <td><span>EDC (Economic Development Cluster:</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>PGC (Participatory Governance Cluster)</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>SJPC (Security, Jusঞce and Peace Cluster)</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
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
                            </div>
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
                            <p class="mb-0">Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master
                                cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party
                                locavore wolf cliche high life echo park Austin.</p>
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
                            <button class="btn btn-secondary text-white"><small class="text-uppercase">edit profile</small></button>
                            &nbsp;
                            &nbsp;
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

	</script>
@endsection

