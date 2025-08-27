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

            <div class="d-flex align-items-centerl">

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-designation" style="height: 38px;">
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
                
                <form method="get" action="{{ route('directory.lls') }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <input class="form-control mx-2" placeholder="Search Member Name" name="member_name" value="{{ request('member_name') }}"/>
                        <button type="button" class="btn btn-transparent p-1" id="grid-view-btn" title="Grid View"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                        <button type="button" class="btn btn-transparent p-1" id="list-view-btn" title="List View"><i class="bi-list-ul fa-1x custom-text-primary"></i></button>
                        <a onclick="window.print()" type="button" class="btn btn-transparent p-1" title="Print"><i class="fa-solid fa-print fa-1x custom-text-primary"></i></a>
                    </div>
                </form>
            </div>

        </div>

        <div id="portfolio" class="row g-4">
            
            @foreach($members as $member)
                <article class="portfolio-item col-md-6 col-12 member-grid-view">
                    <div class="card mb-4 p-3 border-0">
                        <div class="row g-0 relative">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="{{ asset($member->photo) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                    class="img-fluid rounded"
                                    style="height: 100%; width: 100%; object-fit: cover;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-uppercase cursor-pointer view-info-btn"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 
                                        data-name="{{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-number="{{ $member->contact_number }}"
                                        data-email="{{ $member->email }}"

                                        data-sname1="{{ $member->staff_name1 }}"
                                        data-snumber1="{{ $member->staff_number1 }}"
                                        data-semail1="{{ $member->staff_email1 }}"

                                        data-sname2="{{ $member->staff_name2 }}"
                                        data-snumber2="{{ $member->staff_number2 }}"
                                        data-semail2="{{ $member->staff_email2 }}"

                                        data-sname3="{{ $member->staff_name3 }}"
                                        data-snumber3="{{ $member->staff_number3 }}"
                                        data-semail3="{{ $member->staff_email3 }}"

                                        data-sname4="{{ $member->staff_name4 }}"
                                        data-snumber4="{{ $member->staff_number4 }}"
                                        data-semail4="{{ $member->staff_email4 }}"
                                    >{{ $member->fullName }}</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-person me-2"></i>{{ $member->full_designation_name }}</li>
                                        <li><i class="bi-building me-2"></i>{{ $member->full_agency_name }}</li>
                                        <li><i class="bi-phone me-2"></i>{{ $member->contact_number }}</li>
                                        <li><i class="bi-envelope me-2"></i>{{ $member->email }}</li>
                                        <li>
                                            <i class="bi-x-diamond me-2"></i>
                                            <a class="text-decoration-none" data-bs-toggle="collapse" href="#cluster-{{ $member->id }}" role="button" aria-expanded="false" aria-controls="cluster-{{ $member->id }}">
                                                Show Clusters
                                            </a>

                                            <div class="collapse mt-2" id="cluster-{{ $member->id }}">
                                                <div class="text-muted small">
                                                    {{ $member->full_cluster_name }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(!@$member->is_contact_exist($member->id))
                            <button class="btn btn-primary btn-sm contact-btn-style add-contact-btn" data-id="{{ $member->id }}" data-bs-toggle="modal" data-bs-target="#addContactModal" title="Click to add contact">
                                <i class="icon-user-plus"></i>
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
                            <th class="py-3 custom-primary-bg"><small class="text-white">NAME / POSITION</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">AGENCY</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">CLUSTER</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">NUMBER</small></th>
                            <th class="py-3 custom-primary-bg rounded-end"><small class="text-white">EMAIL ADD</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <img id="userPhotoDirectory"
                                     src="{{ $member->photo ? asset('/' . $member->photo) : asset('images/user.png') }}"
                                     class="profile-pic-directory" alt="Profile Picture"
                                     style="border-radius: 12px; width: 80px;">
                            </td>
                            <td>
                                <span class="d-flex flex-column">
                                    <small class="lh-1"><b class="text-capitalize cursor-pointer view-info-btn"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 
                                        data-name="{{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-number="{{ $member->contact_number }}"
                                        data-email="{{ $member->email }}"

                                        data-sname1="{{ $member->staff_name1 }}"
                                        data-snumber1="{{ $member->staff_number1 }}"
                                        data-semail1="{{ $member->staff_email1 }}"

                                        data-sname2="{{ $member->staff_name2 }}"
                                        data-snumber2="{{ $member->staff_number2 }}"
                                        data-semail2="{{ $member->staff_email2 }}"

                                        data-sname3="{{ $member->staff_name3 }}"
                                        data-snumber3="{{ $member->staff_number3 }}"
                                        data-semail3="{{ $member->staff_email3 }}"

                                        data-sname4="{{ $member->staff_name4 }}"
                                        data-snumber4="{{ $member->staff_number4 }}"
                                        data-semail4="{{ $member->staff_email4 }}"
                                        >{{ $member->FullName }}</b></small>
                                    @if(!empty($member->designation))
                                    <small class="lh-1"><i>{{ $member->designationDetails->name }}</i></small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>
                                    <small>{{ $member->agency }}</small>
                                </span>
                            </td>
                            <td>
                                @if(!empty($member->cluster))
                                    @php
                                        $cluster_arr = [];
                                        $cluster_arr = explode('::', $member->cluster);
                                    @endphp
                                      
                                    @forelse($cluster_arr as $cluster)
                                        <span><small>{{ $member->getClusterName($cluster)->name }} <br /></small></span>
                                    @empty
                                        <span><small>No Cluster Details.</small></span>
                                    @endforelse
                                @endif
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
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactLabel" aria-hidden="true">
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
    <form action="{{ route('directory.lls') }}"  method="get" id="filter-designation-form">
        <input type="hidden" name="designation" id="designation-value-holder">
    </form>

    <!-- form filter by birthmonth -->
    <form action="{{ route('directory.lls') }}"  method="get" id="filter-birthmonth-form">
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
                        <small class="alert-empty" style="display: none;"><i>Please update staff details on profile.</i></small>
                        <table class="table-dotted table-striped lls-info-1 mt-2">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>Appointment Secretary</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail1"></span></td>
                            </tr>
                        </table>

                        <table class="table-dotted table-striped lls-info-2">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>DLLO</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail1"></span></td>
                            </tr>
                        </table>

                        <table class="table-dotted table-striped lls-info-3">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>DLLS- Senate</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail1"></span></td>
                            </tr>
                        </table>

                        <table class="table-dotted table-striped lls-info-4">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>DLLS- FREP</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber1"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail1"></span></td>
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
    $('#filter-designation').on('change', function() {
        let val = $(this).val();
        $('#designation-value-holder').val(val);
        $('#filter-designation-form').submit();
    });

    // filter by designation
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

        let sname1 = $(this).attr('data-sname1');
        let snumber1 = $(this).attr('data-snumber1');
        let semail1 = $(this).attr('data-semail1');

        let sname2 = $(this).attr('data-sname2');
        let snumber2 = $(this).attr('data-snumber2');
        let semail2 = $(this).attr('data-semail2');

        let sname3 = $(this).attr('data-sname3');
        let snumber3 = $(this).attr('data-snumber3');
        let semail3 = $(this).attr('data-semail3');

        let sname4 = $(this).attr('data-sname4');
        let snumber4 = $(this).attr('data-snumber4');
        let semail4 = $(this).attr('data-semail4');

        let has_staff = $(this).attr('data-has_staff');
        
        if(has_staff)
        {
            $('#staff-tab-container').show();
        } else {
            $('#staff-tab-container').hide();
        }

        if(sname1 === "" && sname2 === "" && sname3 === "" && sname4 === "") {
            // $('.alert-empty').show();
        }

        $('.view-info-name').text(name);
        $('.view-info-position').text(position);
        $('#view-info-number').text(number);
        $('#view-info-email').text(email);

        $('.view-info-sname1').text(sname1);
        $('#view-info-snumber1').text(snumber1);
        $('#view-info-semail1').text(semail1);

        $('.view-info-sname2').text(sname2);
        $('#view-info-snumber2').text(snumber2);
        $('#view-info-semail2').text(semail2);

        $('.view-info-sname3').text(sname3);
        $('#view-info-snumber3').text(snumber3);
        $('#view-info-semail3').text(semail3);

        $('.view-info-sname4').text(sname4);
        $('#view-info-snumber4').text(snumber4);
        $('#view-info-semail4').text(semail4);
    });
</script>
@endsection