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
        <div class="d-flex justify-content-between align-items center">

            <div class="heading-block border-0 mb-4 form-title">
                <b>PROPOSE A BILL</b>
            </div>

        </div>


    </div>
    <div class="row">
        
       <div class="bill-input-container">
            <form action="{{ route('policyreform.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control w-50" type="text" name="title" id="title" placeholder="Type title here" required>
                </div>

                <div class="form-group">
                    <label for="description">Title</label>
                    <textarea class="form-control w-50" name="description" id="description" placeholder="Type description here" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-select w-25" name="category" id="category">
                            <option value="0" selected disabled>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="photo">Attach Image</label>
                    <br />
                    <input type="file" name="photo" id="photo" accept=".jpg,.png,.gif,.jiff" required>
                </div>

                <div class="form-group">
                    <label for="target_votes">Target Votes</label>
                    <input class="form-control w-25" type="number" name="target_votes" id="target_votes" placeholder="Type target votes here" required>
                </div>

                <div class="form-group">
                    <label for="until">Until</label>
                    <input class="form-control w-25" type="date" name="until" id="until" required>
                </div>

                <!-- Hidden values -->
                <input type="hidden" name="member_id" value="{{ auth()->user()->memberDetails->id }}">

                <div class="bill-actions">
                    <button class="btn btn-success mt-4 mx-2"><small><i class="icon-news"></i>&nbsp;&nbsp;Propose Bill</small></button>
                    <a href="{{ route('policyreform.index') }}" class="btn btn-secondary mt-4 mx-2"><small><i class="icon-times"></i>&nbsp;&nbsp;Cancel</small></a>
                </div>

            </form>
       </div>
        
    </div>

</div>

@endsection

@section('pagejs')

@endsection

