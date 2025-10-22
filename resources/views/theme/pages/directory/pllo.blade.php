@extends('theme.main')

@section('pagecss')
<style>
    .portfolio-item:hover .contact-btn-style {
        display: flex !important;
    }
    .contact-btn-style {
        display: none;
        position: absolute;
        width: fit-content;
        top: 30px;
        left: 32px;
    }

    .member-list-view {
        display: none;
    }
</style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>

            {{-- <form method="get" action="{{ route('directory.pllo') }}">
                <input class="form-control mx-2" placeholder="Search Member Name" name="member_name" value="{{ request('member_name') }}"/>
            </form> --}}

            <div class="d-flex justify-content-between align-items-center no-print">

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-outpost" style="height: 38px;">
                        <option selected disabled>OUTPOST</option>
                        <option>OSEC</option>
                        <option>HREP</option>
                        <option>SENATE</option>
                        <option>PLLO</option>
                    </select>
                </div>

                <div class="row mx-1">
                    <select class="form-select lh-1" id="filter-designation" style="height: 38px; width: 180px;">
                        <option selected disabled>DESIGNATION</option>
                        @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                        @endforeach
                        <option value="0">ALL</option>
                    </select>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-birthmonth" style="height: 38px;">
                        <option selected disabled>BIRTHMONTH</option>
                        @foreach(config('months') as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                        <option value="0">ALL</option>
                    </select>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-gender" style="height: 38px;">
                        <option selected disabled>GENDER</option>
                        <option value="1">MALE</option>
                        <option value="2">FEMALE</option>
                        <option value="3">OTHERS</option>
                        <option value="4">PREFER NOT TO SAY</option>
                        <option value="0">ALL</option>
                    </select>
                </div>

                <button type="button" class="btn btn-transparent p-1" id="grid-view-btn" title="Grid View"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                <button type="button" class="btn btn-transparent p-1" id="list-view-btn" title="List View"><i class="bi-list-ul fa-1x custom-text-primary"></i></button>
                <a onclick="window.print()" type="button" class="btn btn-transparent p-1" title="Print"><i class="fa-solid fa-print fa-1x custom-text-primary"></i></a>
            </div>

        </div>

        <div id="portfolio" class="row g-4">
            
            @foreach($members as $member)
                <article class="portfolio-item col-md-4 col-12 member-grid-view">
                    <div class="card mb-4 p-3 border-0">
                        <div class="row g-0 relative">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="{{ asset($member->photo) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                    class="img-fluid rounded"
                                    style="height: 100%; width: 100%; object-fit: cover; max-width: 146px; max-height: 146px; margin-top: 10px;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-capitalize cursor-pointer view-info-btn"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 
                                        data-name="{{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-number="{{ $member->contact_number }}"
                                        data-email="{{ $member->email }}"
                                        data-sname="{{ $member->staff_name }}"
                                        data-snumber="{{ $member->staff_number }}"
                                        data-semail="{{ $member->staff_email }}"
                                    >{{ $member->fullName }}</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i style="opacity: .7" class="bi-person-fill me-2"></i>{{ $member->full_designation_name }}</li>
                                        {{-- <li><i class="bi-buildings-fill me-2"></i>{{ $member->full_agency_name }}</li> --}}
                                        <li><i style="opacity: .7" class="bi-buildings-fill me-2"></i>OSEC</li>
                                        <!-- No Data to fetch, static for now.. -->
                                        <li><i style="opacity: .7" class="bi-telephone-fill me-2"></i>{{ $member->contact_number }}</li>
                                        <li><i style="opacity: .7" class="bi-chat-dots-fill me-2"></i>{{ $member->email }}</li>
                                        {{-- <li>
                                            <i class="bi-x-diamond me-2"></i>
                                            <a class="text-decoration-none" data-bs-toggle="collapse" href="#cluster-{{ $member->id }}" role="button" aria-expanded="false" aria-controls="cluster-{{ $member->id }}">
                                                Show Clusters
                                            </a>

                                            <div class="collapse mt-2" id="cluster-{{ $member->id }}">
                                                <div class="text-muted small">
                                                    {{ $member->full_cluster_name }}
                                                </div>
                                            </div>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                            @if(!@$member->is_contact_exist($member->id))
                            <button class="btn btn-primary btn-sm contact-btn-style add-contact-btn" data-id="{{ $member->id }}" data-bs-toggle="modal" data-bs-target="#addContactModal" title="Click to add contact">
                                <i class="icon-user-plus mr-2"></i>
                            </button>
                            @else
                            <button class="btn btn-success btn-sm contact-btn-style saved-contact-btn" title="Contact already saved." disabled>
                                <i class="icon-user-check mr-2"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach

            <div class="content member-list-view">
                <table class="table-dotted table-striped">
                    <thead>
                        <tr class="border-0">
                            <th class="py-3 px-2 custom-primary-bg rounded-start"><small class="text-white">PICTURE</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">NAME</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">POSITION</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">OUTPOST</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">NUMBER</small></th>
                            <th class="py-3 custom-primary-bg rounded-end"><small class="text-white">EMAIL ADD</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <img id="userPhotoDirectory"
                                     onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                     src="{{ $member->photo ? asset('/' . $member->photo) : asset('images/user.png') }}"
                                     class="profile-pic-directory" alt="Profile Picture"
                                     style="border-radius: 12px; width: 80px;">
                            </td>
                            <td>
                                <span class="d-flex flex-column">
                                    <small class="lh-1"><b class="text-capitalize cursor-pointer view-info-btn custom-text-primary"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 
                                        data-name="{{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-number="{{ $member->contact_number }}"
                                        data-email="{{ $member->email }}"
                                        data-sname="{{ $member->staff_name }}"
                                        data-snumber="{{ $member->staff_number }}"
                                        data-semail="{{ $member->staff_email }}"
                                        >{{ $member->FullName }}</b></small>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <small>{{ $member->designationDetails->name }}</small>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <small>
                                        PLLO
                                        <!-- PLLO for now.. -->
                                    </small>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <small>{{ $member->contact_number }}</small>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <small>{{ $member->email }}</small>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Add Contact -->
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactLabel">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addContactModalLabel">Add Contact</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to add this contact?
          </div>
          <div class="modal-footer">
            <form method="post" action="{{ route('member.profile.add.contact') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="add-user-id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="contact_id" id="add-contact-id">
                <button type="submit" class="btn btn-primary">Yes</button>
            </form>
            <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>

    <!-- form filter by designation -->
    <form action="{{ route('directory.pllo') }}" method="get" id="filter-designation-form">
        <input type="hidden" name="designation" id="designation-value-holder">
    </form>

    <!-- form filter by gender -->
    <form action="{{ route('directory.pllo') }}" method="get" id="filter-gender-form">
        <input type="hidden" name="gender" id="gender-value-holder">
    </form>

    <!-- form filter by designation -->
    <form action="{{ route('directory.pllo') }}" method="get" id="filter-birthmonth-form">
        <input type="hidden" name="birthmonth" id="birthmonth-value-holder">
    </form>

    <!-- View Information -->
    <div class="modal fade" id="viewInfoModal" tabindex="-1" aria-labelledby="viewInfoModalLabel">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><span class="text-capitalize"></span>&nbsp;<span>Information</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="p-1">
                <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">

                    <!-- profile trigger tab -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab-trigger" data-bs-toggle="pill" data-bs-target="#profile-tab" type="button" role="tab" aria-controls="profile-tab" aria-selected="true">Profile
                        </button>
                    </li>
                    <!-- staff trigger tab -->
                    <li class="nav-item" role="presentation" id="staff-tab-container" style="display: none;">
                        <button class="nav-link" id="staff-tab-trigger" data-bs-toggle="pill" data-bs-target="#staff-tab" type="button" role="tab" aria-controls="staff-tab" aria-selected="true">Appointment Secretary
                        </button>
                    </li>
                </ul>
                <div class="tab-content mb-3 relative">

                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile-tab" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-name"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Designation:</span></td>
                                <td><span class="view-info-position text-capitalize"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-number"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-email"></span></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Staff Tab -->
                    <div class="tab-pane fade" id="staff-tab" role="tabpanel" aria-labelledby="staff-tab" tabindex="0">
                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail"></span></td>
                            </tr>
                        </table>
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

    // add a contact
    $('.add-contact-btn').on('click', function() {
        let num = $(this).attr('data-id');
        $('#add-contact-id').val(num);
    });

    // toggle view modes
    $('#grid-view-btn').on('click', function() {
        $('.member-grid-view').show();
        $('.member-list-view').hide();
    });

    // toggle view modes
    $('#list-view-btn').on('click', function() {
        $('.member-grid-view').hide();
        $('.member-list-view').show();
    });

    // filter by designation
    $('#filter-outpost').on('change', function() {
        location.reload();
    });

    // filter by designation
    $('#filter-designation').on('change', function() {
        let val = $(this).val();
        $('#designation-value-holder').val(val);
        $('#filter-designation-form').submit();
    });

    // filter by gender
    $('#filter-gender').on('change', function() {
        let val = $(this).val();
        $('#gender-value-holder').val(val);
        $('#filter-gender-form').submit();
    });

    // filter by birthmonth
    $('#filter-birthmonth').on('change', function() {
        let val = $(this).val();
        $('#birthmonth-value-holder').val(val);
        $('#filter-birthmonth-form').submit();
    });

    // view info
    $('.view-info-btn').on('click', function() {
        let name = $(this).attr('data-name');
        let position = $(this).attr('data-position');
        let number = $(this).attr('data-number');
        let email = $(this).attr('data-email');

        let sname = $(this).attr('data-sname');
        let snumber = $(this).attr('data-snumber');
        let semail = $(this).attr('data-semail');

        let has_staff = $(this).attr('data-has_staff');
        
        if (has_staff)
        {
            $('#staff-tab-container').show();
        } else {
            $('#staff-tab-container').hide();
        }

        $('.view-info-name').text(name);
        $('.view-info-position').text(position);
        $('#view-info-number').text(number);
        $('#view-info-email').text(email);

        $('.view-info-sname').text(sname);
        $('#view-info-snumber').text(snumber);
        $('#view-info-semail').text(semail);
    });
</script>
@endsection