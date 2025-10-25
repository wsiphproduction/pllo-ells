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
    .social-icons-image.pt-2.mt-0.d-flex.align-items-center.justify-content-evenly a i {
        font-size: 26px;
        margin: 0px;
        color: #040404;
        opacity: .5;
    }

    .social-icons-image.pt-2.mt-0.d-flex.align-items-center.justify-content-evenly a i:hover {
        opacity: 1;
        color: #3c5d90;
    }

</style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>

            <div class="d-flex justify-content-end align-items-center">

                <div class="row mx-1">
                    <form method="get" action="{{ route('directory.senators') }}" class="mb-0">
                        <input class="form-control mx-2" placeholder="SEARCH" name="member_name" value="{{ request('member_name') }}"/>
                    </form>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-minormajor" style="height: 38px;">
                        <option selected disabled>MAJORITY | MINORITY</option>
                        <option value="majority">MAJORITY</option>
                        <option value="minority">MINORITY</option>
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
                    <select class="form-select lh-1" id="filter-affiliation" style="height: 38px;">
                        <option selected disabled>POLITICAL AFFILIATION</option>
                        <option value="pdp-laban">PDP-LABAN</option>
                        <option value="lakas-cmd">LAKAS-CMD</option>
                        <option value="liberal">LIBERAL</option>
                        <option value="UNA">UNA</option>
                    </select>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-gender" style="height: 38px;">
                        <option selected disabled>GENDER</option>
                        <option value="male">MALE</option>
                        <option value="female">FEMALE</option>
                        <option value="others">OTHERS</option>
                        <option value="prefer not to say">PREFER NOT TO SAY</option>
                        <option value="0">ALL</option>
                    </select>
                </div>

                <button type="button" class="btn btn-transparent p-1" id="grid-view-btn" title="Grid View"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                <button type="button" class="btn btn-transparent p-1" id="list-view-btn" title="List View"><i class="bi-list-ul fa-1x custom-text-primary"></i></button>
                <a onclick="window.print()" type="button" class="btn btn-transparent p-1" title="Print"><i class="fa-solid fa-print fa-1x custom-text-primary"></i></a>
                <a href="{{ route('directory.senators') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
            </div>

        </div>

        <div id="portfolio" class="row g-4">
            
            @foreach($members as $member)
                <article class="portfolio-item col-md-6 col-12 member-grid-view">
                    <div class="card mb-4 p-3 border-0">
                        <div class="row g-0 relative">
                            <div class="col-md-4 position-relative" style="height: 200px;">
                                <img src="{{ asset($member->image_url) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                    class="img-fluid rounded"
                                    style="height: 100%; width: 100%; object-fit: cover;"
                                    alt="Proposed Bill">
                                <div class="social-icons-image pt-2 mt-0 d-flex align-items-center justify-content-evenly">
                                    <a href="#"><i class="bi-facebook"></i></a>
                                    <a href="#"><i class="uil-instagram-alt"></i></a>
                                    <a href="#"><i class="bi-twitter"></i></a>
                                    <a href="#"><i class="bi-youtube"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-uppercase cursor-pointer view-info-btn"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewInfoModal" 

                                        data-name="{{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }}"
                                        data-has_staff="{{ $member->has_staff }}"
                                        data-position="Senator"
                                        data-trunk="{{ $member->main_trunk_local_number }}"
                                        data-line="{{ $member->main_direct_line }}"
                                        data-fax="{{ $member->main_fax_number }}"
                                        data-email="{{ $member->email }}"
                                        data-party="{{ $member->party }}"
                                        data-room="{{ $member->main_room_number }}"

                                        data-sname_sen_staff="{{ $member->sen_staff_name }}"
                                        data-snumber_sen_staff="{{ $member->sen_staff_number }}"
                                        data-semail_sen_staff="{{ $member->sen_staff_email }}"

                                        data-sname_sen_officer="{{ $member->sen_officer_name }}"
                                        data-snumber_sen_officer="{{ $member->sen_officer_number }}"
                                        data-semail_sen_officer="{{ $member->sen_officer_email }}"

                                        data-sname_sen_secretary="{{ $member->sen_secretary_name }}"
                                        data-snumber_sen_secretary="{{ $member->sen_secretary_number }}"
                                        data-semail_sen_secretary="{{ $member->sen_secretary_email }}"

                                        data-committee = '@json($committees)'
                                    >
                                        {{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }} 
                                    </h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li class="text-capitalize">
                                            <i style="opacity: .7" class="fa-solid fa-location-pin me-2"></i>
                                            Room {{ $member->main_room_number ?? '---' }}
                                        </li>
                                        @if($member->office_cellphone_agree)
                                        <li class="text-capitalize">
                                            <i style="opacity: .7" class="bi-telephone-fill me-2"></i>
                                            {{ $member->office_cellphone }}
                                        </li>
                                        @endif
                                        @if($member->email_agree)
                                        <li>
                                            <i style="opacity: .7" class="bi-envelope-fill me-2"></i>
                                            <a href="mailto:{{ $member->email }}">
                                                {{ $member->email }}
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            <i style="opacity: .7" class="fa-solid fa-globe me-2"></i>
                                            <a href="mailto:{{ $member->email }}">
                                                ---
                                            </a>
                                        </li>
                                        <li>
                                            <i style="opacity: .7" class="fa-solid fa-user-tie me-2"></i>
                                            <span style="opacity: .7">Chief of Staff:</span> 
                                            <span class="text-capitalize">{{ $member->sen_staff_name ?? '---' }} </span>
                                        </li>
                                        <li>
                                            <i style="opacity: .7" class="fa-solid fa-user-tie me-2"></i>
                                            <span style="opacity: .7">Chief Legis Officer:</span> 
                                            <span class="text-capitalize">{{ $member->sen_officer_name ?? '---' }} </span>
                                        </li>
                                        <li>
                                            <i style="opacity: .7" class="fa-solid fa-user-tie me-2"></i>
                                            <span style="opacity: .7">Appointment Secretary:</span> 
                                            <span class="text-capitalize">{{ $member->sen_secretary_name ?? '---' }} </span>
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
            @endforeach

            <div class="content member-list-view">
                <table class="table-dotted table-striped">
                    <thead>
                        <tr class="border-0">
                            <th class="py-3 px-2 custom-primary-bg rounded-start"><small class="text-white">PICTURE</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">NAME</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">STAFF</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">ROOM NO./ CONTACT NUMBER</small></th>
                            <th class="py-3 custom-primary-bg"><small class="text-white">EMAIL ADDRESS</small></th>
                            <th class="py-3 custom-primary-bg rounded-end"><small class="text-white">SOCIAL MEDIA</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <img id="userPhotoDirectory"
                                     src="{{ $member->image_url ? asset('/' . $member->image_url) : asset('images/user.png') }}"
                                     onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
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
                                        data-position="Senator"
                                        data-trunk="{{ $member->main_trunk_local_number }}"
                                        data-line="{{ $member->main_direct_line }}"
                                        data-fax="{{ $member->main_fax_number }}"
                                        data-email="{{ $member->email }}"
                                        data-party="{{ $member->party }}"
                                        data-room="{{ $member->main_room_number }}"

                                        data-sname_sen_staff="{{ $member->sen_staff_name }}"
                                        data-snumber_sen_staff="{{ $member->sen_staff_number }}"
                                        data-semail_sen_staff="{{ $member->sen_staff_email }}"

                                        data-sname_sen_officer="{{ $member->sen_officer_name }}"
                                        data-snumber_sen_officer="{{ $member->sen_officer_number }}"
                                        data-semail_sen_officer="{{ $member->sen_officer_email }}"

                                        data-sname_sen_secretary="{{ $member->sen_secretary_name }}"
                                        data-snumber_sen_secretary="{{ $member->sen_secretary_number }}"
                                        data-semail_sen_secretary="{{ $member->sen_secretary_email }}"

                                        data-committee = '@json($committees)'
                                    >
                                        {{ $member->FullName }}</b></small>
                                </span>
                            </td>
                            <td>
                                <small>COS: <span class="custom-text-primary">{{ $member->sen_staff_name ?? '---' }}</span></small>
                                <br />
                                <small>CLO: <span class="custom-text-primary">{{ $member->sen_officer_name ?? '---' }}</span></small>
                                <br />
                                <small>AS: <span class="custom-text-primary">{{ $member->sen_secretary_name ?? '---' }}</span></small>
                            </td>
                            <td>
                                <span>
                                    <span>{{ $member->main_room_number?'Room '.$member->main_room_number : ''}}</span>
                                    @if($member->office_cellphone_agree)
                                    <small>{{ $member->office_cellphone }}</small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>
                                    @if($member->email_agree)
                                    <a href="mailto:{{ $member->email }}"><small>{{ $member->email }}</small></a>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="social-icons-image pt-2 pe-3 mt-0 d-flex align-items-center justify-content-evenly">
                                    <a href="#"><i class="bi-facebook"></i></a>
                                    <a href="#"><i class="uil-instagram-alt"></i></a>
                                    <a href="#"><i class="bi-twitter"></i></a>
                                    <a href="#"><i class="bi-youtube"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- form filter by birthmonth -->
    <form action="{{ route('directory.senators') }}" method="get" id="filter-birthmonth-form">
        <input type="hidden" name="birthmonth" id="birthmonth-value-holder">
    </form>

    <!-- form filter by gender -->
    <form action="{{ route('directory.senators') }}" method="get" id="filter-gender-form">
        <input type="hidden" name="gender" id="gender-value-holder">
    </form>

    <!-- form filter by minormajor -->
    <form action="{{ route('directory.senators') }}" method="get" id="filter-minormajor-form">
        <input type="hidden" name="minormajor" id="minormajor-value-holder">
    </form>

    <!-- form filter by affiliation -->
    <form action="{{ route('directory.senators') }}" method="get" id="filter-affiliation-form">
        <input type="hidden" name="affiliation" id="affiliation-value-holder">
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
            <form method="post" action="{{ route('member.profile.add.contact.official') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="add-user-id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="official_id" id="add-contact-id">
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
                        <button class="nav-link" id="staff-tab-trigger" data-bs-toggle="pill" data-bs-target="#staff-tab" type="button" role="tab" aria-controls="staff-tab" aria-selected="true"><small>CoS | CLO | AS</small>
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
                                <td width="30%"><span class="profile-label">Senate Office:</span></td>
                                <td><span class="text-capitalize" id="view-info-office">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Trunk Lines:</span></td>
                                <td><span class="text-capitalize" id="view-info-trunk">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Direct Line/s:</span></td>
                                <td><span class="text-capitalize" id="view-info-line">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Telefax No.</span></td>
                                <td><span class="text-capitalize" id="view-info-fax">---</span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Email Address:</span></td>
                                <td><span class="text-capitalize" id="view-info-email"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Party Affiliation:</span></td>
                                <td><span class="text-capitalize" id="view-info-party">---</span></td>
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

                        <h5 class="custom-text-primary mb-0">Chief of Legis Officer</h5>
                        <table class="table-dotted table-striped">
                            <tr>
                                <td width="30%"><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_officer"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Landline No:</span></td>
                                <td><span id=""></span>---</td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Cellphone Number:</span></td>
                                <td><span id="view-info-snumber-sen_officer"></span></td>
                            </tr>
                            <tr>
                                <td width="30%"><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_officer"></span></td>
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
                         <tbody>
                             <!-- dynamic data -->
                         </tbody>
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
      let trunk = $(this).attr('data-trunk');
      let line = $(this).attr('data-line');
      let fax = $(this).attr('data-fax');
      let email = $(this).attr('data-email');
      let party = $(this).attr('data-party');
      let room = $(this).attr('data-room');

      let sname_sen_staff = $(this).attr('data-sname_sen_staff');
      let snumber_sen_staff = $(this).attr('data-snumber_sen_staff');
      let semail_sen_staff = $(this).attr('data-semail_sen_staff');

      let sname_sen_officer = $(this).attr('data-sname_sen_officer');
      let snumber_sen_officer = $(this).attr('data-snumber_sen_officer');
      let semail_sen_officer = $(this).attr('data-semail_sen_officer');

      let sname_sen_secretary = $(this).attr('data-sname_sen_secretary');
      let snumber_sen_secretary = $(this).attr('data-snumber_sen_secretary');
      let semail_sen_secretary = $(this).attr('data-semail_sen_secretary');

      let committees = $(this).data('committee'); // array of user objects
      console.log('Committees raw:', committees);
      
      let has_staff = $(this).attr('data-has_staff');

      if (has_staff)
      {
          $('#staff-tab-container').show();
          $('#committee-tab-container').show();
      } else {
          $('#staff-tab-container').hide();
          $('#committee-tab-container').hide();
      }

      $('.view-info-name').text(name);
      $('.view-info-position').text(position);
      $('#view-info-trunk').text(trunk);
      $('#view-info-line').text(line);
      $('#view-info-fax').text(fax);
      $('#view-info-email').text(email);
      $('#view-info-party').text(party);
      $('#view-info-office').text(room);

      $('.view-info-sname-sen_staff').text(sname_sen_staff);
      $('#view-info-snumber-sen_staff').text(snumber_sen_staff);
      $('#view-info-semail-sen_staff').text(semail_sen_staff);

      $('.view-info-sname-sen_officer').text(sname_sen_officer);
      $('#view-info-snumber-sen_officer').text(snumber_sen_officer);
      $('#view-info-semail-sen_officer').text(semail_sen_officer);

      $('.view-info-sname-sen_secretary').text(sname_sen_secretary);
      $('#view-info-snumber-sen_secretary').text(snumber_sen_secretary);
      $('#view-info-semail-sen_secretary').text(semail_sen_secretary);

      if (typeof committees === 'string') {
          try {
              committees = JSON.parse(committees);
          } catch (e) {
              console.error('Failed to parse committees JSON:', e);
              committees = [];
          }
      }

      if (!Array.isArray(committees)) committees = [];

      // Clear previous rows
      var tbody = $('#committeeTable tbody');
      tbody.empty();

      // Loop and append rows dynamically
      committees.forEach((committee, index) => {
          tbody.append(`
              <tr>
                  <td style="max-width: 300px"><span class="profile-label"><small style="white-space: normal;word-wrap: break-word;overflow-wrap: break-word;">${committee.title}</small></span></td>
                  <td><span class="profile-label px-4"><small>${committee.position}</small></span></td>
                  <td>
                      <span class="text-capitalize">
                          <small>${committee.personel}</small>
                          <br />
                          <small>${committee.contact ?? ''}</small>
                          <br />
                          <small>${committee.email ?? ''}</small>
                          <br />
                          <small>${committee.email2 ?? ''}</small>
                      </span>
                  </td> 
              </tr>
          `);
      });
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

  // filter by minority or majority
  $('#filter-minormajor').on('change', function() {
      let val = $(this).val();
      $('#minormajor-value-holder').val(val);
      $('#filter-minormajor-form').submit();
  });

  // filter by affiliation
  $('#filter-affiliation').on('change', function() {
      let val = $(this).val();
      $('#affiliation-value-holder').val(val);
      $('#filter-affiliation-form').submit();
  });

</script>
@endsection