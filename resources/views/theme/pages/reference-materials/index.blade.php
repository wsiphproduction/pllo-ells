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
                
        {{-- <div class="col-12 mb-0 d-flex justify-content-between align-items-center">
            <div class="">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
            </div>

            <form method="get" action="{{ route('reference-materials.index') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('reference-materials.index') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                    
                    
                    <input class="form-control" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>&nbsp;&nbsp;

                    <select class="form-control" name="significance_level">
                        <option disabled @if(!request('significance_level')) selected @endif>SIGNIFICANCE LEVEL</option>
                        <option value="President Legislative Priorities" {{ request('significance_level') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities </option>
                        <option value="Agency Priority" {{ request('significance_level') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority </option>
                    </select>&nbsp;&nbsp;

                    <button type="button" class="form-control btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')">SUBMIT REPORT</button>
                </div>
            </form>

        </div> --}}

        <div class="col-12 mb-0">
            <div>
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
            </div>

            <div class="row">
                <div class="col-8">
                    <form method="get" action="{{ route('reference-materials.index') }}">
                        <div class="d-flex align-items-center">

                            {{-- <button type="button" class="btn btn-transparent p-1 me-2"><i class="fa-solid fa-filter fa-1x custom-text-primary"></i></button> --}}

                            <input class="form-control me-2" placeholder="SEARCH" name="search" value="{{ request('search') }}"/>

                            <select class="form-control me-2" name="significance_level">
                                <option disabled {{ !request('significance_level') ? 'selected' : '' }}>SIGNIFICANCE LEVEL</option>
                                @foreach ($reference_materials->pluck('significance_level')->unique()->filter()->sort() as $level)
                                    <option value="{{ $level }}" {{ request('significance_level') == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>


                            {{-- <select class="form-control me-2" name="significance_level">
                                <option disabled @if(!request('significance_level')) selected @endif>SIGNIFICANCE LEVEL</option>
                                <option value="President Legislative Priorities" {{ request('significance_level') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities</option>
                                <option value="Agency Priority" {{ request('significance_level') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority</option>
                            </select> --}}

                            <select class="form-control me-2" name="agency_id">
                                <option disabled @if(!request('agency_id')) selected @endif>AGENCY</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>{{ $agency->agency_name }}</option>
                                @endforeach
                            </select>

                            <select class="form-control me-2" name="cluster_id">
                                <option disabled @if(!request('cluster_id')) selected @endif>CLUSTER</option>
                                @foreach($clusters as $cluster)
                                    <option value="{{ $cluster->id }}" {{ request('cluster_id') == $cluster->id ? 'selected' : '' }}>{{ $cluster->name }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success me-2"><i class="uil-search"></i></button>
                            <a href="{{ route('reference-materials.index') }}" type="button" class="btn btn-light btn-outline-success me-1">Clear</a>

                        </div>
                    </form>
                </div>

                <div class="col-4 text-end">
                    <button type="button" class="btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')">SUBMIT REPORT</button>
                </div>
            </div>
        </div>



        <div class="col-12 mb-3">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover text-start" cellspacing="0" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th hidden>CREATED</th>
                            <th>SUBJECT</th>
                            <th>SIGNIFICANCE LEVEL</th>
                            <th>CLUSTER</th>
                            <th>AGENCY</th>
                            <th>DATE</th>
                            <th>REMARKS</th>
                            <th class="text-center" width="5%">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reference_materials as $reference_material)
                            <tr>
                                <td hidden>{{ $reference_material->created_at }}</td>
                                <td><a href="{{-- env('APP_URL').'/storage/reference_materialables/'.$reference_material->file_url --}}" target="_blank"><strong class="custom-text-primary">{{ $reference_material->subject }}</strong></a></td>
                                <td>{{ $reference_material->significance_level }}</td>
                                <td>{{ $reference_material->cluster->name ?? 'None' }}</td>
                                <td>{{ $reference_material->agency->agency_name ?? 'None' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reference_material->created_at)->format('M d, Y') }}</td>
                                <td>{{ $reference_material->remarks }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="javascript:void(0);" class="btn btn-transparent" title="View Attachments" onclick="$('#attachmentsModal{{ $reference_material->id }}').modal('show')">
                                            <i class="uil-paperclip"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-transparent" title="Edit" onclick="$('#editModal{{ $reference_material->id }}').modal('show')">
                                            <i class="uil-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-transparent" title="Delete" onclick="$('#deleteModal').modal('show')">
                                            <i class="uil-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>



                            {{-- ATTACHMENTS --}}
                            <div class="modal fade" id="attachmentsModal{{ $reference_material->id }}" tabindex="-1" aria-labelledby="attachmentsModalLabel{{ $reference_material->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="attachmentsModalLabel{{ $reference_material->id }}"><i class="uil-paperclip"></i> View Attachments</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <strong><small>Subject:</small></strong>
                                            <p class="mb-3">{{ $reference_material->subject }}</p>

                                            <strong><small>Attachments:</small></strong>

                                            @php
                                                $attachments = json_decode($reference_material->attachments, true);
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

                            {{-- EDIT --}}
                            <div class="modal fade" id="editModal{{ $reference_material->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <strong class="custom-text-primary">EDIT REFERENCE MATERIALS</strong><br>

                                            <div class="row">
                                                <form id="edit_form" action="{{ route('reference-materials.update', $reference_material->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')

                                                    <div class="form-group">
                                                        <input type="text" name="subject" id="subject" value="{{ old('subject', $reference_material->subject ?? '') }}" class="form-control @error('subject') is-invalid @enderror" maxlength="150" placeholder="SUBJECT" required>
                                                        @error('subject')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" name="significance_level" id="significance_level" value="{{ old('significance_level', $reference_material->significance_level ?? '') }}" class="form-control @error('significance_level') is-invalid @enderror" maxlength="150" placeholder="SIGNIFICANCE LEVEL" required>
                                                        {{-- <select class="form-control" name="significance_level">
                                                            <option disabled selected>SIGNIFICANCE LEVEL</option>
                                                            <option value="President Legislative Priorities" {{ old('significance_level', $reference_material->significance_level ?? '') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities </option>
                                                            <option value="Agency Priority" {{ old('significance_level', $reference_material->significance_level ?? '') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority </option>
                                                        </select> --}}
                                                        @error('significance_level')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror             
                                                    </div>

                                                    <div class="form-group">
                                                        <select class="form-control" name="cluster_id">
                                                            <option disabled selected>CLUSTER</option>
                                                            @foreach($clusters as $cluster)
                                                                <option value="{{ $cluster->id }}" {{ old('cluster_id', $reference_material->cluster_id ?? '') == $cluster->id ? 'selected' : '' }}>{{ $cluster->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('cluster_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror             
                                                    </div>

                                                    <div class="form-group">
                                                        <select class="form-control" name="agency_id">
                                                            <option disabled {{ $reference_material->agency_id == null ? 'selected' : '' }}>AGENCY</option>
                                                            @foreach($agencies as $agency)
                                                                <option value="{{ $agency->id }}" {{ $reference_material->agency_id == $agency->id ? 'selected' : '' }}>{{ $agency->agency_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('agency_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror             
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        {{-- <input type="text" name="remarks" id="remarks" value="{{ old('remarks', $reference_material->remarks ?? '') }}" class="form-control @error('remarks') is-invalid @enderror" placeholder="REMARKS"> --}}
                                                        <textarea name="remarks" class="form-control" placeholder="REMARKS">{{ old('remarks', $reference_material->remarks ?? '') }}</textarea>
                                                        @error('remarks')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="file" name="attachments[]" class="form-control @error('attachments') is-invalid @enderror" accept=".pdf" multiple>
                                                        <small>UPLOAD PDF FILE (MULTIPLE SELECT)</small>
                                                        <br/>
                                                        @error('attachments')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit" class="btn bg-custom-primary text-white mt-3"><small>SUBMIT</small></button>
                                                        <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal"><small>CANCEL</small></button>
                                                    </div>

                                                </form>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- DELETE --}}
                            <div class="modal fade" id="deleteModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">Are you sure you want to delete this item?</div>
                                        <div class="modal-footer">
                                            <form method="POST" action="{{ route('reference-materials.single-delete', $reference_material->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger text-white"><small>Yes</small></button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><small>No</small></button>
                                            </form>
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
            </div>

            {{-- <div class="d-flex justify-content-center">
                {{ $reference_materials->links() }}
            </div> --}}
        </div>

    </div>


    {{-- MODALS --}}
        {{-- CREATE --}}
        <div class="modal fade" id="creationModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <strong class="custom-text-primary">SUBMIT REFERENCE MATERIALS</strong><br>

                        <div class="row mt-3">
                            <form id="creation_form" action="{{ route('reference-materials.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')

                                <div class="form-group">
                                    <input type="text" name="subject" id="subject" value="{{ old('subject')}}" class="form-control @error('subject') is-invalid @enderror" maxlength="150" placeholder="SUBJECT" required>
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" name="significance_level" id="significance_level" value="{{ old('significance_level')}}" class="form-control @error('significance_level') is-invalid @enderror" maxlength="150" placeholder="SIGNIFICANCE LEVEL" required>
                                    {{-- <select class="form-control" name="significance_level">
                                        <option disabled selected>SIGNIFICANCE LEVEL</option>
                                        <option value="President Legislative Priorities" {{ old('significance_level') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities </option>
                                        <option value="Agency Priority" {{ old('significance_level') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority </option>
                                    </select> --}}
                                    @error('significance_level')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror             
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="cluster_id">
                                        <option disabled selected>CLUSTER</option>
                                        @foreach($clusters as $cluster)
                                            <option value="{{ $cluster->id }}" {{ old('cluster_id') == $cluster->id ? 'selected' : '' }}>{{ $cluster->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cluster_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror             
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="agency_id">
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->id }}" @if(Auth::user()->role_id != 1){{ \App\Models\Member::getMemberInfo(Auth::user()->id)->agency == $agency->id ? 'selected' : '' }}@endif>{{ $agency->agency_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('agency_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror             
                                </div>
                                
                                <div class="form-group">
                                    {{-- <input type="text" name="remarks" id="remarks" value="{{ old('remarks')}}" class="form-control @error('remarks') is-invalid @enderror" placeholder="REMARKS"> --}}
                                    <textarea name="remarks" class="form-control" placeholder="REMARKS">{{ old('remarks')}}</textarea>
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    {{-- <label class="d-block">Attachments (MULTIPLE SELECT)</label> --}}
                                    <input type="file" name="attachments[]" class="form-control @error('attachments') is-invalid @enderror" accept=".pdf" required multiple>
                                    <small>UPLOAD PDF FILE (MULTIPLE SELECT)</small>
                                    {{-- <small>File type: PDF, CSV, XLSX, XLS<br/> Maximum file size: 2MB</small> --}}
                                    <br/>
                                    @error('attachments')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                
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

