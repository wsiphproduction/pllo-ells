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

    #viewInfoModal .social-icons-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: flex-end;
        margin-bottom: 10px;
        position: absolute;
        right: 14px;
        z-index: 9;
    }
    #viewInfoModal .social-icons-tab i {
        font-size: 22px;
        opacity: .7;
        margin: 0px;
        color: gray !important;
    }
    #viewInfoModal .social-icons-tab i:hover {
        opacity: 1;
    }
</style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>

            <div class="d-flex justify-content-end align-items-center">

                <div class="row mx-1">
                    <form method="get" action="{{ route('directory.hor.staff') }}" class="mb-0">
                        <input class="form-control mx-2" placeholder="SEARCH" name="member_name" value="{{ request('member_name') }}"/>
                    </form>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-region" style="height: 38px;">
                        <option selected disabled>REGION / PARTYLIST</option>
                        <option value="1">REGION I</option>
                        <option value="2">REGION II</option>
                        <option value="3">REGION III</option>
                        <option value="4">REGION IV</option>
                        <option value="5">REGION V</option>
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
                <a href="{{ route('directory.hor.staff') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
            </div>

        </div>

        <div id="portfolio" class="row g-4">
            
            @forelse($members as $member)
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
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-uppercase cursor-pointer view-info-btn"    data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal"

                                        data-name="{{ $member->horOfficial->firstname }} {{ $member->horOfficial->middle_initial }}@if($member->horOfficial->middle_initial).@endif {{ $member->horOfficial->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-party="{{ $member->horOfficial->party }}"
                                        data-province="{{ $member->horOfficial->province_address }}"
                                        data-room="{{ $member->horOfficial->main_room_number }}"
                                        data-landline ="{{ $member->horOfficial->landline }}"
                                        data-number="{{ $member->horOfficial->office_cellphone }}"
                                        data-email="{{ $member->horOfficial->email }}"

                                        data-sname="{{ $member->staff_name }}"
                                        data-snumber="{{ $member->staff_number }}"
                                        data-semail="{{ $member->staff_email }}"

                                        data-committee = '@json($committees)'
                                    >
                                        {{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }} 
                                    </h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li>
                                            <i style="opacity: .7" class="bi-person-fill me-2"></i>
                                            <span class="custom-text-primary">Cong. {{ $member->horOfficial->FullName }}</span>
                                        </li>
                                        <li>
                                            <i style="opacity: .7" class="bi-buildings-fill me-2"></i>
                                            <span>Manila, 6th District</span>
                                        </li>
                                        <li class="text-capitalize">
                                            <i style="opacity: .7" class="bi-telephone-fill me-2"></i>
                                            {{ $member->contact_number }}
                                        </li>
                                        <li>
                                            <i style="opacity: .7" class="bi-envelope-fill me-2"></i>
                                            <span class="custom-text-primary">{{ $member->email }}</span>
                                        </li>
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
            @empty
                <article>
                    <p class="mb-4">No data found.</p>
                </article>
            @endforelse

            <div class="content member-list-view">
                <table class="table-dotted table-striped">
                    <thead>
                        <tr class="border-0">
                            <th class="py-3 px-2 custom-primary-bg rounded-start"><small class="text-white">PICTURE</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">NAME / POSITION</small></th>
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
                                     onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                     class="profile-pic-directory" alt="Profile Picture"
                                     style="border-radius: 12px; width: 80px;">
                            </td>
                            <td>
                                <span class="d-flex flex-column">
                                    <small class="lh-1"><b class="text-capitalize cursor-pointer view-info-btn"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 

                                        data-name="{{ $member->horOfficial->firstname }} {{ $member->horOfficial->middle_initial }}@if($member->horOfficial->middle_initial).@endif {{ $member->horOfficial->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="{{ $member->designationDetails->name }}"
                                        data-party="{{ $member->horOfficial->party }}"
                                        data-province="{{ $member->horOfficial->province_address }}"
                                        data-room="{{ $member->horOfficial->main_room_number }}"
                                        data-landline ="{{ $member->horOfficial->landline }}"
                                        data-number="{{ $member->horOfficial->office_cellphone }}"
                                        data-email="{{ $member->horOfficial->email }}"

                                        data-sname="{{ $member->staff_name }}"
                                        data-snumber="{{ $member->staff_number }}"
                                        data-semail="{{ $member->staff_email }}"

                                        data-committee = '@json($committees)'
                                    >
                                        {{ $member->FullName }}</b></small>
                                    @if(!empty($member->designation))
                                    <small class="lh-1"><i>{{ $member->designationDetails->name }}</i></small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>
                                    @if($member->contact_number_agree)
                                    <small>{{ $member->contact_number }}</small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>
                                    @if($member->email_agree)
                                    <small>{{ $member->email }}</small>
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- form filter by birthmonth -->
    <form action="{{ route('directory.hor.staff') }}" method="get" id="filter-birthmonth-form">
        <input type="hidden" name="birthmonth" id="birthmonth-value-holder">
    </form>

    <!-- form filter by gender -->
    <form action="{{ route('directory.hor.staff') }}" method="get" id="filter-gender-form">
        <input type="hidden" name="gender" id="gender-value-holder">
    </form>

    <!-- form filter by affiliation -->
    <form action="{{ route('directory.hor.staff') }}" method="get" id="filter-affiliation-form">
        <input type="hidden" name="affiliation" id="affiliation-value-holder">
    </form>

    <!-- form filter by region -->
    <form action="{{ route('directory.hor.staff') }}" method="get" id="filter-region-form">
        <input type="hidden" name="region" id="region-value-holder">
    </form>

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

    <!-- View Information -->
    <div class="modal fade" id="viewInfoModal" tabindex="-1" aria-labelledby="viewInfoModalLabel">
      <div class="modal-dialog modal-dialog-centered" style="min-width: fit-content;">
        <div class="modal-content" style="min-width: 780px">
          <div class="modal-header">
            <h5 class="modal-title"><span class="text-capitalize view-info-name"></span>&nbsp;<span></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="p-1 position-relative">
                <div class="social-icons-tab pt-0 mt-0">
                    <a href="#"><i class="bi-facebook"></i></a>
                    <a href="#"><i class="uil-instagram-alt"></i></a>
                    <a href="#"><i class="bi-twitter"></i></a>
                    <a href="#"><i class="bi-youtube"></i></a>
                </div>
                <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3" id="canvas-tab-border" role="tablist">
                    <!-- profile trigger tab -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab-trigger" data-bs-toggle="pill" data-bs-target="#profile-tab" type="button" role="tab" aria-controls="profile-tab" aria-selected="true">Profile
                        </button>
                    </li>
                    <!-- staff trigger tab -->
                    <li class="nav-item" role="presentation" id="staff-tab-container">
                        <button class="nav-link" id="staff-tab-trigger" data-bs-toggle="pill" data-bs-target="#staff-tab" type="button" role="tab" aria-controls="staff-tab" aria-selected="true"><small>Chief of Staff | Appointment Secretary</small>
                        </button>
                    </li>
                    <!-- committee tab -->
                    <li class="nav-item" role="presentation" id="committee-tab-container">
                        <button class="nav-link" id="committee-tab-trigger" data-bs-toggle="pill" data-bs-target="#committee-tab" type="button" role="tab" aria-controls="staff-tab" aria-selected="true"><small>Committee</small>
                        </button>
                    </li>
                </ul>
                <div class="tab-content mb-3 relative">

                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile-tab" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <table class="table-dotted table-striped">
                            <tr>
                                <td width="30%"><span class="profile-label">Party Affiliation:</span></td>
                                <td><span class="text-capitalize" id="view-info-party">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">District:</span></td>
                                <td><span class="text-capitalize" id="view-info-district">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Province/Party List:</span></td>
                                <td><span class="text-capitalize" id="view-info-province">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Region:</span></td>
                                <td><span class="text-capitalize" id="view-info-region">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Term in Congress:</span></td>
                                <td><span class="text-capitalize" id="view-info-term">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Room Number:</span></td>
                                <td><span class="text-capitalize" id="view-info-room">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Majority/Minority:</span></td>
                                <td><span class="text-capitalize" id="view-info-minormajor">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Landline No.:</span></td>
                                <td><span class="text-capitalize" id="view-info-line">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Cellphone No.:</span></td>
                                <td><span class="text-capitalize" id="view-info-number">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Email Address:</span></td>
                                <td><span class="text-capitalize" id="view-info-email"></span></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Staff Tab -->
                    <div class="tab-pane fade" id="staff-tab" role="tabpanel" aria-labelledby="staff-tab" tabindex="0">
                        <h5 class="custom-text-primary mb-0">Chief of Staff</h5>
                        <table class="table-dotted table-striped">
                            <tr>
                                <td width="30%"><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_staff"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Landline No:</span></td>
                                <td><span id=""></span>---</td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Cellphone Number:</span></td>
                                <td><span id="view-info-snumber-sen_staff"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_staff"></span></td>
                            </tr>
                        </table>

                        <h5 class="custom-text-primary mb-0">Appointment Secretary</h5>
                        <table class="table-dotted table-striped">
                            <tr>
                                <td width="30%"><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_secretary"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Landline No:</span></td>
                                <td><span id=""></span>---</td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Cellphone Number:</span></td>
                                <td><span id="view-info-snumber-sen_secretary"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_secretary"></span></td>
                            </tr>
                        </table>
                    </div>

                    <!-- committee Tab -->
                    <div class="tab-pane fade" id="committee-tab" role="tabpanel" aria-labelledby="committee-tab" tabindex="2">
                     <table class="table-dotted table-striped" id="committeeTable">
                         <!-- dummy  data for now.. -->
                         <tr>
                             <td width="30%"><span class="profile-label">Standing Committee:</span></td>
                             <td><span class="view-info-sname-sen_secretary">Indigenous Cultural Communities And Indigenous Peoples</span></td>
                         </tr>
                         <tr>
                             <td width="30%"><span class="profile-label">Committee Committee:</span></td>
                             <td><span class="view-info-sname-sen_secretary">Glenndale J. Cornelio</span></td>
                         </tr>
                         <tr>
                             <td width="30%"><span class="profile-label">Contact Details:</span></td>
                             <td>
                                 <span class="view-info-sname-sen_secretary">89513006 | 89315361</span>
                                 <br />
                                 <span class="view-info-sname-sen_secretary">(8931 - 5001): 7141</span>
                                 <br />
                                 <span class="view-info-sname-sen_secretary">0917 - 595954</span>
                                 <br />
                                 <span class="view-info-sname-sen_secretary">committee.economicaffairs@house.gov.ph</span>
                             </td>
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

  // view info
  $('.view-info-btn').on('click', function() {
      let name = $(this).attr('data-name');
      let position = $(this).attr('data-position');

      let party = $(this).attr('data-party');
      let district = $(this).attr('data-district');
      let province = $(this).attr('data-province');
      let region = $(this).attr('data-region');
      let term = $(this).attr('data-term');
      let room = $(this).attr('data-room');
      let minormajor = $(this).attr('data-minormajor');
      let line = $(this).attr('data-line');
      let number = $(this).attr('data-number');
      let email = $(this).attr('data-email');

      let sname = $(this).attr('data-sname');
      let snumber = $(this).attr('data-snumber');
      let semail = $(this).attr('data-semail');

      let has_staff = $(this).attr('data-has_staff');

      // if (has_staff)
      // {
      //     $('#staff-tab-container').show();
      // } else {
      //     $('#staff-tab-container').hide();
      // }
      
      $('.view-info-name').text(name);
      $('.view-info-position').text(position);

      $('#view-info-party').text(party);
      $('#view-info-district').text(district);
      $('#view-info-province').text(province);
      $('#view-info-region').text(region);
      $('#view-info-term').text(term);
      $('#view-info-room').text(room);
      $('#view-info-minormajor').text(minormajor);
      $('#view-info-line').text(line);
      $('#view-info-number').text(number);
      $('#view-info-email').text(email);

      $('.view-info-sname').text(sname);
      $('#view-info-snumber').text(snumber);
      $('#view-info-semail').text(semail);

  });

  // filter by birthmonth
  $('#filter-birthmonth').on('change', function() {
      let val = $(this).val();
      $('#birthmonth-value-holder').val(val);
      $('#filter-birthmonth-form').submit();
  });

  // filter by gender
  $('#filter-gender').on('change', function() {
      let val = $(this).val();
      $('#gender-value-holder').val(val);
      $('#filter-gender-form').submit();
  });

  // filter by affiliation
  $('#filter-affiliation').on('change', function() {
      let val = $(this).val();
      $('#affiliation-value-holder').val(val);
      $('#filter-affiliation-form').submit();
  });

  // filter by region
  $('#filter-region').on('change', function() {
      let val = $(this).val();
      $('#region-value-holder').val(val);
      $('#filter-region-form').submit();
  });

</script>
@endsection