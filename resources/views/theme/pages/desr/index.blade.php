@extends('theme.main')

@section('pagecss')
<style>
    
</style>
@endsection

@section('content')
    <div class="container">
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h3 class="form-title text-uppercase">{{ $page->name }}</h3>

            <!-- filters here.. -->
            <div class="d-flex justify-content-end align-items-center">
                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-year" style="height: 38px;">
                        <option selected disabled>YEAR</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <div class="row mx-2">
                    <select class="form-select lh-1" id="filter-month" style="height: 38px;">
                        <option selected disabled>MONTH</option>
                        @foreach(config('months') as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                        <option value="0">ALL</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 mb-5">
            <table id="datatable" class="table-dotted table-striped table-hover" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr class="border-0">
                        <th class="py-3 px-2 custom-primary-bg rounded-start"><small class="text-white">SUBJECT</small></th>
                        <th class="py-3 custom-primary-bg"><small class="text-white">DATE</small></th>
                        <th class="py-3 custom-primary-bg rounded-end"><small class="text-white">REMARKS</small></th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2 py-3">
                                    <a href="{{ asset('storage/documents')}}/{{ $report->file_url  }}"  target="_blank" style="border-radius: 100px; padding: 3px 10px; border: 2px solid #ff6b6b;"><i class="fa-solid fa-file-pdf" style="font-size: 30px; color: #ff6b6b;"></i></a>
                                    <b><span class="custom-text-primary">{{ $report->subject }}</span></b>
                                </div>
                            </td>
                            <td>
                                <small>{{ date('l, F j, Y', strtotime($report->date)) }}</small>
                            </td>
                            <td>
                                <small>{{ $report->remarks }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">No data available</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>

    </div>

    <!-- form filter by year -->
    <form action="{{ route('desr.index') }}" method="get" id="filter-year-form">
        <input type="hidden" name="year" id="year-value-holder">
    </form>

    <!-- form filter by month -->
    <form action="{{ route('desr.index') }}" method="get" id="filter-month-form">
        <input type="hidden" name="month" id="month-value-holder">
    </form>

@endsection

@section('pagejs')
<script>
    // filter by month
    $('#filter-month').on('change', function() {
        let val = $(this).val();
        $('#month-value-holder').val(val);
        $('#filter-month-form').submit();
    });

    // filter by year
    $('#filter-year').on('change', function() {
        let val = $(this).val();
        $('#year-value-holder').val(val);
        $('#filter-year-form').submit();
    });
</script>
@endsection