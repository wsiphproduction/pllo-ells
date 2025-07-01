@extends('theme.main')

@section('pagecss')
@endsection

@section('content')
    <div class="container">
                
        <div class="col-12 mb-5 d-flex justify-content-between align-items-center">
            <div class="">
                <h3 class="form-title text-uppercase">{{ $page->name }}</h3>
                <small>Summary status Update as of {{ \Carbon\Carbon::parse(now())->format('M d, Y') }}</small>
            </div>

            <form method="get" action="{{ route('downloads') }}">
                <div class="d-flex justify-content-between align-items-center">
                    <input class="form-control" placeholder="Search" name="search" value="{{ request('search') }}"/>

                    <a href="{{ route('downloads') }}" type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-refresh fa-1x custom-text-primary"></i></a>
                    {{-- <button type="button" class="btn btn-transparent p-1"><i class="fa-solid fa-filter fa-1x custom-text-primary"></i></button> --}}
                </div>
            </form>
        </div>

        <div class="col-12 mb-3">
            <table class="table table-hover ">
                <thead class="table-primary">
                    <tr>
                        <th>RA / JR NO.</th>
                        <th>SOURCE / PRIORITY LEVEL</th>
                        <th>APPROVED ON</th>
                        <th>CONGRESS</th>
                        <th width="50%">LONG TITLE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $download)
                        <tr>
                            <td><a href="{{ env('APP_URL').'/storage/downloadables/'.$download->file_url}}" target="_blank"><strong class="text-primary">{{ $download->ra_jr }}</strong></a></td>
                            <td>{{ $download->source_priority_level }}</td>
                            <td>{{ \Carbon\Carbon::parse($download->approved_on)->format('M d, Y') }}</td>
                            <td>{{ $download->congress }}</td>
                            <td>{{ $download->title }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $downloads->links() }}
            </div>
        </div>

    </div>

@endsection

