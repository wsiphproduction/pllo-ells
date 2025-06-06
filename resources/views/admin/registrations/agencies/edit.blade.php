@extends('admin.layouts.app')

@section('pagetitle')
    Create Page
@endsection

@section('pagecss')
    <link href="{{ asset('css/font-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/et-line.css') }}" rel="stylesheet">
    <link href="{{ asset('css/medical-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/realestate-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/grapesjs/dist/css/grapes.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/assets/css/custom-grapesjs.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/linearicon/css/linearicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tooltip.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/grapesjs-plugin-filestack.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-color-picker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-image-editor.min.css') }}" />
@endsection

@section('content')

<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('registration.agency-list')}}">Agency</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Agency</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit Agency</h4>
        </div>
    </div>
    <form method="post" action="{{ route('registration.agency-store') }}" enctype="multipart/form-data">
        <div class="row row-sm">
            <div class="col-lg-6">

                @csrf

                <div class="form-group">
                    <label class="d-block">Agency Name <span class="text-danger ">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $agency->name }}" required>
                </div>

                <div class="form-group">
                    <label class="d-block">Description <span class="text-danger ">*</span></label>
                    <textarea rows="3" class="form-control" name="description">{{ $agency->description }}</textarea>
                </div>

            </div>
          
            <div class="col-lg-12 mg-t-30">
                <input class="btn btn-primary btn-sm btn-uppercase" type="submit" value="Save Page">
                <a href="{{ route('registration.agency-list') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection

@section('pagejs')
    
@endsection

@section('customjs')

@endsection
