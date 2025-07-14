@extends('theme.main')

@section('pagecss')
<style>
    .portfolio-item:hover .contact-btn-style {
        display: flex !important;
    }
    .contact-btn-style {
        display: none;
        position: absolute;
        width: fit-content;
        top: 30px;
        left: 32px;
    }
</style>
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
            <form method="get" action="{{ route('directory') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <input class="form-control" placeholder="Search Member Name" name="member_name" value="{{ request('member_name') }}"/>
                    <button type="button" class="btn btn-transparent p-1"><i class="bi-grid-fill fa-1x custom-text-primary"></i></button>
                    <a href="{{ route('directory') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                </div>
            </form>
        </div>

    </div>

   

@endsection

@section('pagejs')
<script>

  

</script>
@endsection