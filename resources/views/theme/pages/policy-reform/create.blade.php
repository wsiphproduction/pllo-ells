@extends('theme.main')

@section('pagecss')
<style>
    
</style>
@endsection

@section('content')

@php

@endphp

<div class="container bottommargin-2xl">
    <div class="row">
        <div class="d-flex">

            <div class="heading-block border-0 mb-4 form-title">
                <b>PROPOSE POLICY REFORM</b>
                <br />
                <small class="text-dark">
                    A proposed policy reform is a structured recommendation to amend, replace, or introduce policies aimed at improving efficiency, fairness, or effectiveness in addressing societal issues; please input clearly states its purpose and the specific improvement or change it seeks to achieve.
                </small>
            </div>

        </div>


    </div>
    <div class="row">
        
       <div class="bill-input-container">
            <form action="{{ route('policyreform.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" type="text" name="title" id="title" placeholder="TITLE" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-select" name="category" id="category">
                                    <option value="0" selected disabled>SELECT CATEGORY</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-12 col-md-6 pe-3">
                                <label for="until">Until</label>
                                <input class="form-control" type="date" name="until" id="until" required>
                            </div>
                            <div class="form-group col-12 col-md-6 ps-3">
                                <label for="target_votes">Goal Quantity</label>
                                <input class="form-control" type="number" name="target_votes" id="target_votes" placeholder="QUANTITY" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Uplaod Documents</label>
                            <br />
                            <input type="file" name="document" id="document" required>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="photo">Upload Photo</label>
                            <br />
                            <input type="file" name="photo" id="photo" accept=".jpg,.png,.gif,.jiff" required>
                        </div>
                        <div class="form-group">
                            <label for="team">Team Members</label>
                            <div id="team_container">
                                <input class="form-control" type="email" name="team[]" id="team[]" placeholder="EMAIL ADDRESS">
                            </div>
                            <button type="button" id="add_team" class="border-0 bg-white primary-text-color mt-2"><small><b>Click here to add Team Members</b></small></button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Type description here" rows="5" required></textarea>
                    </div>
                </div>

                <!-- Hidden values -->
                <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">

                <div class="bill-actions">
                    <button class="btn btn-success mt-4 mx-2"><small><i class="icon-news"></i>&nbsp;&nbsp;Save</small></button>
                    <a href="{{ route('policyreform.index') }}" class="btn btn-secondary mt-4 mx-2"><small><i class="icon-times"></i>&nbsp;&nbsp;Cancel</small></a>
                </div>

            </form>
       </div>
        
    </div>

</div>

@endsection

@section('pagejs')
<script>
    $(document).ready( function() {
        $("#add_team").click(function() {
            var newFieldHtml = `<div class="position-relative">
                                <input class="form-control mt-2" type="text" name="team[]" id="team[]" placeholder="EMAIL ADDRESS" style="padding-right: 140px;">
                                <svg id="remove_new_field" style="position: absolute;right: 12px; top: 12px; cursor: pointer;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                                  <path stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                </div>`;
            $("#team_container").append(newFieldHtml);
            });

        $('body').on('click', '#remove_new_field', function(e){
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
</script>
@endsection

