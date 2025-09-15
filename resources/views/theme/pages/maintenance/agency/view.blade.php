@extends('theme.main')

@section('pagecss')
<style>
    .table.table-hover.table-striped.table-bordered thead tr th {
        background-color: #2b3649;
        color: white;
    }
</style>
@endsection

@section('content')

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="col-lg-12">

            <div class="heading-block border-0 mb-4">
                <h4>Maintenance Dashboard</h4>
            </div>

            <div class="row">

                <div class="col-12 col-md-2">
                    <x-maintenance-navs></x-maintenance-navs>
                </div>

                <div class="col-12 col-md-10 border rounded shadow" style="padding: 20px;">

                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="text-uppercase">{{ $agency->agency_name }}</h5>
                        <a href="{{ route('maintenance.dashboard') }}" class="btn btn-success">
                            <svg style="margin-right: 5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                            </svg>
                            Back
                        </a>
                    </div>

                    <div class="agency-maintenance-view mt-2">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <table class="table-dotted table-striped">
                                    <tr>
                                        <td colspan="2">
                                            <span>
                                                <small>
                                                    <span class="profile-label">Main Office Address:</span>
                                                    <p>
                                                        {{ $agency->agency_address }}
                                                    </p>
                                                </small>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Email Addres:</small></span></td>
                                        <td><span><small>{{ $agency->agency_email }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Landline Number:</small></span></td>
                                        <td><span><small>{{ $agency->agency_landline }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Cellphone Number:</small></span></td>
                                        <td><span><small>{{ $agency->agency_cellphone }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Approver:</small></span></td>
                                        <td><span><small>{{ $approver->fullname ?? 'Unknown' }}</small></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-6">
                                <table class="table-dotted table-striped">
                                    <tr><small class="form-title"><b>HEAD OF THE AGENCY</b></small></tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Name:</small></span></td>
                                        <td><span><small>{{ $agency->head_name }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Nickname:</small></span></td>
                                        <td><span><small>{{ $agency->head_nickname }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Gender: </small></span></td>
                                        <td><span><small>{{ $agency->getGenderName(1) }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Address: </small></span></td>
                                        <td><span><small>{{ $agency->head_address }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Alt. Office Addres: </small></span></td>
                                        <td><span><small>{{ $agency->head_alt_address }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Email Addres: </small></span></td>
                                        <td><span><small>{{ $agency->head_email }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Email Addres: </small></span></td>
                                        <td><span><small>{{ $agency->head_office_email }}</small></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="profile-label"><small>Office Cellphone Number: </small></span></td>
                                        <td><span><small>{{ $agency->head_cellphone }}</small></span></td>
                                    </tr>
                                </table>
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
        
	</script>
@endsection