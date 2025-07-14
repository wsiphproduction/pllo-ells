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
        top: 40%;
        left: 9%;
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
                    </select>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-birthmonth" style="height: 38px;">
                        <option selected disabled>BIRTHMONTH</option>
                        @foreach(config('months') as $month)
                        <option>{{ $month }}</option>
                        @endforeach
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
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-uppercase">{{ $member->fullName }}</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-person me-2"></i>{{ $member->full_designation_name }}</li>
                                        <li><i class="bi-building me-2"></i>{{ $member->full_agency_name }}</li>
                                        <li><i class="bi-phone me-2"></i>{{ $member->contact_number }}</li>
                                        <li><i class="bi-mailbox me-2"></i>{{ $member->email }}</li>
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
                                <i class="icon-user-plus mr-2"></i> &nbsp; <small>Add Contact</small>
                            </button>
                            @else
                            <button class="btn btn-success btn-sm contact-btn-style saved-contact-btn" title="Contact already saved." disabled>
                                <i class="icon-user-check mr-2"></i> &nbsp; <small>Contact Saved</small>
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
                                    <small class="lh-1"><b class="text-capitalize">{{ $member->FullName }}</b></small>
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

</script>
@endsection