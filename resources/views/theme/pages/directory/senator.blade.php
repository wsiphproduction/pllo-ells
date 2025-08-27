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
            <form method="get" action="{{ route('directory.senators') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <input class="form-control" placeholder="Search Member Name" name="member_name" value="{{ request('member_name') }}"/>
                    <button type="button" class="btn btn-transparent p-1" id="grid-view-btn" title="Grid View"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                    <button type="button" class="btn btn-transparent p-1" id="list-view-btn" title="List View"><i class="bi-list-ul fa-1x custom-text-primary"></i></button>
                    <a href="{{ route('directory.senators') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                </div>
            </form>
        </div>

        <div id="portfolio" class="row g-4">
            
            @foreach($members as $member)
                <article class="portfolio-item col-md-6 col-12 member-grid-view">
                    <div class="card mb-4 p-3 border-0">
                        <div class="row g-0 relative">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="{{ asset($member->image_url) }}"
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
                                        data-position="Senator"
                                        data-number="{{ $member->office_cellphone }}"
                                        data-email="{{ $member->email }}"
                                        data-party="{{ $member->party }}"
                                        data-province="{{ $member->province_address }}"

                                        data-sname_sen_staff="{{ $member->sen_staff_name }}"
                                        data-snumber_sen_staff="{{ $member->sen_staff_number }}"
                                        data-semail_sen_staff="{{ $member->sen_staff_email }}"

                                        data-sname_sen_officer="{{ $member->sen_officer_name }}"
                                        data-snumber_sen_officer="{{ $member->sen_officer_number }}"
                                        data-semail_sen_officer="{{ $member->sen_officer_email }}"

                                        data-sname_sen_secretary="{{ $member->sen_secretary_name }}"
                                        data-snumber_sen_secretary="{{ $member->sen_secretary_number }}"
                                        data-semail_sen_secretary="{{ $member->sen_secretary_email }}">
                                        {{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }} 
                                    </h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li class="text-capitalize"><i class="bi-person me-2"></i>{{ $member->position }}</li>
                                        @if($member->office_cellphone_agree)
                                        <li><i class="bi-phone me-2"></i>{{ $member->office_cellphone }}</li>
                                        @endif
                                        @if($member->email_agree)
                                        <li><i class="bi-envelope me-2"></i>{{ $member->email }}</li>
                                        @endif
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
                                     src="{{ $member->image_url ? asset('/' . $member->image_url) : asset('images/user.png') }}"
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
                                        data-position="Senator"
                                        data-number="{{ $member->office_cellphone }}"
                                        data-email="{{ $member->email }}"
                                        data-party="{{ $member->party }}"
                                        data-province="{{ $member->province_address }}"

                                        data-sname_sen_staff="{{ $member->sen_staff_name }}"
                                        data-snumber_sen_staff="{{ $member->sen_staff_number }}"
                                        data-semail_sen_staff="{{ $member->sen_staff_email }}"

                                        data-sname_sen_officer="{{ $member->sen_officer_name }}"
                                        data-snumber_sen_officer="{{ $member->sen_officer_number }}"
                                        data-semail_sen_officer="{{ $member->sen_officer_email }}"

                                        data-sname_sen_secretary="{{ $member->sen_secretary_name }}"
                                        data-snumber_sen_secretary="{{ $member->sen_secretary_number }}"
                                        data-semail_sen_secretary="{{ $member->sen_secretary_email }}">
                                        {{ $member->FullName }}</b></small>
                                    @if(!empty($member->position))
                                    <small class="lh-1"><i>{{ $member->position }}</i></small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>
                                    @if($member->office_cellphone_agree)
                                    <small>{{ $member->office_cellphone }}</small>
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
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><span class="text-capitalize view-info-name"></span>&nbsp;<span></span></h5>
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
                    <li class="nav-item" role="presentation" id="staff-tab-container">
                        <button class="nav-link" id="staff-tab-trigger" data-bs-toggle="pill" data-bs-target="#staff-tab" type="button" role="tab" aria-controls="staff-tab" aria-selected="true"><small>CoS | CLO | AS</small>
                        </button>
                    </li>
                    <!-- <li class="nav-item" role="presentation" id="committee-tab-container">
                        <button class="nav-link" id="committee-tab-trigger" data-bs-toggle="pill" data-bs-target="#committee-tab" type="button" role="tab" aria-controls="committee-tab" aria-selected="true">Committee
                        </button>
                    </li> -->
                </ul>
                <div class="tab-content mb-3 relative">

                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile-tab" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label">Designation:</span></td>
                                <td><span class="view-info-position text-capitalize"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Party Affiliation:</span></td>
                                <td><span id="view-info-party" class="text-capitalize"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Province:</span></td>
                                <td><span id="view-info-province" class="text-capitalize"></span></td>
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
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>Chief of Staff</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_staff"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber-sen_staff"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_staff"></span></td>
                            </tr>
                        </table>

                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>Chief Legis Officer</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_officer"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber-sen_officer"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_officer"></span></td>
                            </tr>
                        </table>

                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label">Position:</span></td>
                                <td><span class="view-info-default custom-text-primary"><b>Appointment Secretary</b></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Name:</span></td>
                                <td><span class="view-info-sname-sen_secretary"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Contact Number:</span></td>
                                <td><span id="view-info-snumber-sen_secretary"></span></td>
                            </tr>
                            <tr>
                                <td><span class="profile-label">Email Address:</span></td>
                                <td><span id="view-info-semail-sen_secretary"></span></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Committee Tab -->
                    <!-- <div class="tab-pane fade" id="committee-tab" role="tabpanel" aria-labelledby="committee-tab" tabindex="0">
                        <table class="table-dotted table-striped">
                            <tr>
                                <td><span class="profile-label"></span></td>
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
                    </div> -->
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
      let number = $(this).attr('data-number');
      let email = $(this).attr('data-email');
      let party = $(this).attr('data-party');
      let province = $(this).attr('data-province');

      let sname_sen_staff = $(this).attr('data-sname_sen_staff');
      let snumber_sen_staff = $(this).attr('data-snumber_sen_staff');
      let semail_sen_staff = $(this).attr('data-semail_sen_staff');

      let sname_sen_officer = $(this).attr('data-sname_sen_officer');
      let snumber_sen_officer = $(this).attr('data-snumber_sen_officer');
      let semail_sen_officer = $(this).attr('data-semail_sen_officer');

      let sname_sen_secretary = $(this).attr('data-sname_sen_secretary');
      let snumber_sen_secretary = $(this).attr('data-snumber_sen_secretary');
      let semail_sen_secretary = $(this).attr('data-semail_sen_secretary');

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
      $('#view-info-number').text(number);
      $('#view-info-email').text(email);
      $('#view-info-party').text(party);
      $('#view-info-province').text(province);

      $('.view-info-sname-sen_staff').text(sname_sen_staff);
      $('#view-info-snumber-sen_staff').text(snumber_sen_staff);
      $('#view-info-semail-sen_staff').text(semail_sen_staff);

      $('.view-info-sname-sen_officer').text(sname_sen_officer);
      $('#view-info-snumber-sen_officer').text(snumber_sen_officer);
      $('#view-info-semail-sen_officer').text(semail_sen_officer);

      $('.view-info-sname-sen_secretary').text(sname_sen_secretary);
      $('#view-info-snumber-sen_secretary').text(snumber_sen_secretary);
      $('#view-info-semail-sen_secretary').text(semail_sen_secretary);
  });

</script>
@endsection