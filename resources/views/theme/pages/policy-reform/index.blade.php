@extends('theme.main')

@section('pagecss')
<style>

</style>
@endsection

@section('content')

@php

@endphp

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="d-flex justify-content-between align-items center">

            <div class="heading-block border-0 mb-4 form-title">
                <b>POLICY REFORMS</b>
            </div>

            <div class="control-set d-flex justify-content-between align-items center g-2">
                <form method="get" action="#">
                    <div class="d-flex justify-content-between align-items-center">
                        <input class="form-control mx-2" placeholder="Search" name="member_name" value="{{ request('member_name') }}" style="min-width: 200px;" />
                    </div>
                </form>

                <select class="form-select" style="height: 40px;">
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button class="btn text-uppercase text-white custom-primary-bg mx-2" style="min-width: 165px; max-height: 40px;">Propose a bill</button>
            </div>
            
        </div>
    </div>

    <div class="row g-5">

        @forelse($bills as $bill)
        <div class="col-12 col-lg-6">
            <div class="card border-0">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $bill->photo }}">
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-between">
                        <div class="p-2">
                            <h5>{{ $bill->title }}</h5>
                            <ul class="list-unstyled mb-2">
                                <li><i class="icon-users" style="font-size: 12px; opacity: .7;"></i> <small><b>{{ $bill->category }}</b></small></li>
                                <li><i class="icon-calendar" style="font-size: 12px; opacity: .7;"></i> <small><b>{{ $bill->until }}</b></small></li>
                                <li><i class="icon-check-circle" style="font-size: 12px; opacity: .7;"></i> <small><b>{{ $bill->like }} out of {{ $bill->target_votes }} votes</b></small></li>
                            </ul>
                            <p class="p-0">{{ $bill->description }}</p>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <button class="bg-white border-0" style="width: fit-content;">Read more <b><i class="bi-chevron-double-right custom-text-primary"></i></b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <p>No bills proposed yet.</p>
        @endforelse

    </div>
</div>

@endsection

@section('pagejs')
    
@endsection

