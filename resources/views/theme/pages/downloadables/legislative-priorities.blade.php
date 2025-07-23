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
                    <form method="get" action="{{ route('downloads.legislative-priorities') }}">
                        <div class="d-flex align-items-center">

                            <input class="form-control me-2" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>

                            <select class="form-control me-2" name="status">
                                <option disabled {{ !request('status') ? 'selected' : '' }}>STATUS</option>
                                @foreach ($legislative_priorities->pluck('status')->unique()->filter()->sort() as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            <select class="form-control me-2" name="source_priority_level">
                                <option disabled {{ !request('source_priority_level') ? 'selected' : '' }}>SOURCE</option>
                                @foreach ($legislative_priorities->pluck('source_priority_level')->unique()->filter()->sort() as $level)
                                    <option value="{{ $level }}" {{ request('source_priority_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success me-2"><i class="uil-search"></i></button>
                            <a href="{{ route('downloads.legislative-priorities') }}" type="button" class="btn btn-light btn-outline-success me-1">Clear</a>

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

            <form method="get" action="{{ route('downloads.legislative-priorities') }}">
                <div class="d-flex align-items-center">

                    <input class="form-control me-2" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>

                    <select class="form-control me-2" name="status">
                        <option disabled {{ !request('status') ? 'selected' : '' }}>STATUS</option>
                        @foreach ($legislative_priorities->pluck('status')->unique()->filter()->sort() as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <select class="form-control me-2" name="source_priority_level">
                        <option disabled {{ !request('source_priority_level') ? 'selected' : '' }}>SOURCE</option>
                        @foreach ($legislative_priorities->pluck('source_priority_level')->unique()->filter()->sort() as $level)
                            <option value="{{ $level }}" {{ request('source_priority_level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-success me-2"><i class="uil-search"></i></button>
                    <a href="{{ route('downloads.legislative-priorities') }}" type="button" class="btn btn-light btn-outline-success me-1">Clear</a>
                    <button type="button" class="form-control btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')"><i class="uil-upload"></i> UPLOAD</button>

                </div>
            </form>
        </div> --}}

        <div class="col-12 mb-5">
            <table id="datatable" class="table table-hover text-start" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>PROPOSED MEASURE</th>
                        <th>SOURCE / PRIORITY LEVEL</th>
                        <th>STATUS</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($legislative_priorities as $priority)
                        @if($priority->status == 'APPROVED' || \App\Models\Custom\Downloadable::userIsApprover($priority->agency, $priority->cluster))

                            <tr>
                                <td><a href="javascript:void(0);" onclick="$('#attachmentsModal{{ $priority->id }}').modal('show')"><strong class="text-primary">{{ $priority->proposed_measure }}</strong></a></td>
                                <td>{{ $priority->source_priority_level }}</td>
                                <td>{{ $priority->hor_status }} <br> {{ $priority->sen_status }}</td>
                                {{-- <td>
                                    @if($bill->status == 'FOR APPROVAL' && \App\Models\Custom\Downloadable::userIsApprover($bill->agency, $bill->cluster))
                                        <button class="btn btn-success btn-sm" onclick="$('#approveModal{{ $bill->id }}').modal('show')"><i class="uil-check"></i></button>
                                    @endif
                                </td> --}}
                            </tr>

                            {{-- ATTACHMENTS --}}
                            <div class="modal fade" id="attachmentsModal{{ $priority->id }}" tabindex="-1" aria-labelledby="attachmentsModalLabel{{ $priority->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="attachmentsModalLabel{{ $priority->id }}"><i class="uil-paperclip"></i> View Attachments</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <strong><small>Title:</small></strong>
                                            <p class="mb-3">{{ $priority->proposed_measure }}</p>

                                            <strong><small>Attachments:</small></strong>

                                            @php
                                                $attachments = json_decode($priority->attachments, true);
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

                        @endif
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- <div class="d-flex justify-content-center">
                {{ $legislative_priorities->links() }}
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
                                <label class="d-block">Proposed Measure *</label>
                                <input type="text" name="proposed_measure" id="proposed_measure" value="{{ old('proposed_measure')}}" class="form-control @error('proposed_measure') is-invalid @enderror" maxlength="150" required>
                                @error('proposed_measure')
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
                                <label class="d-block">Status from House of Representative *</label>
                                <input type="text" name="hor_status" id="hor_status" value="{{ old('hor_status')}}" class="form-control @error('hor_status') is-invalid @enderror" maxlength="150" required>
                                @error('hor_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="d-block">Status from Senate *</label>
                                <input type="text" name="sen_status" id="sen_status" value="{{ old('sen_status')}}" class="form-control @error('sen_status') is-invalid @enderror" maxlength="150" required>
                                @error('sen_status')
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
                            <input type="hidden" name="type" value="PLP" class="form-control" required>
                            {{-- <input type="hidden" name="agency" value="{{ \App\Models\Member::getMemberInfo(Auth::user()->id)->agency ?? null }}" class="form-control" required>
                            <input type="hidden" name="cluster" value="{{ \App\Models\Member::getMemberInfo(Auth::user()->id)->cluster ?? null }}" class="form-control" required> --}}
                            
                            <button type="submit" class="btn bg-custom-primary text-white mt-3"><small>SUBMIT</small></button>
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

