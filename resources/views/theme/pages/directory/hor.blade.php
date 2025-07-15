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
</style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
            <form method="get" action="{{ route('directory') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <input class="form-control" placeholder="Search Member Name" name="member_name" value="{{ request('member_name') }}"/>
                    <button type="button" class="btn btn-transparent p-1"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                    <a href="{{ route('directory') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                </div>
            </form>
        </div>

        <div id="portfolio" class="row g-4">
            
            @foreach($members as $member)
                <article class="portfolio-item col-md-6 col-12">
                    <div class="card mb-4 p-3 border-0">
                        <div class="row g-0 relative">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="{{ asset($member->image_url) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: cover;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold text-uppercase">
                                        {{ $member->firstname }} {{ $member->middle_initial }}@if($member->middle_initial).@endif {{ $member->lastname }} 
                                    </h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li class="text-capitalize"><i class="bi-person me-2"></i>House of Representatives</li>
                                        <li><i class="bi-phone me-2"></i>{{ $member->office_cellphone }}</li>
                                        <li><i class="bi-mailbox me-2"></i>{{ $member->email }}</li>
                                    </ul>
                                </div>
                            </div>
                            @if(!@$member->is_contact_exist($member->id))
                            <button class="btn btn-primary btn-sm contact-btn-style add-contact-btn" data-id="{{ $member->id }}" data-bs-toggle="modal" data-bs-target="#addContactModal" title="Click to add contact" disabled>
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

        </div>

    </div>

   

@endsection

@section('pagejs')
<script>

  

</script>
@endsection