@extends('theme.main')

@section('pagecss')
<style type="text/css">
    /*.side-menu.horizontal-tab ul.mb-0.pb-0 {
        display: flex;
    }
    .side-menu.horizontal-tab {
        border-bottom: 1px solid #d5d5d5;
    }
    .side-menu.horizontal-tab ul.mb-0.pb-0 li.current {
        border-color: #1abc9c !important;
        border-bottom: 1px solid;
    }
    .side-menu.horizontal-tab ul.mb-0.pb-0 li > a {
        border: none;
    }
    .side-menu.horizontal-tab ul.mb-0.pb-0 li > a div {
        padding: 15px 35px 15px 35px;
    }*/
    div#portfolio .entry.event .grid-inner.border .p-4 .entry-title.title-sm h3 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .policy-reforms-category-dropdown ul li a {
        padding-left: 10px;
    }
    #portfolio .entry-meta ul.small > li + li:last-child:before,
    #portfolio .entry-meta ul.small > li:before:not(i) {
        display: none;
    }
    #portfolio .entry-meta ul.small {
        display: flex;
        flex-direction: column-reverse;
        align-content: flex-start;
    }

</style>
@endsection

@section('content')
<div class="container bottommargin-lg">
    <div class="row">
        <div class="col-lg-12">
            <div class="tablet-view">
                <a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>

                <div class="card border-0">

                    {{-- <div class="border-0 mb-5">
                        <h3 class="mb-3">News</h3>
                        <div class="side-menu">
                            {!! $dates !!}
                        </div>
                    </div> --}}

                    <div class="border-0 mb-5">
                        <!-- <h3 class="mb-3">Categories</h3> -->
                        <div class="side-menu horizontal-tab">
                            <div class="policy-reforms-category-dropdown d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="primary-text-color mb-0">POLICY REFORMS</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="search">
                                        <form class="mb-0" id="frm_search">
                                            <div class="searchbar">
                                                <input type="hidden" name="type" value="searchbox">
                                                <input type="text" name="criteria" id="searchtxt" class="form-control form-input form-search" placeholder="SEARCH" aria-label="Search news" aria-describedby="button-addon1" style="height: 38px;" />
                                                <button class="form-submit-search" type="submit" id="button-addon2">
                                                    <i class="icon-line-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <button class="btn btn-light dropdown-toggle border mx-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    SELECT CATEGORY
                                    </button>
                                    {!! $categories !!}

                                    @if(auth()->user()->is_an_admin())
                                        <button class="btn btn-main-primary">
                                            PROPOSE A BILL
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <span onclick="closeNav()" class="dark-curtain"></span>
        <div class="col-lg-12 col-md-5 col-sm-12">
            <span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Filter</span>
        </div>
        <div class="col-lg-12">
            @if(isset($_GET['type']))
                @if($_GET['type'] == 'searchbox')
                    <div class="col-12">
                        @if($totalSearchedArticle > 0)
                            <div class="style-msg successmsg">
                                <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Woo hoo!</strong> We found <strong>(<span>{{ $totalSearchedArticle }}</span>)</strong> matching results.</div>
                            </div>
                        @else
                            <div class="style-msg2 errormsg">
                                <div class="msgtitle p-0 border-0">
                                    <div class="sb-msg">
                                        <i class="icon-thumbs-up"></i><strong>Uh oh</strong>! <span><strong>{{ app('request')->input('criteria') }}</strong></span> you say? Sorry, no results!
                                    </div>
                                </div>
                                <div class="sb-msg">
                                    <ul>
                                        <li>Check the spelling of your keywords.</li>
                                        <li>Try using fewer, different or more general keywords.</li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
            <div class="portfolio-container">

                <!-- Portfolio Items
                ============================================= -->
                <div id="portfolio" class="portfolio row gutter-20">

                    @forelse($articles as $article)
                        <div class="entry event col-md-6">

                            <div class="col-12 d-flex flex-wrap">
                                <div class="col-6">
                                    <a href="{{ route('news.front.show',$article->slug) }}">
                                        @if($article->thumbnail_url)
                                            <img class="w-100 rounded" src="{{ $article->thumbnail_url }}" alt="{{ $article->name }}">
                                        @else
                                            <img class="w-100 rounded" src="{{ asset('storage/news_image/news_thumbnail/No_Image_Available.jpg')}}" alt="{{ $article->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="col-6 p-4">
                                    <div class="entry-title title-sm">
                                        <h3><a href="{{ route('news.front.show',$article->slug) }}" class="custom-text-primary">{{ $article->name }}</a>
                                        </h3>
                                    </div>
                                    <div style="font-size: 12px; opacity: .75; padding-top: 10px;">
                                        <ul class="d-flex flex-column justify-content-start list-unstyled gap-2">
                                            <li>
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                                  <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                                                </svg>
                                                Medical
                                            </li>
                                            <li>
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                                </svg>
                                                Until {{ Setting::news_date_format($article->date) }}
                                            </li>
                                            <li>
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                256 out of 2,500 votes
                                            </li>


                                            {{-- <li><i class="icon-calendar3"></i> {{ Setting::news_date_format($article->date) }}</li>
                                            <li><i class="icon-user"></i> Admin</li>
                                            <li><i class="icon-folder-open"></i> <a href="#">{{$article->category->name}}</a></li> --}}
                                        </ul>
                                    </div>
                                    <div class="entry-content mt-3" style="font-size: 16px;">
                                        <p>{{ $article->teaser }}</p>
                                        
                                    </div>
                                </div>
                                <a href="{{ route('news.front.show',$article->slug) }}"
                                            class="btn custom-text-primary"
                                            style="font-size: 16px; position: absolute; bottom: 0; right: 25px; font-weight: 700;">
                                    Read More
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                                    </svg>
                                </a>
                            </div>


                        </div>

                    {{-- <article class="portfolio-item">
                        <div class="grid-inner row g-0">
                            <div class="col-md-5">
                                <div class="news-imag">
                                    @if($article->thumbnail_url)
                                        <img class="w-100 h-100 position-relative position-lg-absolute inset-0 object-position-center object-fit-cover" src="{{ $article->thumbnail_url }}" alt="{{ $article->name }}">
                                    @else
                                        <img class="w-100 h-100 position-relative position-lg-absolute inset-0 object-position-center object-fit-cover" src="{{ asset('storage/news_image/news_thumbnail/No_Image_Available.jpg')}}" alt="{{ $article->name }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7 ps-md-4">
                                <div class="entry-title title-sm">
                                    <h2><a href="{{ route('news.front.show',$article->slug) }}">{{ $article->name }}</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul class="small">
                                        <li><i class="icon-calendar3"></i> {{ Setting::news_date_format($article->date) }}</li>
                                        <li><i class="icon-user"></i> Admin</li>
                                        <li><i class="icon-folder-open"></i> <a href="#">{{$article->category->name}}</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <p>{{ $article->teaser }}</p>
                                    <a href="{{ route('news.front.show',$article->slug) }}" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal">Read More <i class="icon-line-arrow-right color-2 ms-2 me-0"></i></a>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4">
                    </article> --}}
                @empty

                @endforelse
                </div>

                {{ $articles->links('theme.layouts.pagination') }}

            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script>
        $('#frm_search').on('submit', function(e) {
            e.preventDefault();
            window.location.href = "{{route('news.front.index')}}?type=searchbox&criteria="+$('#searchtxt').val();
        });

        $('.policy-reforms-category-dropdown ul').addClass('dropdown-menu');
        $('.policy-reforms-category-dropdown ul li a').addClass('dropdown-item');

    </script>
@endsection
