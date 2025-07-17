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
                            <img class="rounded" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                            <div class="d-flex flex-column ms-3">
                                <b>William</b>
                                <small>Private Citizen</small>
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
                            <button class="btn custom-primary-bg text-white w-100">Like</button>
                            <button class="btn btn-secondary w-100">Dislike</button>
                        </div>
                        <div class="aside-utils">
                            <div class="d-flex flex-column gap-2">
                                <button class="d-flex align-items-center gap-2 border-0 bg-white btn-bookmark"><i class="icon-bookmark"></i> <small>Bookmark</small></button>
                                <button class="d-flex align-items-center gap-1 border-0 bg-white btn-refresh"><i class="icon-refresh"></i> <small>Update Status</small></button>
                            </div>
                        </div>
                        <div class="d-flex flex-column py-3">
                            <h5 class="mb-2">Latest Likers</h5>
                            <div class="d-flex py-2" style="border-bottom: 1px dotted gray;">
                                <img class="rounded" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                                <div class="d-flex flex-column ms-3">
                                    <b>William</b>
                                    <small>Private Citizen</small>
                                </div>
                            </div>
                            <div class="d-flex py-2" style="border-bottom: 1px dotted gray;">
                                <img class="rounded" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                                <div class="d-flex flex-column ms-3">
                                    <b>William</b>
                                    <small>Private Citizen</small>
                                </div>
                            </div>
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
                        <div class="feedback-item d-flex">
                            <div class="col-1">
                                <img class="rounded shadow" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                            </div>
                            <div class="col-11">
                                <div class="card shadow p-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p><b>Leo Andrew Del Monte</b></p>
                                        <p><b>April 25, 2023</b></p>
                                    </div>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-start mt-4">
                    <div class="col-1">
                        <img class="rounded shadow" src="{{ asset('/' . Auth::user()->avatar ) }}" style="width: 75px; height: 75px; object-fit: cover;">
                    </div>
                    <div class="col-11">
                        <form action="#" method="post" class="d-flex align-items-center gap-2">
                        @csrf
                            <input type="text" name="feedback" class="form-control shadow" placeholder="Enter your coments..">
                            <button class="btn custom-primary-bg text-white w-25 shadow">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        
    </div>

</div>

@endsection

@section('pagejs')

@endsection

