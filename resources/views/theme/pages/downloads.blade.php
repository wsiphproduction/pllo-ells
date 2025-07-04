@extends('theme.main')

@section('pagecss')
    <style>
		.bg-custom-primary {
			background-color: #3c5d90 !important;
		}
    </style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-5 d-flex justify-content-between align-items-center">
            <div class="col-4">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
                <small>Summary status Update as of {{ \Carbon\Carbon::parse(now())->format('M d, Y') }}</small>
            </div>

            <form method="get" action="{{ route('downloads') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('downloads') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                    {{-- <button type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-filter fa-1x custom-text-primary"></i></button> --}}
                    
                    <input class="form-control" placeholder="Search" name="search" value="{{ request('search') }}"/>&nbsp;&nbsp;
                    <button type="button" class="form-control btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')"><i class="uil-upload"></i> UPLOAD</button>
                </div>
            </form>
        </div>

        <div class="col-12 mb-3">
            <table class="table table-hover ">
                <thead class="table-primary">
                    <tr>
                        <th>RA / JR NO.</th>
                        <th>SOURCE / PRIORITY LEVEL</th>
                        <th>APPROVED ON</th>
                        <th>CONGRESS</th>
                        <th width="50%">LONG TITLE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $download)
                        <tr>
                            <td><a href="{{ env('APP_URL').'/storage/downloadables/'.$download->file_url}}" target="_blank"><strong class="text-primary">{{ $download->ra_jr }}</strong></a></td>
                            <td>{{ $download->source_priority_level }}</td>
                            <td>{{ \Carbon\Carbon::parse($download->approved_on)->format('M d, Y') }}</td>
                            <td>{{ $download->congress }}</td>
                            <td>{{ $download->title }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $downloads->links() }}
            </div>
        </div>

    </div>


    {{-- MODALS --}}

    <div class="modal fade" id="creationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <strong class="custom-text-primary">UPLOAD DOWNLOADABLE</strong><br>

                    <div class="row mt-3">
                        <form id="creation_form" action="{{ route('downloadables.front.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="d-block">Long Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title')}}" class="form-control @error('title') is-invalid @enderror" maxlength="150" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="d-block">RA / JR Number *</label>
                                <input type="text" name="ra_jr" id="ra_jr" value="{{ old('ra_jr')}}" class="form-control @error('ra_jr') is-invalid @enderror" maxlength="150" required>
                                @error('ra_jr')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror             
                            </div>

                            <div class="form-group">
                                <label class="d-block">Congress *</label>
                                <input type="text" name="congress" id="congress" value="{{ old('congress')}}" class="form-control @error('congress') is-invalid @enderror" maxlength="150" required>
                                @error('congress')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror             
                            </div>

                            <div class="form-group">
                                <label class="d-block">Approved On *</label>
                                <input type="date" name="approved_on" id="approved_on" value="{{ old('approved_on')}}" class="form-control @error('approved_on') is-invalid @enderror" maxlength="150" required>
                                @error('approved_on')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror             
                            </div>

                            <div class="form-group">
                                <label class="d-block">Source / Priority Level *</label>
                                <input type="text" name="source_priority_level" id="source_priority_level" value="{{ old('source_priority_level')}}" class="form-control @error('source_priority_level') is-invalid @enderror" maxlength="150" required>
                                @error('source_priority_level')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror             
                            </div>

                            <div class="form-group">
                                <label class="d-block">File</label>
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                                {{-- <small>File type: PDF, CSV, XLSX, XLS<br/> Maximum file size: 2MB</small> --}}
                                <br/>
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            
                            <button type="submit" class="btn bg-custom-primary text-white mt-3" onclick="document.getElementById('creation_form').submit();"><small>SUBMIT</small></button>
                            <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>

                        </form>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>

@endsection

