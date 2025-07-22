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

        <div class="col-12 mb-0">
            <div class="col-12">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
                <small>Summary status Update as of {{ \Carbon\Carbon::parse(now())->format('M d, Y') }}</small>
            </div>

            <div class="row mt-4">
                <div class="col-8">
                    <form method="get" action="{{ route('downloads.republic-acts') }}">
                        <div class="d-flex align-items-center">

                            <input class="form-control me-2" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>

                            <select class="form-control me-2" name="source_priority_level">
                                <option disabled {{ !request('source_priority_level') ? 'selected' : '' }}>SOURCE</option>
                                @foreach ($republic_acts->pluck('source_priority_level')->unique()->filter()->sort() as $level)
                                    <option value="{{ $level }}" {{ request('source_priority_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>

                            <select class="form-control me-2" name="approved_on">
                                <option disabled {{ !request('approved_on') ? 'selected' : '' }}>APPROVED ON</option>
                                @foreach ($republic_acts->pluck('approved_on')->unique()->filter()->sort() as $date)
                                    <option value="{{ $date }}" {{ request('approved_on') == $date ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                                    </option>
                                @endforeach
                            </select>

                            <select class="form-control me-2" name="congress">
                                <option disabled {{ !request('congress') ? 'selected' : '' }}>CONGRESS</option>
                                @foreach ($republic_acts->pluck('congress')->unique()->filter()->sort() as $congress)
                                    <option value="{{ $congress }}" {{ request('congress') == $congress ? 'selected' : '' }}>
                                        {{ $congress }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success me-2"><i class="uil-search"></i></button>
                            <a href="{{ route('downloads.republic-acts') }}" type="button" class="btn btn-light btn-outline-success me-1">Clear</a>

                        </div>
                    </form>
                </div>

                <div class="col-4 text-end">
                    <button type="button" class="btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')"><i class="uil-upload"></i> UPLOAD</button>
                </div>

            </div>
        </div>
                
        {{-- <div class="col-12 mb-5 d-flex justify-content-between align-items-center">
            <div class="col-4">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
                <small>Summary status Update as of {{ \Carbon\Carbon::parse(now())->format('M d, Y') }}</small>
            </div>

            <form method="get" action="{{ route('downloads.republic-acts') }}">
                <div class="d-flex align-items-center">

                    <input class="form-control me-2" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>

                    <select class="form-control me-2" name="source_priority_level">
                        <option disabled {{ !request('source_priority_level') ? 'selected' : '' }}>SOURCE</option>
                        @foreach ($republic_acts->pluck('source_priority_level')->unique()->filter()->sort() as $level)
                            <option value="{{ $level }}" {{ request('source_priority_level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>

                    <select class="form-control me-2" name="approved_on">
                        <option disabled {{ !request('approved_on') ? 'selected' : '' }}>APPROVED ON</option>
                        @foreach ($republic_acts->pluck('approved_on')->unique()->filter()->sort() as $date)
                            <option value="{{ $date }}" {{ request('approved_on') == $date ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                            </option>
                        @endforeach
                    </select>

                    <select class="form-control me-2" name="congress">
                        <option disabled {{ !request('congress') ? 'selected' : '' }}>CONGRESS</option>
                        @foreach ($republic_acts->pluck('congress')->unique()->filter()->sort() as $congress)
                            <option value="{{ $congress }}" {{ request('congress') == $congress ? 'selected' : '' }}>
                                {{ $congress }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-success me-2"><i class="uil-search"></i></button>
                    <a href="{{ route('downloads.republic-acts') }}" type="button" class="btn btn-light btn-outline-success me-1">Clear</a>
                    <button type="button" class="form-control btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')"><i class="uil-upload"></i> UPLOAD</button>

                </div>
            </form>
        </div> --}}

        <div class="col-12 mb-5">
            <table id="datatable" class="table table-hover text-start" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>RA/JR NO.</th>
                        <th>SOURCE / PRIORITY LEVEL</th>
                        <th>APPROVED ON</th>
                        <th>CONGRESS</th>
                        <th width="50%">LONG TITLE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($republic_acts as $republic_act)
                        <tr>
                            <td><a href="javascript:void(0);" onclick="$('#attachmentsModal{{ $republic_act->id }}').modal('show')"><strong class="text-primary">{{ $republic_act->ra_jr_no }}</strong></a></td>
                            <td>{{ $republic_act->source_priority_level }}</td>
                            <td>{{ \Carbon\Carbon::parse($republic_act->approved_on)->format('F d, Y') }}</td>
                            <td>{{ $republic_act->congress }}</td>
                            <td>{{ $republic_act->long_title }}</td>
                        </tr>

                        {{-- ATTACHMENTS --}}
                        <div class="modal fade" id="attachmentsModal{{ $republic_act->id }}" tabindex="-1" aria-labelledby="attachmentsModalLabel{{ $republic_act->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="attachmentsModalLabel{{ $republic_act->id }}"><i class="uil-paperclip"></i> View Attachments</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <strong><small>Title:</small></strong>
                                        <p class="mb-3">{{ $republic_act->long_title }}</p>

                                        <strong><small>Attachments:</small></strong>

                                        @php
                                            $attachments = json_decode($republic_act->attachments, true);
                                        @endphp

                                        @if (!empty($attachments) && is_array($attachments))
                                            <ul class="list-unstyled">
                                                @foreach ($attachments as $file)
                                                    <li>
                                                        <a href="{{ asset($file) }}" target="_blank">
                                                            {{ basename($file) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">No attachments found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- <div class="d-flex justify-content-center">
                {{ $republic_acts->links() }}
            </div> --}}
        </div>

    </div>


    {{-- MODALS --}}

    <div class="modal fade" id="creationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <strong class="custom-text-primary">UPLOAD DOWNLOADABLE</strong><br>

                    <div class="row mt-3">
                        <form id="creation_form" action="{{ route('downloads.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="d-block">Long Title *</label>
                                <input type="text" name="long_title" id="long_title" value="{{ old('long_title')}}" class="form-control @error('long_title') is-invalid @enderror" maxlength="150" required>
                                @error('long_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="d-block">RA / JR Number *</label>
                                <input type="text" name="ra_jr_no" id="ra_jr_no" value="{{ old('ra_jr_no')}}" class="form-control @error('ra_jr_no') is-invalid @enderror" maxlength="150" required>
                                @error('ra_jr_no')
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
                                <input type="date" name="approved_on" id="approved_on" value="{{ \Carbon\Carbon::now()->toDateString() }}" class="form-control @error('approved_on') is-invalid @enderror" maxlength="150" required>
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
                                <input type="file" name="attachments[]" class="form-control @error('attachments') is-invalid @enderror" accept=".pdf, .csv, .xlsx, .xls, .pdf" multiple required>
                                {{-- <small>File type: PDF, CSV, XLSX, XLS<br/> Maximum file size: 2MB</small> --}}
                                <br/>
                                @error('attachments')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- TYPE --}}
                            <input type="hidden" name="type" value="RA" class="form-control" required>
                            
                            <button type="submit" class="btn bg-custom-primary text-white mt-3" onclick="document.getElementById('creation_form').submit();"><small>SUBMIT</small></button>
                            <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>

                        </form>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejs')
    <script>
        jQuery(document).ready(function() {
            jQuery.fn.dataTable.ext.errMode = 'none';

            var table = jQuery('#datatable').DataTable({
                searching: false,
                paging: true,
                info: true,
                order: [[ 0, 'desc' ]]
            });
        });
    </script>
@endsection

