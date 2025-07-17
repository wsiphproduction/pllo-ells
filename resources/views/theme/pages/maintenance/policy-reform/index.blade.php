@extends('theme.main')

@section('pagecss')
<style>
    .table.table-hover.table-striped.table-bordered thead tr th {
        background-color: #2b3649;
        color: white;
    }
</style>
@endsection

@section('content')

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="col-lg-12">

            <div class="heading-block border-0 mb-4">
                <h4>Maintenance Dashboard</h4>
            </div>

            <div class="row">

                <div class="col-12 col-md-2">
                    <x-maintenance-navs></x-maintenance-navs>
                </div>

                <div class="col-12 col-md-10 border rounded shadow" style="padding: 20px;">

                    <div class="d-flex align-items-center justify-content-between">
                        <h5>Manage Policy Reform Category</h5>
                        <button id="btn-add-category" class="btn btn-success">
                            <svg style="margin-right: 10px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                            </svg>
                            Create Category
                        </button>
                    </div>

                    <div class="category-maintenance-list mt-4">

                        <table id="policyReformsMaintenanceTable" class="table table-hover table-striped table-bordered">
                            <thead class="bg-dark text-white">
                              <tr>
                                <th width="55%"><b>Name</b></th>
                                <th width="25%"><b>Date/Time Added</b></th>
                                <th width="20%"><b>Action</b></th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="text-capitalize">{{ $category->name  }}</td>
                                        <td>{{ $category->created_at  }}</td>
                                        <td>
                                            <a href="{{ route('maintenance.policy.reform.edit', $category->id) }}" class="btn btn-secondary" title="Edit category details">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>
                                            </a>
                                            &nbsp;
                                            <button type="button" class="btn btn-danger delete-category" data-id="{{ $category->id }}" title="Delete category" data-bs-toggle="modal" data-bs-target="#deletePolicyReformCategoryModal">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No approved category found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="category-maintenance-add border-top" style="display: none;">
                        <h5 class="mt-3 mb-0" style="opacity: .8;">Create Category</h5>
                        <small style="opacity: .8;">Please provide details on coresponding fields below.</small>

                        <div class="create-category-container mt-3">
                            <form class="m-0" method="post" action="{{ route('maintenance.policy.reform.store') }}" enctype="multipart/form-date">
                                @csrf
                                <div class="d-flex flex-column flex-md-row">

                                    <div class="col-12 col-md-6 px-4">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-start gap-3 py-4">
                                            <button type="submit" class="btn btn-success">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                </svg>
                                                Submit
                                            </button>
                                            <button type="button" id="btn-cancel-category" class="btn btn-secondary">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                                </svg>
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete confirmation modal -->
                    <div class="modal fade" id="deletePolicyReformCategoryModal" tabindex="-1" aria-labelledby="deletePolicyReformCategoryModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deletePolicyReformCategoryModalLabel">Delete Category Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete this category?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="{{ route('maintenance.policy.reform.delete') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="bill_id" id="delete-category">
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('pagejs')
	<script>

        $(document).on('click','.delete-category',function(){
             let id = $(this).attr('data-id');
             $('#delete-category').val(id);
        });


        $('#btn-add-category').click(function() {
            $('.category-maintenance-add').show();
            $('.category-maintenance-list').hide();
            $('#btn-add-category').hide();
        });

        $('#btn-cancel-category').click(function() {
            $('.category-maintenance-add').hide();
            $('.category-maintenance-list').show();
            $('#btn-add-category').show();
        });
	</script>
@endsection