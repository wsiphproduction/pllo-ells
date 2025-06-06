@extends('theme.main')

@section('pagecss')
<link rel="stylesheet" href="/js/datatables/datatables.css" />
<link rel="stylesheet" href="/js/datatables/datatables.min.css" />

<style type="text/css">
	table.dataTable.no-footer#casesTable {
	    border-top: 1px solid #e7e7e7;
	}
	.table-responsive div#casesTable_wrapper div#casesTable_length {
		margin-bottom: 20px;
	}
	.table-responsive div#casesTable_wrapper div#casesTable_filter input[type="search"],
	.table-responsive div#casesTable_wrapper div#casesTable_length select {
		padding: 5px !important;
	    border-radius: 6px;
	    border-color: #c9c9c9 !important;
	}
</style>
@endsection

@section('content')
<div class="container mb-6">
	<div class="row">
		
		<div class="col-lg-12">
				
			<div class="filter-btn">
				<div class="d-md-flex">
					<div class="bd-highlight mg-r-10 mg-t-10 mt-3">
						{{--<select id="inputState" class="form-select mb-3">
							<option value="" selected disabled>- Select Year -</option>
							@foreach($years as $year)
							<option @if($filterYear == $year->yr) selected @endif value="{{$year->yr}}">{{$year->yr}}</option>
							@endforeach
						</select>--}}
					</div>
					<div class="d-md-flex m-auto"></div>
					
					{{-- <form method="" action="" id="filterForm">
						<div class="mg-t-10 mt-3 hsrch">
							<div class="input-group">
							  <select class="form-select" id="searchFormCategory" name="category" required style="display: none;">
								<option value="cases" selected>CASES</option>
								<option value="" selected disabled>- Select Category - </option>
								@foreach($searchCategories as $cat)
								<option @if($slug == $cat->slug) selected @endif value="{{$cat->slug}}">{{$cat->name}}</option>
								@endforeach
							  </select>

							  <input type="text" id="keyword" class="form-control" placeholder="Search" aria-label="Search" value="{{$keyword}}">
							  <button class="btn btn-outline-primary btn-primary" type="submit" id="button-addon2"><i class="icon-search text-white"></i></button>
							</div>
						</div>
					</form> --}}
				</div>
			</div>


			<form method="GET" action="" id="filterYear" style="display:none;">
				<input type="text" name="keyword" id="skeyword" value="{{$keyword}}">
				<input type="text" name="year" id="year">
			</form>
			
			
			<div class="table-responsive">
				<table id="casesTable" class="table table-hover table-striped table-bordered">
					<thead class="bg-dark text-white">
					  <tr>
						<th width="20%"><b>Case No</b></th>
						<th width="75%"><b>Description</b></th>
						<th width="5%"><b>Action</b></th>
					  </tr>
					</thead>
					<tbody>
						@forelse($resources as $res)
						  	<tr>
								<td>{{$res->name}}</td>
								<td><small style="opacity: .8;">{{$res->description}}</small></td>
								<td>
									<a href="{{ asset('storage/'.$res->pdf_path) }}" target="_blank"><img src="{{asset('theme/addons/images/pdf.png') }}" /></a>
									{{-- @if(isset($res->contents))
									<a href="{{ route('resource-details.front.show', $res->slug)}}" target="_blank"><img src="{{asset('theme/images/pdf.png') }}" /></a>
									@else
									<a href="{{ asset('storage/'.$res->pdf_path) }}" target="_blank"><img src="{{asset('theme/images/pdf.png') }}" /></a>
									@endif --}}
								</td>
						  	</tr>
						@empty
							<tr>
								<td colspan="4">No resources found.</td>
						  	</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			
			<br>
			{{-- {{ $resources->appends(request()->input())->links('theme.layouts.pagination') }} --}}
		</div>
	</div>
</div>
@endsection

@section('pagejs')
	<script src="/js/datatables/datatables.js"></script>
	<script src="/js/datatables/datatables.min.js"></script>
	<script>
		$('#filterForm').submit(function(e){
			e.preventDefault();

			$('#skeyword').val($('#keyword').val());
			var url = '{{ route("resource-category.list", ":slug") }}?keyword='+$('#keyword').val();
			// var url = '{{ route("resource-category.list", ":slug") }}';
			console.log(url);
			// alert();
			window.location.href = url.replace(':slug', $('#searchFormCategory').val());
		});

		// $('#button-addon2').click(function(){
		// 	var url = '{{ route("resource-category.list", ":slug") }}?keyword='+$('#');
		// 	window.location.href = url.replace(':slug', $('#searchFormCategory').val());
		// });

		$('#inputState').change(function(){
			$('#year').val($(this).val());

			$('#filterYear').submit();
		});

		// $('#inputState').change(function(){
		// 	if($('#keyword').val() == ""){
		// 		var newURLString = window.location.href +  "&year=" + $(this).val();
		// 	} else {
		// 		var newURLString = window.location.href +  "?year=" + $(this).val();
		// 	}

    	// 	window.location.href = newURLString; 
		// });

		// $('#searchFormCategory').change(function(){
		// 	var url = '{{ route("resource-category.list", ":slug") }}';
		// 	window.location.href = url.replace(':slug', $('#searchFormCategory').val());
		// });

		$(document).ready( function () {
		    $('#casesTable').DataTable({
				// addons here
		    });
		} );
	</script>
@endsection




