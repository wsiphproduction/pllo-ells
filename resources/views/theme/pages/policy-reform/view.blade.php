@extends('theme.main')

@section('pagecss')
<style>
    .aside-utils button:hover {
        font-weight: 700;
    }
    .aside-socials a.social-icons {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 100px;
        color: white;
        opacity: .8;
    }
    .aside-socials a.social-icons.social-pinterest {
        background-color: #c8232c;
    }
    .aside-socials a.social-icons.social-twitter {
        background-color: #1DA1F2;
    }
    .aside-socials a.social-icons.social-facebook {
        background-color: #3B5998;
    }
    .aside-socials a.social-icons.social-google {
        background-color: #eb4034;
    }
    .aside-socials a.social-icons.social-linkedin {
        background-color: #0077B5;
    }
    .aside-socials a.social-icons:hover {
        scale: 1.05;
        opacity: 1;
    }
</style>
@endsection

@section('content')

@php

@endphp

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="d-flex justify-content-between align-items center">

            <div class="heading-block border-0 mb-4 form-title">
                <b>POLICY REFORM</b>
            </div>

        </div>


    </div>
    <div class="row">
        
        <aside class="col-12 col-md-3">
            <div class="card shadow p-2">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <p class="pb-4">Proposed by:</p>
                        <div class="d-flex pb-3" style="border-bottom: 1px dotted gray;">
                            <img class="rounded" src="{{ asset('/' . $bill->member->photo ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                            <div class="d-flex flex-column ms-3">
                                <b>{{ $bill->member->FullName }}</b>
                                @if(!empty($bill->member->designation))
                                    <small>{{ $bill->member->designationDetails->name }}</small>
                                @else
                                    <!-- nothing for now -->
                                @endif
                            </div>
                        </div>
                        <div class="aside-votes pt-3 pb-2">
                            <p><b>{{ $bill->like }} out of {{ $bill->target_votes }}</b></p>
                            <p><b>Until {{ date('F d, Y', strtotime($bill->until)) }}</b></p>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php
                                $val = ($bill->like / $bill->target_votes) * 100;
                            @endphp
                            <div class="progress-bar" role="progressbar" style="width: {{$val}}%; height: 8px;" aria-valuenow="{{$val}}" aria-valuemin="0" aria-valuemax="{{ $bill->target_votes }}"></div>
                        </div>
                        <div class="d-flex gap-2 py-3">
                            @if($bill->like != $bill->target_votes)
                                @if(empty($like))
                                    <button class="btn custom-primary-bg text-white w-100 btn-like" data-id="{{ $bill->id }}" data-bs-toggle="modal" data-bs-target="#likeModal">Like</button>
                                @else
                                    <button class="btn custom-primary-bg text-white w-100"disabled>Liked</button>
                                @endif
                                @if(empty($dislike))
                                    <button class="btn btn-secondary w-100 btn-dislike" data-id="{{ $bill->id }}" data-bs-toggle="modal" data-bs-target="#dislikeModal">Dislike</button>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>Disliked</button>
                                @endif
                            @else
                                <button class="btn btn-success text-white w-100" disabled>VOTING COMPLETED</button>
                            @endif
                        </div>
                        <div class="aside-utils">
                            <div class="d-flex flex-column gap-2">
                                @if(empty($bookmark))
                                    <button class="d-flex align-items-center gap-2 border-0 bg-white btn-bookmark" data-id="{{ $bill->id }}" data-bs-toggle="modal" data-bs-target="#bookmarkModal">
                                        <i class="icon-bookmark"></i> <small>Bookmark</small>
                                    </button>
                                @else
                                    <button class="d-flex align-items-center gap-2 border-0 bg-white btn-unbookmark" data-id="{{ $bill->id }}" data-bs-toggle="modal" data-bs-target="#unbookmarkModal">
                                        <i class="icon-bookmark-empty"></i> <small>Unbookmark</small>
                                    </button>
                                @endif
                                <button class="d-flex align-items-center gap-1 border-0 bg-white btn-refresh"><i class="icon-refresh"></i> <small>Update Status</small></button>
                            </div>
                        </div>
                        <div class="d-flex flex-column py-3">
                            <h5 class="mb-2">Latest Likers</h5>
                            @forelse($likers as $liker)
                                <div class="d-flex py-2" style="border-bottom: 1px dotted gray;">
                                    <img class="rounded" src="{{ asset('/' . $liker->photo ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                                    <div class="d-flex flex-column ms-3">
                                        <b>{{$liker->firstname}} {{$liker->lastname}}</b>
                                        <small>{{$liker->name}}</small>
                                    </div>
                                </div>
                            @empty
                            <small style="opacity: .7"><i>No likers for now.</i></small>
                            @endforelse
                        </div>
                        <h5 class="mb-2">Share this!</h5>
                        <div class="d-flex aside-socials gap-2">
                            <a href="http://pinterest.com" target="_blank" class="social-icons social-pinterest">
                                <i class="icon-pinterest"></i>
                            </a>
                            <a href="http://twitter.com" target="_blank" class="social-icons social-twitter">
                                <i class="icon-twitter"></i>
                            </a>
                            <a href="http://facebook.com" target="_blank" class="social-icons social-facebook">
                                <i class="icon-facebook"></i>
                            </a>
                            <a href="http://google.com" target="_blank" class="social-icons social-google">
                                <i class="icon-google"></i>
                            </a>
                            <a href="http://linkedin.com" target="_blank" class="social-icons social-linkedin">
                                <i class="icon-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-12 col-md-9">
            <div class="d-flex flex-column">

                <h5 class="mb-1">{{ $bill->title }}</h5>
                <small class="mb-4 text-capitalize"><i class="icon-users" style="opacity: .7"></i> {{ $bill->policyReformCategory->name }}</small>
                <div class="bill-photo-container rounded" style="
                                                        width: 100%; 
                                                        min-height: 400px; 
                                                        max-height: 400px;
                                                        background-image: url('{{ asset('/' . $bill->photo ) }}');
                                                        background-repeat: no-repeat;
                                                        background-size: cover;
                                                        background-position: center;
                                                        ">
                </div>

                <div class="bill-body-container my-4">
                    <p>{{ $bill->description }}</p>
                </div>

                <div class="feedback-conteiner mt-4">
                    <h5 class="pt-4 pb-2" style="border-bottom: 1px dotted black;">Comments | Suggestions | Message</h5>

                    <div class="feedback-items-conteiner d-flex flex-column gap-3">
                        @forelse($comments as $comment)
                            <div class="feedback-item d-flex">
                                <div class="col-1">
                                    <img class="rounded shadow" src="{{ asset('/' . $comment->member->photo ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                                </div>
                                <div class="col-11">
                                    <div class="card shadow p-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <p><b class="text-capitalize">{{ $comment->member->FullName }}</b></p>
                                            <p><b>{{ date('F d, Y', strtotime($comment->created_at)) }}</b></p>
                                        </div>
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <!-- nothing for now -->
                        @endforelse
                    </div>
                </div>

                <div class="d-flex align-items-start mt-4">
                    <div class="col-1">
                        <img class="rounded shadow" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                    </div>
                    <div class="col-11">
                        <form action="{{ route('policyreform.comment') }}" method="post" class="d-flex align-items-center gap-2">
                        @csrf
                            <input type="text" name="comment" class="form-control shadow" placeholder="Enter your coments..">
                            <input type="hidden" name="bill_id" id="bill_id" value="{{ $bill->id }}">
                            <button class="btn custom-primary-bg text-white w-25 shadow">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        
    </div>

</div>

<!-- Bookmark Modal -->
<div class="modal fade" id="bookmarkModal" tabindex="-1" aria-labelledby="bookmarkLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookmarkModalLabel">Bookmark Policy Reform</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to bookmark this Policy Reform?
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('policyreform.bookmark') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="policy_reform_id" id="policy_reform_id">
            <button type="submit" class="btn btn-success">Yes, Bookmark this!</button>
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Bookmark Modal -->
<div class="modal fade" id="unbookmarkModal" tabindex="-1" aria-labelledby="unbookmarkLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unbookmarkModalLabel">Unbookmark Policy Reform</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to unbookmark this Policy Reform?
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('policyreform.unbookmark') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="bookmark_id" id="bookmark_id">
            <button type="submit" class="btn btn-warning">Yes, Unbookmark this!</button>
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Like Modal -->
<div class="modal fade" id="likeModal" tabindex="-1" aria-labelledby="likeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="likeModalLabel">Like Policy Reform</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to like this Policy Reform?
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('policyreform.like') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="like_id" id="like_id">
            <button type="submit" class="btn btn-primary">Yes, I like it!!</button>
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Like Modal -->
<div class="modal fade" id="dislikeModal" tabindex="-1" aria-labelledby="dislikeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dislikeModalLabel">Dislike Policy Reform</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to dislike this Policy Reform?
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('policyreform.dislike') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="dislike_id" id="dislike_id">
            <button type="submit" class="btn btn-warning">Dislike</button>
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('pagejs')
<script>

    // bookmark
    $('.btn-bookmark').on('click', function() {
        let num = $(this).attr('data-id');
        $('#policy_reform_id').val(num);
    });

    // unbookmark
    $('.btn-unbookmark').on('click', function() {
        let num = $(this).attr('data-id');
        $('#bookmark_id').val(num);
    });

    // refresh page
    $('.btn-refresh').on('click', function() {
        location.reload();
    });

    // like
    $('.btn-like').on('click', function() {
        let num = $(this).attr('data-id');
        $('#like_id').val(num);
    });

    // dislike
    $('.btn-dislike').on('click', function() {
        let num = $(this).attr('data-id');
        $('#dislike_id').val(num);
    });

</script>
@endsection

