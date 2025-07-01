@extends('theme.main')

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
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="{{ asset($member->photo) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/images/icons/avatar.jpg') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 custom-text-primary fw-bold">{{ $member->fullName }}</h6>
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
                        </div>
                    </div>
                </article>
            @endforeach

        </div>
    </div>

@endsection

