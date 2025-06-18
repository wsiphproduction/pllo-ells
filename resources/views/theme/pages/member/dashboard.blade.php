@extends('theme.main')

@section('pagecss')
<style>
    .table-dotted tr {
        border-top: 1px dotted #929292;
        border-bottom: 1px dotted #929292;
    }
    .table-dotted tr td span {
        line-height: 2.5;
    }
    .table-dotted {
        min-width: 100%;
    }
</style>
@endsection

@section('content')

@php

@endphp

<div class="container bottommargin-lg">
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
                    <div class="tab-content">
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
                                            <td><span>Email Address:</span></td>
                                            <td><span>lls@dict.gov.ph</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Alt Email Address:</span></td>
                                            <td><span>information@dict.gov.ph</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Password:</span></td>
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
                                            <td><span>Name:</span></td>
                                            <td><span>Karla Mae Gutierrez</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Nickname:</span></td>
                                            <td><span>Karla</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Gender:</span></td>
                                            <td><span>Female</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Birthday:</span></td>
                                            <td><span>November 15</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-5">
                                    <table class="table-dotted table-striped">
                                        <tr>&nbsp;</tr>
                                        <tr>
                                            <td><span>Email Address:</span></td>
                                            <td><span>karlamae@dict.gov.ph</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Cellphone Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Viber Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Telegram Number:</span></td>
                                            <td><span>091789200101</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agency-border" role="tabpanel" aria-labelledby="tab-agency-border-tab" tabindex="0">
                            <p class="mb-0">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro
                                fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer,
                                iphone skateboard locavore carles etsy salvia banksy hoodie helvetica.</p>
                        </div>
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

