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
                        <h5>Manage Agency</h5>
                        <button id="btn-add-agency" class="btn btn-success">
                            <svg style="margin-right: 10px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                            </svg>
                            Create Agency
                        </button>
                    </div>

                    <div class="agency-maintenance-list mt-4">

                        <table id="registrationsApproveTable" class="table table-hover table-striped table-bordered">
                            <thead class="bg-dark text-white">
                              <tr>
                                <th width="55%"><b>Agency</b></th>
                                <th width="25%"><b>Date/Time Added</b></th>
                                <th width="20%"><b>Action</b></th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($agencies as $agency)
                                    <tr>
                                        <td>{{ $agency->agency_name  }}</td>
                                        <td>{{ $agency->created_at  }}</td>
                                        <td>
                                            <a href="{{ route('maintenance.agency.view', $agency->id ) }}" class="btn btn-success" title="View agency details">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                  <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </a>
                                            &nbsp;
                                            <a href="{{ route('maintenance.agency.edit', $agency->id ) }}" class="btn btn-secondary" title="Edit agency details">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>
                                            </a>
                                            &nbsp;
                                            <button type="button" class="btn btn-danger" title="Delete agency" data-bs-toggle="modal" data-bs-target="#deleteAgencyModal">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Delete confirmation modal -->
                                    <div class="modal fade" id="deleteAgencyModal" tabindex="-1" aria-labelledby="deleteAgencyModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="regApproveModalLabel">Delete Agency Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Are you sure you want to delete this agency?
                                          </div>
                                          <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <form method="post" action="{{ route('maintenance.agency.delete' ) }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="agency_id" value="{{ $agency->id }}">
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="4">No approved agency found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="agency-maintenance-add border-top" style="display: none;">
                        <h5 class="mt-3 mb-0" style="opacity: .8;">Create Agency</h5>
                        <small style="opacity: .8;">Please provide details on coresponding fields below.</small>

                        <div class="create-agency-container mt-3">
                            <form class="m-0" method="post" action="{{ route('maintenance.agency.store') }}" enctype="multipart/form-date">
                                @csrf
                                <div class="d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 px-4">
                                        <div class="form-group">
                                            <label for="name">Agency Name</label>
                                            <input class="form-control" type="text" name="agency_name" value="{{ old('agency_name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Main Office Address</label>
                                            <input class="form-control" type="text" name="agency_address" value="{{ old('agency_address') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Email Address</label>
                                            <input class="form-control" type="text" name="agency_email" value="{{ old('agency_email') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Landline Number</label>
                                            <input class="form-control" type="text" name="agency_landline" value="{{ old('agency_landline') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Cellphone Number</label>
                                            <input class="form-control" type="text" name="agency_cellphone" value="{{ old('agency_cellphone') }}">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-start gap-3 py-4">
                                            <button type="submit" class="btn btn-success">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                </svg>
                                                Submit
                                            </button>
                                            <button type="button" id="btn-cancel-agency" class="btn btn-secondary">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                                </svg>
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 border rounded p-4" style="background-color: #f5f5f5;">
                                        <h6>Head of Agency</h6>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" type="text" name="head_name" value="{{ old('head_name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nickname</label>
                                            <input class="form-control" type="text" name="head_nickname" value="{{ old('head_nickname') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="head_gender">Gender</label>
                                                <select class="form-select" aria-label="select gender" name="head_gender" required>
                                                    <option value="0" selected>- Select Gender -</option>
                                                    @foreach($genders as $gender)
                                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Address</label>
                                            <input class="form-control" type="text" name="head_address" value="{{ old('head_address') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Alt Office Address</label>
                                            <input class="form-control" type="text" name="head_alt_address" value="{{ old('head_alt_address') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email Address</label>
                                            <input class="form-control" type="text" name="head_email" value="{{ old('head_email') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Email Address</label>
                                            <input class="form-control" type="text" name="head_office_email" value="{{ old('head_office_email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Cellphone Number</label>
                                            <input class="form-control" type="text" name="head_cellphone" value="{{ old('head_cellphone') }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        $('#btn-add-agency').click(function() {
            $('.agency-maintenance-add').show();
            $('.agency-maintenance-list').hide();
            $('#btn-add-agency').hide();
        });

        $('#btn-cancel-agency').click(function() {
            $('.agency-maintenance-add').hide();
            $('.agency-maintenance-list').show();
            $('#btn-add-agency').show();
        });
	</script>
@endsection