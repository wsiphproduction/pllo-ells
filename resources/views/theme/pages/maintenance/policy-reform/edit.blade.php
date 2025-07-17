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
                    </div>

                    <div class="policy-reform-category-maintenance-add border-top">
                        <h5 class="mt-3 mb-0" style="opacity: .8;">Edit Category</h5>
                        <small style="opacity: .8;">Edit details on coresponding field below.</small>

                        <div class="create-policy-reform-category-container mt-3">
                            <form class="m-0" method="post" action="{{ route('maintenance.policy.reform.update', $category->id) }}" enctype="multipart/form-date">
                                @csrf
                                <div class="d-flex flex-column flex-md-row">

                                    <div class="col-12 col-md-6 px-4">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input class="form-control" type="text" name="name" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-start gap-3 py-4">
                                            <button type="submit" class="btn btn-success">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                </svg>
                                                Submit
                                            </button>
                                            <a href="{{ route('maintenance.policy.reform') }}" id="btn-cancel-policy-reform-category-edit" class="btn btn-secondary">
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                                </svg>
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
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

	</script>
@endsection