@extends('admin.layouts.app')

@section('pagetitle')
Manage Customer
@endsection

@section('pagecss')
<link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
<style>
    .row-selected {
        background-color: #92b7da !important;
    }
</style>
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cases</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Cases</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            <div class="col-md-12">
                <div class="filter-buttons">
                    <div class="d-md-flex bd-highlight">
                        <div class="bd-highlight mg-r-10 mg-t-10">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('common.filters')}}
                                </button>
                                <div class="dropdown-menu">
                                    <form id="filterForm" class="pd-20">
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_by')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy1" name="orderBy" class="custom-control-input" value="updated_at" @if ($filter->orderBy == 'updated_at') checked @endif>
                                                <label class="custom-control-label" for="orderBy1">{{__('common.date_modified')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="name" @if ($filter->orderBy == 'name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">{{__('common.name')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_order')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByAsc" name="sortBy" class="custom-control-input" value="asc" @if ($filter->sortBy == 'asc') checked @endif>
                                                <label class="custom-control-label" for="sortByAsc">{{__('common.ascending')}}</label>
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByDesc" name="sortBy" class="custom-control-input" value="desc"  @if ($filter->sortBy == 'desc') checked @endif>
                                                <label class="custom-control-label" for="sortByDesc">{{__('common.descending')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                            @if (auth()->user()->has_access_to_route('product.category.multiple.change.status') || auth()->user()->has_access_to_route('product.category.multiple.delete'))
                                <div class="list-search d-inline">
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if (auth()->user()->has_access_to_route('file.category.multiple.change.status'))
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('Active')">Active</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('Inactive')">Inactive</a>
                                            @endif

                                                @if (auth()->user()->has_access_to_route('file.category.multiple.delete'))
                                                <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_category()">{{__('common.delete')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form">
                                    <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Name" value="{{ $filter->search }}">
                                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="mg-t-10">
                            @if (auth()->user()->has_access_to_route('resource-categories.create'))
                                <a class="btn btn-primary btn-sm mg-b-10" href="{{ route('resources.create') }}">Create a Cases</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="table-layout: fixed;word-wrap: break-word;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                            <label class="custom-control-label" for="checkbox_all"></label>
                                        </div>
                                    </th>
                                    <th style="width: 15%;overflow: hidden;">Case No.</th>
                                    <th style="width: 45%">Description</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 15%;">Last Date Modified</th>
                                    <th style="width: 10%;">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($resources as $resource)
                                <tr id="row{{$resource->id}}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $resource->id }}">
                                            <label class="custom-control-label" for="cb{{ $resource->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <strong @if($resource->trashed()) style="text-decoration:line-through;" @endif> {{ $resource->name }}</strong>
                                    </td>
                                    <td>{{ $resource->description }}</td>
                                    <td>{{ $resource->status }}</td>
                                    <td>{{ Setting::date_for_listing($resource->updated_at) }}</td>
                                    <td>
                                        @if($resource->trashed())
                                            @if (auth()->user()->has_access_to_route('resources.restore'))
                                                <nav class="nav table-options">
                                                    <a class="nav-link" href="{{route('resources.restore', $resource->id)}}" title="Restore this category"><i data-feather="rotate-ccw"></i></a>
                                                </nav>
                                            @endif
                                        @else
                                            <nav class="nav table-options">

                                                {{-- @if(isset($resource->contents))
                                                    <a class="nav-link" target="_blank" href="{{ route('resource-details.front.show',[$resource->slug]) }}" title="View Page"><i data-feather="eye"></i></a>
                                                @else
                                                    <a class="nav-link" target="_blank" href="{{ asset('storage/'.$resource->pdf_path) }}"><i data-feather="eye"></i></a>
                                                @endif --}}

                                                    <a class="nav-link" target="_blank" href="{{ asset('storage/'.$resource->pdf_path) }}"><i data-feather="eye"></i></a>

                                                @if (auth()->user()->has_access_to_route('resources.edit'))
                                                    <a class="nav-link" href="{{ route('resources.edit',$resource->id) }}" title="Edit Cases"><i data-feather="edit"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('resources.single.delete'))
                                                    <a class="nav-link" href="javascript:void(0)" onclick="delete_one_category({{$resource->id}},'{{$resource->name}}')" title="Delete Case"><i data-feather="trash"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('resources.change-status'))
                                                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($resource->status == 'Active')
                                                            <a class="dropdown-item" href="{{route('resources.change-status',[$resource->id,'Inactive'])}}" > Inactive</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('resources.change-status',[$resource->id,'Active'])}}"> Active</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="6" style="text-align: center;"> <p class="text-danger">No Categories found.</p></th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($resources->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $resources->firstItem() }} to {{ $resources->lastItem() }} of {{ $resources->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $resources->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="categories" name="categories">
        <input type="text" id="status" name="status">
    </form>

    <div class="modal effect-scale" id="prompt-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDelete">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-multiple-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('common.delete_mutiple_confirmation')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMultiple">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-update-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="categoryStatus"></span> this item. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatus">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-no-selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.no_selected_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please select at least one (1) entry.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('resources.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>

        $(".js-range-slider").ionRangeSlider({
            grid: true,
            from: selected,
            values: perPage
        });

        /*** Handles the Select All Checkbox ***/
        $("#checkbox_all").click(function(){
            $('.cb').not(this).prop('checked', this.checked);
        });

        /*** handles the changing of status of multiple pages ***/
        function change_status(status){
            var counter = 0;
            var selected_videos = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_videos += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                if(parseInt(counter)>1){ // ask for confirmation when multiple pages was selected
                    $('#categoryStatus').html(status)
                    $('#prompt-update-status').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form("{{route('resources.multiple.change.status')}}",status,selected_videos);
                    });
                }
                else{
                    post_form("{{route('resources.multiple.change.status')}}",status,selected_videos);
                }
            }
        }

        function post_form(url,status,category){
            $('#posting_form').attr('action',url);
            $('#categories').val(category);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        function delete_category(){
            var counter = 0;
            var selected_entries = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_entries += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
                $('#btnDeleteMultiple').on('click', function() {
                    post_form("{{route('resources.multiple.delete')}}",'',selected_entries);
                });
            }
        }

        function delete_one_category(id,page){
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form("{{route('resources.single.delete')}}",'',id);
            });
        }

        $('.cb').change(function() {
            var id = ($(this).attr('id')).replace("cb", "");
            if(this.checked) {
                $('#row'+id).addClass("table-warning");
            }
            else{
                $('#row'+id).removeClass("table-warning");
            }

        });
    </script>
@endsection