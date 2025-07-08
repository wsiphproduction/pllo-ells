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
                
        <div class="col-12 mb-0 d-flex justify-content-between align-items-center">
            <div class="">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
            </div>

            

            <form method="get" action="{{ route('reference-materials.index') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('reference-materials.index') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                    {{-- <button type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-filter fa-1x custom-text-primary"></i></button> --}}
                    
                    <input class="form-control" placeholder="Search" name="search" value="{{ request('search') }}"/>&nbsp;&nbsp;
                    <button type="button" class="form-control btn text-white bg-custom-primary" onclick="$('#creationModal').modal('show')">SUBMIT REPORT</button>
                </div>
            </form>

        </div>


        <div class="col-12 mb-3">
            <table class="table table-hover ">
                <thead class="table-primary">
                    <tr>
                        <th width="30%">SUBJECT</th>
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
                            <td><a href="{{-- env('APP_URL').'/storage/reference_materialables/'.$reference_material->file_url --}}" target="_blank"><strong class="custom-text-primary">{{ $reference_material->subject }}</strong></a></td>
                            <td>{{ $reference_material->significance_level }}</td>
                            <td>{{ $reference_material->cluster->name }}</td>
                            <td>SJPC</td>
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
                                                    <select class="form-control" name="significance_level">
                                                        <option disabled selected>SIGNIFICANCE LEVEL</option>
                                                        <option value="President Legislative Priorities" {{ old('significance_level', $reference_material->significance_level ?? '') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities </option>
                                                        <option value="Agency Priority" {{ old('significance_level', $reference_material->significance_level ?? '') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority </option>
                                                    </select>
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
                                                    <input type="text" name="remarks" id="remarks" value="{{ old('remarks', $reference_material->remarks ?? '')}}" class="form-control @error('remarks') is-invalid @enderror" placeholder="REMARKS">
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

            <div class="d-flex justify-content-center">
                {{ $reference_materials->links() }}
            </div>
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
                                    <select class="form-control" name="significance_level">
                                        <option disabled selected>SIGNIFICANCE LEVEL</option>
                                        <option value="President Legislative Priorities" {{ old('significance_level') == 'President Legislative Priorities' ? 'selected' : '' }}>President Legislative Priorities </option>
                                        <option value="Agency Priority" {{ old('significance_level') == 'Agency Priority' ? 'selected' : '' }}>Agency Priority </option>
                                    </select>
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
                                    <input type="text" name="remarks" id="remarks" value="{{ old('remarks')}}" class="form-control @error('remarks') is-invalid @enderror" placeholder="REMARKS">
                                    {{-- <textarea name="remarks" class="form-control" placeholder="REMARKS"></textarea> --}}
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

