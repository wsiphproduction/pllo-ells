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

                    <div class="d-flex flex-column justify-content-start">
                        <h5>Edit Agency <br> <small style="opacity: .8; font-weight: 500;">Edit details on coresponding fields below.</small></h5>
                        
                    </div>

                    <div class="agency-maintenance-add border-top">

                        <div class="create-agency-container mt-3">
                            <form class="m-0" method="post" action="{{ route('maintenance.agency.update', $agency->id) }}" enctype="multipart/form-date">
                                @csrf
                                <div class="d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 px-4">
                                        <div class="form-group">
                                            <label for="name">Agency Name</label>
                                            <input class="form-control" type="text" name="agency_name" value="{{ $agency->agency_name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Main Office Address</label>
                                            <input class="form-control" type="text" name="agency_address" value="{{ $agency->agency_address }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Email Address</label>
                                            <input class="form-control" type="text" name="agency_email" value="{{ $agency->agency_email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Landline Number</label>
                                            <input class="form-control" type="text" name="agency_landline" value="{{ $agency->agency_landline }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Cellphone Number</label>
                                            <input class="form-control" type="text" name="agency_cellphone" value="{{ $agency->agency_cellphone }}">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-start gap-3 py-4">
                                            <button type="submit" class="btn btn-success">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                </svg>
                                                Update
                                            </button>
                                            <a href="{{ route('maintenance.dashboard') }}" type="button" id="btn-cancel-agency" class="btn btn-secondary">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                                </svg>
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 border rounded p-4" style="background-color: #f5f5f5;">
                                        <h6>Head of Agency</h6>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" type="text" name="head_name" value="{{ $agency->head_name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nickname</label>
                                            <input class="form-control" type="text" name="head_nickname" value="{{ $agency->head_nickname }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="head_gender">Gender</label>
                                                <select class="form-select" aria-label="select gender" name="head_gender" required>
                                                    <option value="0">- Select Gender -</option>
                                                    @foreach($genders as $gender)
                                                    <option @if($gender->id == $agency->head_gender ) selected @endif value="{{ $gender->id }}">{{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Address</label>
                                            <input class="form-control" type="text" name="head_address" value="{{ $agency->head_address }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Alt Office Address</label>
                                            <input class="form-control" type="text" name="head_alt_address" value="{{ $agency->head_alt_address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email Address</label>
                                            <input class="form-control" type="text" name="head_email" value="{{ $agency->head_email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Email Address</label>
                                            <input class="form-control" type="text" name="head_office_email" value="{{ $agency->head_office_email }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Office Cellphone Number</label>
                                            <input class="form-control" type="text" name="head_cellphone" value="{{ $agency->head_cellphone }}">
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

	</script>
@endsection