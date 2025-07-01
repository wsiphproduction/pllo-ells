@extends('admin.layouts.app')


@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .select2 {width:100% !important;}

        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            position: relative;
            margin-top: 4px;
            margin-right: 4px;
            padding: 3px 10px 3px 20px;
            border-color: transparent;
            border-radius: 1px;
            background-color: #0168fa;
            color: #fff;
            font-size: 13px;
            line-height: 1.45;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            color: #fff;
            opacity: .5;
            font-size: 14px;
            font-weight: 400;
            display: inline-block;
            position: absolute;
            top: 4px;
            left: 7px;
            line-height: 1.2;
        }
    </style>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('downloadables.index')}}">Downloadables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Downloadable</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Update Downloadable</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('downloadables.update',$fileDownload->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @php
                        $arr_depts = substr($fileDownload->department_id, 1, -1);
                        $depts     = explode(',', $arr_depts);

                        $arr_department = [];
                        foreach($depts as $dept){
                            array_push($arr_department,str_replace('"','',$dept));
                        }
                    @endphp

                    <div class="form-group">
                        <label class="d-block">Permission/Department *</label>
                        <input type="hidden" name="id" value="{{$fileDownload->id}}">
                        <select class="form-control select2 @error('department_id') is-invalid @enderror" multiple="multiple" name="department_id[]">
                            <option label="Choose one"></option>
                            @foreach($departments as $dept)
                                <option @if(in_array($dept->id, $arr_department)) selected @endif value="{{$dept->id}}">{{$dept->title}}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">Category *</label>
                        <select id="parentPage" class="selectpicker mg-b-5 @error('category_id') is-invalid @enderror" name="category_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%" required>
                            <option value="" selected>Choose One</option>
                            @foreach($categories as $cat)
                            <option @if($fileDownload->category_id == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->title}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title',$fileDownload->title)}}" class="form-control @error('title') is-invalid @enderror" maxlength="150" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">Document # *</label>
                        <input type="text" name="version_no" id="version_no" value="{{ old('version_no',$fileDownload->version_no)}}" class="form-control @error('version_no') is-invalid @enderror" maxlength="150">
                        @error('version_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">File</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                        <small>File type: PDF, CSV, XLSX, XLS<br/> Maximum file size: 2MB</small>
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <br/><br/>
                        <a href="{{ env('APP_URL').'/storage/downloadables/'.$fileDownload->file_url}}" target="_blank">{{$fileDownload->file_url}}</a>
                    </div>

                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update Downloadable</button>
                    <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('downloadables.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(function() {
            $('.select2').select2({
                placeholder: 'Choose Options'
            });

            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
