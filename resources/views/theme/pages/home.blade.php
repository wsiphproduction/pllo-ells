@extends('theme.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@php
    $contents = $page->contents;

// LATEST NEWS
    $featuredArticles = Article::where('is_featured', 1)->where('status', 'Published')->skip(0)->take(3)->get();
    if($featuredArticles->count()) {

        $featuredArticlesHTML = '';

        $prefooter = asset('theme/images/pre-footer.jpg');

        foreach ($featuredArticles as $index => $article) {
            $imageUrl = (empty($article->thumbnail_url)) ? asset('theme/images/misc/no-image.jpg') : $article->thumbnail_url;

            
            $featuredArticlesHTML .= '

                <div class="slide" data-thumb="'. $imageUrl .'">
                    <a href="'. $article->get_url() .'" class="d-block position-relative">
                        <div class="row">
                            <div class="col-md-6 half-one position-default">
                                <div class="floating-panel">
                                    <h2 class="h2 fw-semibold lh-base" style="margin-bottom: 0px;">'. $article->name .'</h2>
                                    <small style="color: #878787;">Date posted: '. $article->date_posted() .'</small>
                                    <p class="text-muted mt-4">'. $article->teaser .'</p>
                                    <a href="'. $article->get_url() .'" class="button button-3d button-mini button-rounded button-blue">Learn More &nbsp; ></a>
                                </div>
                            </div>
                            <div class="col-md-6 p-5">
                                <img class="rounded-corners" src="'. $imageUrl .'" alt="modair">
                            </div>
                        </div>
                    </a>
                </div>

                ';

            if (Article::has_featured_limit() && $index >= env('FEATURED_NEWS_LIMIT')) {
                break;
            }
        }

    } else {
        $featuredArticlesHTML = '';
    } 
    
    $keywords   = ['{Featured Articles}'];
    $variables  = [$featuredArticlesHTML];
    $contents = str_replace($keywords,$variables,$contents);

@endphp

@section('content')
    {!! $contents !!}

    <div class="container">
        
        <div class="row mt-5">
            <h4 class="custom-text-primary">PREVIOUS EVENTS</h4>

            <div id="oc-team" class="owl-carousel team-carousel carousel-widget" data-margin="30" data-nav="true" data-pagi="true" data-items-xs="1" data-items-sm="1" data-items-lg="2" data-items-xl="2">
                <div class="card mb-4 p-3 border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4" style="height: 200px;">
                            <img src="data:image/jpeg;base64,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"
                                onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                class="img-fluid rounded-start"
                                style="height: 100%; width: 100%; object-fit: contain;"
                                alt="Event Image">
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card-body">
                                <h6 class="card-title mb-2 text-primary fw-bold">Focus Group Discussion on the BI Modernization</h6>

                                <ul class="list-unstyled mb-2 small">
                                    <li><i class="bi-diagram-3 me-2"></i>Cluster: SJPC</li>
                                    <li><i class="bi-calendar-event me-2"></i>Date: March 12, 2023</li>
                                    <li><i class="bi-geo-alt me-2"></i>Luxent Hotel, Quezon City</li>
                                </ul>

                                <p class="card-text small text-muted mb-2">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.
                                </p>

                                <div class="text-end">
                                    <a href="#" class="fw-semibold small text-decoration-none text-primary">
                                        REGISTER <i class="bi-arrow-right-short align-middle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  --}}
                    <!-- Event 1 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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" 
                                onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                class="img-fluid rounded-start"
                                style="height: 100%; width: 100%; object-fit: contain;"
                                alt="Event Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">National ICT Summit 2025</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-diagram-3 me-2"></i>Cluster: NICTC</li>
                                        <li><i class="bi-calendar-event me-2"></i>Date: August 18, 2025</li>
                                        <li><i class="bi-geo-alt me-2"></i>SMX Convention Center, Manila</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Join stakeholders in discussing key ICT developments across the country.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">
                                            REGISTER <i class="bi-arrow-right-short align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event 2 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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" 
                                onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                class="img-fluid rounded-start"
                                style="height: 100%; width: 100%; object-fit: contain;"
                                alt="Event Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Cybersecurity Awareness Bootcamp</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-diagram-3 me-2"></i>Cluster: CSAC</li>
                                        <li><i class="bi-calendar-event me-2"></i>Date: September 10, 2025</li>
                                        <li><i class="bi-geo-alt me-2"></i>Hotel Centro, Palawan</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Hands-on workshop on cyber hygiene, data privacy, and incident response.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">
                                            REGISTER <i class="bi-arrow-right-short align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event 3 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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" 
                                onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                class="img-fluid rounded-start"
                                style="height: 100%; width: 100%; object-fit: contain;"
                                alt="Event Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">AI for Government Services Forum</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-diagram-3 me-2"></i>Cluster: DIGI-GOV</li>
                                        <li><i class="bi-calendar-event me-2"></i>Date: October 3, 2025</li>
                                        <li><i class="bi-geo-alt me-2"></i>Dusit Thani Hotel, Makati</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Explore how artificial intelligence is transforming public service delivery.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">
                                            REGISTER <i class="bi-arrow-right-short align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event 4 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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" 
                                onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                class="img-fluid rounded-start"
                                style="height: 100%; width: 100%; object-fit: contain;"
                                alt="Event Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Data Governance Roundtable</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-diagram-3 me-2"></i>Cluster: DATAMGT</li>
                                        <li><i class="bi-calendar-event me-2"></i>Date: November 22, 2025</li>
                                        <li><i class="bi-geo-alt me-2"></i>PICC, Pasay City</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        A discussion with data stewards and officers on managing information at scale.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">
                                            REGISTER <i class="bi-arrow-right-short align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                {{--  --}}
                
            </div>
            
        </div>
        
        <div class="row mb-5">
            <h4 class="custom-text-primary">LATEST PROPOSED BILL</h4>

            <div id="oc-team" class="owl-carousel team-carousel carousel-widget" data-margin="30" data-nav="true" data-pagi="true" data-items-xs="1" data-items-sm="1" data-items-lg="2" data-items-xl="2">

                {{--  --}}
                    <!-- Proposed Bill 1 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Anti-Agricultural Smuggling Act Amendment</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-file-earmark-text me-2"></i>Bill No. HB 4501</li>
                                        <li><i class="bi-calendar-event me-2"></i>Filed: January 18, 2025</li>
                                        <li><i class="bi-person me-2"></i>Author: Rep. Maria Santos</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Strengthens penalties for large-scale smuggling of agricultural products to protect local farmers.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">VIEW BILL <i class="bi-arrow-right-short align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposed Bill 2 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlag-JsSoV78MFO9fEIulh-u8ZMDLqL20MpQ&s"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Freedom of Information Act</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-file-earmark-text me-2"></i>Bill No. SB 1075</li>
                                        <li><i class="bi-calendar-event me-2"></i>Filed: February 2, 2025</li>
                                        <li><i class="bi-person me-2"></i>Author: Sen. Joel Fernandez</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Grants citizens access to public documents and records to promote government transparency.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">VIEW BILL <i class="bi-arrow-right-short align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposed Bill 3 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,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"
                                    onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">E-Governance Act of 2025</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-file-earmark-text me-2"></i>Bill No. HB 3010</li>
                                        <li><i class="bi-calendar-event me-2"></i>Filed: March 5, 2025</li>
                                        <li><i class="bi-person me-2"></i>Author: Rep. Alvin Reyes</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Advocates for the use of digital platforms in government to reduce red tape and improve efficiency.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">VIEW BILL <i class="bi-arrow-right-short align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposed Bill 4 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUTExQVFhUXFxcXGRgYGBoYFxoYGBoYGBgdGBgYHSggGBslGxcXITEiJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGxAQGi0lHyUtLS0tLS01LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIALcBEwMBIgACEQEDEQH/xAAbAAACAgMBAAAAAAAAAAAAAAAEBQMGAAECB//EAEMQAAIBAwIEAwYDBQYFAwUAAAECEQADIRIxBAVBURMiYQYycYGRoUKxwRRSctHwBxUjM2LhQ4KSsvEWosJTc4PS0//EABkBAAMBAQEAAAAAAAAAAAAAAAABAgMEBf/EACgRAAICAgIBAwQDAQEAAAAAAAABAhEDEiExQRMiUQQyYYGhsfDBcf/aAAwDAQACEQMRAD8ANstRSPS+2al1136nHYeLpFcniTQZv1H49GgbB54k1w3EUJ44rnxxU6FbBgu1Il2lp4kVtOIpaMe6GDEVsXKBPEiq7x/Prq3SqxAnoO59fShpoadlxDjrWhcUH41TeI57cA6bgT0z8DVg5dxodJnqR9DSi7CSobMFNSWoGaXi7UyXq01ZGwxtXe9SPcEYpcL4rDxXpRoLYmZa0Goc8Sa0Lxq6ZNoNBxXJNBm6e9caqaiJsNBrdxhQWutNcnrT1CyW5eHxqI3/AEqNnExNcMarVC2ZL4/eteNQ5NamjVBswrxhWC4KFmtE0tR7BniDuK5NwdxQk1qjUNg7xF710rjoaX1sGjUNhmG9aIt8SAIkUn8Q96wGlpfYbj0XaykmqspemG5Ar1o3KAPGen3qG5xbdMUWhjM3a0XpO3FN3rF4xu9FhQ0L1rVQI4wdZrY4pe9UiWG6qzXQgvL3FSBx3H1ooAkNVP5rm+TpYfE/HaTNWkOO4qsc6QeLOr+pNY5uI2a4eZUR8SPKYBG0CrdymNJgECetVlOGlAS7ZC4j0q1ctQi2uZwOkVGBWys3CDlNSaqhFbBrpaMLJjcrnXXEVkUUB3rrNdcRXVFBZms1mo1qspiNhqq97iG/aHEt72PNjofyqzxVOvKP2ggSM7QB9oz8axy9GuLsbctcm6Z3B6gHfVsflTs0j5Rai4SZOB+ECJ9aeUYr1DJ9xG1cTUpqJq05RmYTWTXM1omlsx0dTWTXE1k0vUHqdzWTXE1rVT3FqSTWwaiD10Gq1JMlok1VlRzWUxCQgVwfjUJu1rXUUjQlI9ayBUWqs1UuBkukVyUHeuNVbKHtVKiXZ0FHeu0A6mhdVdhqtJEWwwAd/t/vSbmCgXQZPw6fSmKtS3jFm57o+Mwdh/WayzxSgaYXcghFGJ1DAx06/anHAoAgGo7dfX50BxlkAjySdK/LepuFbyiBHw/2rH6ZK+TTP0MCB3rI9aF1GJ6Vmuu3WJy8hin/AFfnWy5/e/OgvEreulogthYMbN9JqVOJI/Fj1pd4lZ4tPRCsbftla/bKVeJWeJVaoLY2/bKqq3QL0gYnYz26jemni0hvXyLm+S/Q7etc31K9pvg7ZZuCbSxOMqvU/kaM/ahUfCWOGA8/EO7QBugGO0sT+VERwMf512fjbj86nFkhGNMMkW5WiL9qFabiBU9y1wf4bt35m3+lbXh+DI/zrk//AIyP+6a19bGZ6SA24gVz+0ip+MtcKB5Lrk/6tIH2JNJ7pg4IPqKcZwlwgcZIZftNa/aaWC5XQem4oSbCX41s4EZj5Cu7XFGMxv0oAsIP2rrUOlYQfuo3kvaF8RxRxEdelc8PxR6mcDpQs5E1pGwPhTv3hXsGP7VW6Xa63WxlQFNdAUdY5a4bOn4ag35TXdjlbtkAkZzBj8q5ZZ4fJ0LFL4AIrarOKNPLyDBdPqf5UTZ5NcYQFYgwQQDGJ6mKl54LyNYpPwL7fDdzp7T36fejLFnCg3F6j3gTBGI+dHHk962oJRt84kD1MUabJC6pEAE7HoPj6VhL6jbo1WGuypcZwN5TK6CPxEnpP4T8vy71EBTfmvCNdU21MAMrZJgqPNnvMitcy5Q1tfElSpIjuJ6H1rrwZbdM5csKXAtQetD3La68jf1jp8aJ+lKeYXHD+UgD1IH5kVr9R9hGD7h1zN1BncQo7963w97yjBj1Pp60AnHn3mAMBcadQPvDvBqQ+0F0nVbVlmV9yGAAXYeskfrXD9qv+Ds7dDBuKggQGLDoTifgMnG1dXLumAykHpIzG+Cc0tscQoZjdS45kx52EepAG2e/1rq/zNAUDWfKOzvAHb7dKlSG4jVL4MDfbMg7x1J9ay7xQBjzfQfLr2pHe40eIulY8yQDmBgRJyTEUFwfF3S5IUR7pGonMnImSK0x0+fgiSosbcQCevpOahZqGtcUQYuJgkElSSQCMwsZMkdenriXV/XWur6eSbdHLlvyau8UUKwBk/iEiACT+UfOtXeLRTDMAahw1w9lWPmxn8lH1oXm0eX5/pV5JuMXJBjipSUWFf3rb6GfpQHjklt4nv8AnQWhesVhUQf66964Z5pT4Z2LFGHKO7JIQggmZ2+OKhW283JXGoQfMYHnyBPw271Fb0wJHcbd5z96l4m2J3EmG2/ixse9Z2Pg6ucQ8DGJ6Bunf612l+5r2JAQ/vb+HPeN/ShGMDsZJJA327EdqlPvzJEyBjusd6VsdIJ4e+6bq5VsGTOfp+tWGcVX+A4cMQGkDXuOg+HXOaufC8rtNIHErI6aHMehgY2rr+nyqN7M582O6oUNW1emHMeUtbBIbWMbKZM+hzSx0IMdcY65x/Ouh5sb8nP6c14JnU6RnefzFZXRBIXGwn71mmMlD394dT8NprmjkindnS4SrowLvO8Vq3bnb9BtXVsDfSdwdx3+G38qsY9oB7v7Nwme9sfrvUepLa7RWq1rkQjhfX8v51lXGzz5dI1WuGB6gKIrVT68vkfpx+Drlr27I0hVECcbERMyRmZGfWgeX8xawigywJYBZwIaDt1k71Xn4/h2MniSCBtoYR2ENn7UNyhRckMzIQYHWTmcDb3T965I467OhzvouVu6vEOHNsRvMjBHQwJacb7YpovGqpgkVTbvC3ba+W4IHxAP3HQD6UC/HaZUsr+o1DPxOah4rd2UpnpV/myNnyqPTA/OlvH3La+dSPUCN+hArz53LkFW09CB17RIpjw3KeJf/wCp0ySq/CNqNObsNuBzxfFDSW6TpxPUYwB8vpUfDXQ66d1MkSIE9cH+VKrfs3cBKamBj3WaFYT0jB/r0pZzT2fvrvYZ++Vbbtg/0a6FKmYySaC+LRdbRtJ2iPliq/ztBrBmNqY8q4F8gp4azMYyfgo2xW+Z8nuu3ltMexVCZ+grryZdoU0c0IxU7TK1nzeYDIM+kmfzok2zvPUg5290fXBpgnshxpJixcj+BgPypxb9ieMIP+EfenOkdZ6sK5HR0bFXu6gSQcH/AFkdOkEVw5ueSHIwJ83qO5/qatHFewnGgCbJYdYKEjB7MaA5j7N3lENaZf4gQN16xG9Ibkl2Kne5qUgtEr17f+K74e7dmNTz5vxRAHXHyrfFcBcCDUnTfcfUYrAvnE4EH0z86Bpp9DG3eZyr3AJgAmcmOpUDG3SNvWm1qwhAEaT3LAA/JmFJ7tsafeEwT1O3wEfekfE3yYARyceZbk+mxUgbferhllDpkzxqaplw4PgLa6me7ZXU5Pvg4GFkKSdgPnW+L5fwpA18XbXc+VLjf/COneqbZIuXJe3ckzkkGIBMTGdq2jAkArcOIANvEmftBiOwFEs8pKmxRwRi9ki7cv5TyxjDca09vDK/cyIqw8H7JcqbAv656eKk/SJryy7aVfel8bhM5HWSNx+VZw7KSqaiOgAAA3JwJ+VZfs1PZLP9nfLt/CZvjduDv+6w70wtexvALtw1s9fNqb/uJrwrgOeNbkWrrCdjD6pnJ8vpPfpvVu5D7RcWbiL491lMTrDDqJ9+QZ+VJqQnKK7PR+I9i+AuDPC2x/DNv/sIpXx39nfLz1e11xc//cHtRaXHYZLt8yfttWxaYf8ADf5KajZjuIhb2I4e2P8AD4p56arYeD092AaDvG/wzAI2tWF4+W1pPlTUgJznVMT3irJduDbY+oik3M+IKsoViCQdiw7fumqjKQnXgCPMmCsWGsiIBgjJ7Ado6dYoZb/FO4ZbFrHiBWa2MQPJBG0tJ+FSjmDzIcyYA89zYT11T3ptbbA+FJScW7HJbdM48C7cMM1pAR3TcgdACRmaYLyS2VIZ7UE7BJJ7eY5J2oWajdRv2o35FrKqsa2+SWQvuyB1Koo+rCaAPAcKLhOpAQBgec9dwoAqnc5uu911Z2AkBQWxsNpOJJ6jvU/sxcRPEJIHTJiYkn44E4q07FqWC9yvhSxOlzP+kf8A9Kyt2uLVgGGQRIMHatU7YtI/BReH4W42yMf+Un9Km4ThLguFCCG94BvKYOJ80fumgEOrdp+JrSL5sADB6zsZ/nTuxj5+XMTm7aX+K8n5TXf902yBq4m0P4SW6Z2GaTFT3+m9SBST12pchRauUcNw6SBxQB6+XQfkXq28BwaNkXXf4Msf+0V5UVK4Mj+t678RkgzmBHr894pMaSPZLfLrR3QmO5J/X1o6zw1tYAVR8gK8dse0PEplbjx21Ex8jIim/A+3fEr/AJmk4PvJJxnPhxFSUkephRW4rz7hv7SR/wASz2Eq287QIPbvTG5/aBYCzouA9mC9yMEE4xUjLhFZXn17+0XUGFq1JA7yTJAwMZpZxPttxjGNAtg7+7MegbPWiwPUywqO7xSL7zAb7kAfevGeK5/xdxircUF32JOxjsVmor8xqZ2P73nIHTeATmgD1LmHN+Bz4hstjqA/fsDVU5vzblBybeo5grI27Z7+lVPwZVYCAxOQ7Rnox0iPjWuJViV0Mg94GHAk4j3VmfhVKyHFPwH8zv2XQ+DaZVn8TAzj0URVXucwtKJay2wyIA+GwzT3iLDFRpgNsZI7DYsZP0pZxljiEhhKgACQquJiMgtJwe1Vw+wS16BuG4+3cOm3acMZgxImCckE/lRvDez/ABTAf5azuzMqCPTXpxEmfSlPCcS4ujVdbcllKkZM9BtHb0pvzEuqo3iFFYDSZYeb91xoOkRnUc79sJwXwVsxtb9kjgvxPCpACn/E1xA0nCADcd+nSrNyf2M4SQx4oXD+6ukb9wxY9+1edlm8ZIMjWkgkHGoZgpMfOuLd+4GKhm94gAOu09oqdUFvo9u4P2X4O3taBI7yftt9qZ2rVq2PKiIP9Khf5V4jyznN9GAF5iSCfIVAEDVurAt+Wa7/AGy/f8RmvFlKHSJkq0bMUO4xmR8s0MSij1/jfaThrXvXU+s/lSTiPb+zq021dzttAztnPcV5UvLSTqJaBmWADRj8R1Ezn8Ypl4S+KG1KCdJK4LZAAYkkkYGAPXvQMut32jvFyiLbkCSx80EnrPoZ+nxpBx/EtebWx8SCQGQCNwMaMbTnNAcFetkEa1ULgG6WAmPRSQY1H3R1q7ezH7N4Q8dvNqPlAbQRO+UBIiMbU1YqS4RUOWrcUBriGACcjvO8jvFG8Q5cgrcdPQBSD8ZFek8NxPBr7nhr8F0/pU54vhm3No/EL+tDv4H+zzFDcCkeKxJiGKKYjfAiZqC1b4gOCeJ1JIlTZEkdRqBx9K9FucTYLsi8OjAR59K6TI76ehxFLtNprjDwrUA9LY+h6famoP4JbPLueWC91gOtxTLEAYiYkTtHX5U55JwQtAAlHYkkEZAB6SYhvgTTb2m4+1aZLbIAIkRgEmPeA3jH1pPb5ykyVMztJmB9apquBWOxdJ7bkfQx3rKT/wB+Whgq056x/wDGspUMqUMu6P8AJT/Ko1vksvlYeaMiN5H61Y7Q4Zba6RcD6QWi4BJAz5QpMb0n4+6SCq6jOr3pBjpvE/TpTQHNsu2rHYD5TNEcNwd1k1atIyRg5iYzsMgj5GouGuSJBgDbcb+nbNMOCs3SoXzRnYRvP72Opp2BAOD8w8S6w8pJznBgAbydqJucLFtn1ONtILdJA82d/gMUT/c1xmBPTu2ftTC3yNY8xj5Adup3pNoEKTaUaijs2G/SDO3f6UDbRyoaNwcwnw7TtVvTllrux75P5CKLs2ba+6oj5Cp4HZQka5BUFAsmRGOk9MbipuZWbgW1oQf5YEhFaI6DUDivQEudwAf670PxQY7XGX8pnrpipaRSkyhLZv8Ag3WueIMKBqUqB5sxAAoLlXBEXFfTgGSdPoeoq9W+X3Z1eKRk5QEyJwCZ33/3rq4bA0i8yOZ/GFLT6ED9anRFbsp3B8rttd/xrngoXYawJIz8RHxOKYXL1oXCUuuQ0aYgEiMEqcmQB0xRfNn4QCDbMsQAcgHf96QDvmarvKuIC29FxtOlipIcq0CPd0qSQY3npTWONCc3Y/uOp06euZIaDtsWOczjrioE4sD3iZJbCqbgxGMLg0Kz24QhWfGIiSJMAlwxn5fSiVUuV8pMYmNcd5JwD0zTSJJrTKBDNknrEzHbJ2rr/BxLbkkQg2zJ2jYn1+9Zw/CXGMzABjcbj0SRXV3h7aQbhkCZ0n96ffAyOuAPWaCtRXf5XquBwAAZJ1W1VoIMGV82fXepNCBQpJwIkCB9SRjFM7tm0QWDwREzKgH6R8oFCtw6na4mrYeZQc7RvT7JaaBeGtoQhLODqBUGVOD2kyDjrFRG3YQ4uEaidZ8zn4SB5R6YoleU5DC4hgg+9M5nec7etY/Krxgh2E4AGrP/AC6jj40CI+XJaDMVYXNoGx2MgyOoH2qa1xBNprioANDMukSogGCDABP1+9ScPyy7q1Et5d40hScjrORPQ1HxPDvouag8lHiesgiFDE7YwBQBWf7yZjNxnLdPNAHrpGD1q9cJyq2dF1y5JXCAgCMbgZPTc9arfB8uvm0LQVlLBmbUpWYaYfUJBIyPh2yHPsjeOk2mgNZJU+i9Plgj5CmxDrhrFu3PhKlsT5oWTOxz3z1mjG0yDM79fh/KhGvAAweu+I+U5qVb7tGnpMmIHwkUJ8g0RXea6GKmzdMHcBSD6jNMbF4MoaCsgGGwwnuOlL/GEkHYxO4BmJmDmAD9KmJgLJjzYjACgdvn9j879QWo/wCAuSjKpGrMdRMY+9Vezw73OLJZiVXBbAJOCSse7kHamHA8ZqaFPmhipMkAlX047bTBzVc5tzDwlaW1uzKCveGkwo2kgdaraxVRJ7W2wbieGRhm1kZ8/kMN8RNJ7XBvdOlFuFifwW9ZnvqAPxqx805Tc4hkdot2xnUSAWJgmE+XU96A4Dl92zqVLzBJ1QjFJ6ST2iJ+G9Q3bKRL/wCg+OaW02xJJ8xSYnE+XtWUDc5fxjEkcXej0Fxh6wVMHPatUUxWTryU7F4wMQAfXcz9q7XlFsTu0Z3JP0wKK4ZlYCGBGdyBPbTMQPjUt0YVjnGDs3rvgj4VBRBw1lFEKoUCeoUfP/zRNtRkyAR6GT1/4kD5/nQn7UATLAeo/UH+da4fi12C6iZ3GM5kDp9adgMrQY9T/D/KJFTAb4wN+4J+8UmvcyYYwCPWfpND3OaDcsdukn+t6AHxu/6gO0D887/KuLnFqNs/WPsRVftXWeCNvXA+dE8stvcVlZgGJiVI8ox12HWgBsnFn3VUgdWJhVAG5jMfPrUHG8xBhtcSQFYKGPx80xjscV3e4cKpRFJUGWZsM5GJMkYHQfqTXFgBgQSwiPcj6HTj70h0CWXLadRuNnBuECZjpA9dqHv2nN0hBqEqICgACBPmjzHPU0YbVq3lVBbuzaj/ANKiJ+NG/tLQPMR5R0CzgH0xk9aTBFXX2ebW5uyAxYAv0M6h8oG4bYj5RWOWWTxb23IYFA6kECTADDAaNjt2qwLwhdwdQYwcLlhI6id8d6r3GjwXtOmtBr8Ng2GIwc6em+OsU02DHJexbhQkkCASsnBGNVwlhlug71u/xbzpUdQCTLHSVkxMKCDAkA/y1w3ltHMENGnHuiDJnocfIGtrbLk4O4GxJkDf4ZIkTv60hoGa65BUE+4wA6YkD0+1QXAw1DwwcruDHutn/cd6cLaJMe9np5jncY8q9B5qMtclLgasAbBj9iiY+hFPUTZWLr6iYUMQVOQ2FJIJMRHxn41vh3UQxVWmDvkEdFYyCMenxq1N7NKTJuv8AFgfDEj6nes/9OQZF4/BwXH0LxNPUamyrueHY5t+76gwe+RIPr6V1dHDGZVve8xnczOPMOtOuY+z7QbmpHYZjRGoZkESZ3/L4V1w3I3uqrolhlYYJLjHrjcfXenTCSVWhQEtCPM4bSQPeCwZ3hp6n7UTbCRi60qDOWJgzkFiWxPeuue8rNnwx4IcEMWKSNJEQJ3bUSfvQQEExYZTpJAYkKTkaWxvPrSfBKCbVtvEa4t0qjBcElmkEnYjAMwc9KX8wY2OJS+GEXAEfERgQWBEdAf+U0TaxJC3NU5zA3g7pkfKPzqPmvDpcDINWspIUsoEhRGWIjpv/tSQPgf3WJBg22bMSQFHaQCMVly5czp8NjmJJ0x8AcfSq1yLmBKEM7jSCGOntABmaMu3lXym8oMx5lYbdiFNOqYDzhiwQM1sBusTEzGCRPzia3dvzgqwUxnGScHHpO/rS99RCNqt7d9OJMbj+orfD8W5YHyspAErcWMntqnE9qQw2zfVWA0uuPQ9CMkNMfTaurFxBkFoWYwPMepX670InF3PMPDY7DDavpE965fiL2AqXAMCdM9BiSIHShCYbxF0YIJY4nV9xv8AyoEX5bJB0qWgbDSCRIG8n86g4h7hALEqp042OwJ6fEYntil/HX/D90QTEz6wdvn1n5UwGy8UbYCCIAG3c5P3JrKr1lseY565rVADHhbWQwsHUJ07sZ3xqwOtdMrA+ZH1F1GntqBMsYOPWgjxYHlfUBgYOrf0NsZ6b9aacNaDEhmYwVwBuRIiFIEHPpUv8jBrtoE6YVWMRPmEnA8s6vtWcGGW4oZmODAQeQ9MnADfLvR7WV1hoOsHGt8jOIUH6SDQXE3IYhm94HyrKzO5JMf9pqbGY3L2L3GKgLJILsBPwHvR6gVuxwwA0s6zn/JUk/8AU2R9DQfHcXpLqgWViJJIBhf961w8ta1s0kCMYksd4HQBSPiwrVdEjRfDWNKDE5dtRyOwgbT0rXDcWILEAgAwEAURvtGTS7gmPhqT8/jDf71LydZtXAU1EyI1QDjbGfpRQg25xUxhdJHlY5Wezap0n5CpPDu6MggyI1GIidiT6DbuK5tpdUrpCoCBKqucThixDD71JxFnSp1iNiCx1GfNO47TuKBnHD2M5fUdyFBJ+pj8jR4U9LaxAIZmkYAHwHwiltp5UYJUnGohR9Jj6RXHHcWogYYDSIGoAYkTPTek0CGD8QZAZ105MAyAIJ/CAv0oDn3L/E4V7i7CGEhgfKSCYbK4J+n0j4XidROlGnPxJAJgAAT8Zp3y4a7Olo8wdcbZLDpRFcjfQZ7N8sS9ZS415F1qDkguDEMPNpAyPWp7Xs+2dIW4uoxqZOnlnSGC5iZjrSP2Ou/4LWzg22K/XP5zTxhVa/kVkHNeKbhfDF5CA76AVAIDRImGwI7Tsa6scZrUsuwbSSVIAbtO3UfWlXNGzkT8gY770fya4soqxGNpGQR3Az60nB+GXGcUqcf7v/foPtW7h2H22+9G2+BYEa2HwUfqT+lMUMxJyQM/18a4vtlY6z+Wa0UUZWD2rIBMDpHc0HZ/wboX/h3vMv8ApuxLD4Plh6hu4ou94q6nWzcdRuVA0gAZJJOflNUvjOalx4b8RbAJ8rPIFuDI8+gQ0bHMFpnFTKSiXBW6Of7QSqXbCwZbxTM5BJQmJnvtQHL+WO6mV8pEFSx64G6DfbfrTa5y1OIbAdTaMErcVyjscltSKSDAO3femLcqu2pP7U2kkQNC5I6khRtHT71nak+B048Mr1rlj5zcgGNK+YDAOykSTIzvvR9vgXJUagDAhXtyxOnrDSxnsMTnarBb45yoUKAojKQLjxvruMJBJ6j8sU25Zzy1ZHl4N1PVg9t2+ZZgx/rFDjJFJxa5/wCHnfEcsezx6JcB4ezxsCWQqguDby6v3mA3x4sxiKt/E/2c3SZFy0fm6faGBo/+0zh7XGcAdLKL1si7a8y6tSgllEHcrqGOsHpTf2I9ol4vg7N1j540XP8A7iYY+gOGHowp8+TN144Ko/sVxSgDw0cDqLxkZ/1Wx0JrniPZa9bWTbcwPwsjHfEkvMD+or0N+Mnb6/nvS3jeKC+8fl/t1qlFsTkkigcZwi2FTxD4esQqlWbK9ykjVJn5GqxdQi4HHFvOItAsZMzEah3O4q+e1NsEi4zBPCDYmX1NpiUXI2G8bik/C8ytBG022UqPfWM6gQIJEqZBMrG25FHp88Buq5EPOOBuoA7SGYj3mAbAz5d1yep6fOlnMrrG5MM0sW26koQBPQDH6CrVxCrswGqQzF/eLeUSRmNQ7GZzS3htNy7cttJVAjKDM6rmoHZp/COpGN809aEpCS5dWT5Tv6/pWVZRyM9A3/U36GKypr8FWvkGs3dKsWCyokgLPp1E7yNjXNvjAVZiG0mAYJBkk9CQDmBBoPguJZBDargJ3WJB775X0+w3oq1cuBWm7p2yiwYzgyfjWZRtLV3SCT4alZKnTbUn+HEiBJxPStHg7JveIGLkAABRsOwZs7k/hoJ76aswTBwWL4j0gfWa64fmAYKnnAuGPdVfdB97TGnboDNJ/IHPNeBU3WEkC4oYwQzKQAPTOJ+dGWOBRAtssuI3bVc3j3EGkgkkb0KzOb7eGoZ1EICQwY6QdiIGcQZ2pndvX1ueGltDaYqSwTVckOreZlPlGOo6fQ35orXiyW3wCgElZAIMtAXqMJbEj4Gt2uKS2rACPQL4a/T3m+Nau8HBL61XzAgQWyJwVxqntM04vN/pVcCckDb90ElT1hp+NWnwRQn/AGtyoZATvi2MmO7EEx6muLtxmRSAwLThQGMies/cGmq8xW1ADsD8SB8lH867t3XcvJ1YLAQJbIEDvvTsVCKzwZBlgFO83G1OR6KNumGFGPw9qCzQ2F976YRPN8j3NYt+W0CxmNRjWCRMSNO4kb0bw7KhJIRNgZOo9cCTB+ZosYNb4bV7qDPlkrpCgjqAJ+p61JoS2PC12xH4QYbvjUwAyTUzcUSSpSfP5STnHTbb0mlnNeQveuvdDKAxG+AIAG5PpVQSb5ZMrS4RFyZ/D4u4gBi4NQEgmd91wd22qzSTjS3zBH51Rzy69duKumAo0FugC9+s/nXPDjibQIaze7/8VY6brvW+PHt5M5zcfAz5q/mM6gCPl/5ph7MxrWPT8xSHh+ZXbjlS1wLA8hd29D72flVv5R7LWSPEts+qSMNMfh2ETIGCe81ll9k6ZeN7xtA/O/aZkdFVQFnSxOSVEzAGVIKjPrSnlntNeS34htpcl2zcveGMjGgnbAMiIq4r7O2kIe8ygKQVkAGfRpk9MegoPnV/gnOi6l2FMhkjScAkmJnfqP1rPcvUk4z2yumwLWhLbERpRhcIBxGIknfMTO9VLlnspxZRlvG3YQggsSGuOZxkFoHzBmcU047h2AuJatBFdCFumReOoYBdwIBOIQ+tb9l3ZXt2nV7erzpOi5MjOAQ1tSADnGWBB3ouwoYcguKttrdmWaQGLEOQFwAYUTsfQbdKG5pehVJceJqyAdh8Ngfh3qy825glgLKv5pAIXy6gJzAgTHeqJb4o31BuWmsBsh9JY+UyVAMjPc4z6GHFc8IT/IxXmSWbYe5IBzsc/AKCT8hU3Cc3t3V1WzInswP0YA0i5d7MPfYkayhiQx8ozOXAE7DAq1ct5VwvDqyFDcJ3l7gT/lQPHzrV8On38EeLI79pbiFWyrCD/t60l9kkHDcQLJ2Ytnu4E5naV2+A+bp/ZPgLqubKXOGuKJxcZrc7CdR8oztIPxqu854JV0Wxc1XEtjzaTpZlyPMTq6HOnIPSsc9pKS8c/ovHT4fk9B/v62xKJdtqV94uSoEGGO2Y9KTe0ntRwnChcHir/vAgwi5BkAEgbY3Pwqj+A5D/AOU0uWBD6Yk423IEiGPTrUfG8Gt8AByt63p1oAG8hHl0keUsTO5iFzvWyUpRtLhmTnBOm/8Adf2GXPaA3Ln7Q1tGZwT4bCVYSFg5HQetSWma+Vt21YMc6QBpG8EZ+UeWM70nPAu6aHtXmMkZBLFdycD+vhRvKeNCXVADIQ06nGmcjrjpS5XY+H0OOETiVhipdhqEk7apBIg+bvPp1oTlVx7fGcWz2WMCwvvqSPKxwTvMzA26jsZ7WcaxCsFJbA1CZOoELGnJMgY9RQfKeTm46DiLd1U1IW1K86SRP4ZEicyN6Ha6KjXkaXPa+2CR4X1UE/MzWVb05PwIHlUAejXP0NaqqZPB53a5MAjsLgcKJLa4XaYAaGdv4cULY5xaCMylGACWzqB95gZALQPQHHzrviF8BH0238yxqD22HbVpENBnrnPypHyVynDtocqw0iQpZh3UBRM9s/MVyrns3kq6GlgLdIi01okHLeVGHbUxBOJ2z9qmHLl1C4WDsNkthiM/uu/mG+8GaA5Pw/hlrroXLCGuX3Cn5QSR03fpRb8wFw6VuXLoYx5AAo8uxOkSMSDpYZGatxXgzTfkNvcG2tDcZbQdSLYks8QSSBtvOSQJrOb84NlYJJlgMaTEnqDkYByNsUo9ouaFVFsutvSF3i44AEjSsHTEncpkkjrOc4toOIW4ROFB656egipWNWinkdFgXmuhnV8ZABC7j/VDCYBjY0IeZI9xdGT00sTHUSrq2TvAkVOVs6ma8pwQFIJHSTqA3/23o/hOYWnBAVYIITSCpAGCTAkj51nGGS3zwauUNeuQHgr9oNOoowkyxGCTnZd/hFEq9s6i8zP7xUGPUMCfr8qZLcs6QGV8AZG2OvTFDWzaOGg5kGMAesqfy+dXpL5M9o+Uc3+OUgw8gCOyau0gQflBrjhbsEMzqBHmwGJ393WI+v3rX7FauvJZNK4B8wJMkEAE7Ajr8q2eFTVGgXNOBkgR3JBpqMkuQcot8Hfj2hshxJmNRgTPZf8A2ml7e1Ns5Np5gRL6xPfGkx6Z+FMSyhSpGC3uKQd+xj1HcfWkd3k9rVvcWZIBWD6bDbHQfSrwyim/U/RORNpaDHl/Ff44zBuS0bYPmnSfWRTnk5tPxD8OUfUql51nTuseWZOHHpjaq81hw1shllCJkMJO2Dp3gnBNNeOIVvEWPFK6SFYK8CIjeD8jtVuUdW68fySlK0WDxOEtFnHhNcCtMMviELMjHqIitcRz4qFKJ4aESCVaTt3EDf13FVBLVtJaD4jAyHaXjPRQI80ST22pxwXHNdCakYwPLpAkRpGNR3gdPSuZNy5NnSJ7V64WBYtJM++ehwOp6gDFD7+IyqWAcFiTB1CBgAQDBO84O1d37sNbLDILSWWDGucw2cHaieAuFc6GYHiJlTiABEKTmSx+lUIhtJd0uxXEqs4OksUTB6eV52im/KeTJw8lVhiTJBdpkz+M9yTG2aBv8U2kqSQfEQFSu+nQFk9G8oMDeKsPLuMPhk3mUMrEMY0DoRjUejDrk0JgU32+u3mRRZXiNSNPktllOMk+UjtEetVnieM422oJtXibgGokBSpCwY0hvKcnMEelegc69rEt29fDtauQVBnXIkx7sD6z8qn9mON/aFuG4o1EjUplgARH4pxg4rW2omde6ypcq9puLtMvgL+0tt4R80jEwR7n8WwnNWb2qL8Sg/ZVROJKjXrYaUUZdTcXEgyJE/GlN7nV0W3tqERFDMoQFfNO/vQfpQ1/nd1QouAXi0gBi20A7qQZx1mow49I1dlZJ7PoL4W01uyltr1tynvRdBOowSQrQxnvHrVe46+vi3Jy+hVtoIBdm1AiW2gGdj8t6JUqbruBp82BJgeUSMn86q/tFcIvG4Mm0bd0Z/cgn7TWr6olAnGcGvjW1ZbiErc1BRkEBdMj5/epeUciNy3dvi69tQ5CzuQkA6hiMyK753zQ3eKRktsrC2ymdvNpKnO+G9JxRnJ0vWrLI6ubJk6isK8lixmSO+JjBnvUYnLHFK32KcYzb48DHk/Irtq4lxr2sAEgQQQSI7nvVlueMqllDkCB5cnONpquDn1weVrFxSBEkNuBj8O3rNV29e82qAGOdipH6/P1q5ScnbJjFQVRLTw/GH9pt3GSQrglHGQykhYMTMwZ/wB69Ls8/B3AyI3+1eVcPxttmtKCxaZ6ROWO5knPrT7xB61cOhyPR7XNLUZB+1ZXnYuj/V/XzrKdIk8rXirmStwiOktTLgeNuNZut4wUgrDlZgdcaTnsY+YrKys8sUpv/wBLg/agO5aPiWwoucRdYNBuPpHlJBkapIxPvjfaiuC48+Ott7gkk6rVpCqzBy7GPN6w9brKl/A0Cc34zRxR8oRfKxZRNwjQPxEyu0eXTTL2h40k+ANzDCZ6gkme4ArdZTxJSnGL8k5HUZMtl/h7OktcAZJBO4JaAFGAdQzuSKhW2TAU+HanKrbXMTInWJ7SRWVlYmpEgVZ8Ig9yxcmOoA06R6Vl2+qEE3HbyzoGB1OScn4Y2rKyh8AgdeZRBwgbIXSIG8xAnP6004V2YoAcsYEEgEkiOv3NZWVfgkkeVAJjUWjERPWWKzImdjW2snVOdRwRJgx38wrKykMy8QsrAVusTq+E5/OKnRsqoGnEH94AgEeY98bfSsrKLAHPDpDuwB0z+BSY/iwevfFTWeLYNKLrB1GZCiMdxOw2iPjWVlIDvhr5fz2ww8jSJUwCQTGoQBnYd60eIPusk6O4QiTnMzJk/CtVlAxebZmfEuEAghZVUBxkBQJg7TkTiNqm46+3iNqJOkESSSTp0rJJyT5QaysprsXgQIIsg/vMs+vnMTXfMecPDWLaKZbMn9yTmQJgdJjPXasrK6IJWYZJNLgZ+J5W/g/PTUXH3P8AEt/P/trKypj0aMy3IyZh2JG3YCPTb70g55xqS9tV1OywSQPdIxn4EHGcdK1WV0wiqs5JzlvQq4S8zXbYQboFA1HOmRudtpjarJyrgNGl3GtQwZ0nSrR7oODIB379q3WUN8UUo82ej8o4rxbIZt9jPUjrgV1xfCWtLEohEZ8o2+larK899ncuio3eWWFKXFt6WVwJBwWIIyJ7elGgVlZXRi6MZnYFZWVlbEH/2Q=="
                                    onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Philippine Renewable Energy Expansion Act</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-file-earmark-text me-2"></i>Bill No. SB 1892</li>
                                        <li><i class="bi-calendar-event me-2"></i>Filed: April 1, 2025</li>
                                        <li><i class="bi-person me-2"></i>Author: Sen. Carla Jimenez</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Provides tax incentives for renewable energy investors to promote sustainability nationwide.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">VIEW BILL <i class="bi-arrow-right-short align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposed Bill 5 -->
                    <div class="card mb-4 p-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4" style="height: 200px;">
                                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhUTExMWFRUXGBUVGRgYGBcYGBoVFxcYGBcYFhgYHSggGhomHxUXITEhJSkrLi4uFx8zODMtNygtLysBCgoKDg0OGxAQGislHyYtLy8yKy8tLy0rLS0vKy0tLS0tLTArLS8tMC8tLS0uLS0tLTUtLS0tLS0tLS0tLS0tLf/AABEIAL0BCgMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAAEBQIDBgEAB//EAEwQAAIBAgQDBQQHBAcGAwkAAAECAwARBBIhMQUTQQYiUWFxMkKBkRQjUmKhsfAzcsHRB1OCkqLh8RYkY7LCw0Oz0hUlRGRzdJOUo//EABkBAAMBAQEAAAAAAAAAAAAAAAECAwAEBf/EADIRAAICAQMBBQYFBQEAAAAAAAABAhEhAxIxQRNRYYHwIjJxkaGxBDNC0eEUI0NSwfH/2gAMAwEAAhEDEQA/AEk81KMXNvRczUumFeyeXZQ70JLJREhoZSmdc+bJmGfJbPkv3smbTNa9r6XoMCywVnvUWatD2t4XhcOY1gOILvHHKeaYyuSRbqBkUHMOvSs2ahutFnGnREmq3NWEVBkqUh1RUa4TU8tdERqdMe0QWp1YsNEJBTxg2JLUSKFjqQiJo6PD1euGqy0jnesL1ittUsrU0XCnwonD8MZzZVJPgASfkKbsyb1hNFh6JjwflWkh7NT/ANRL/wDjf+VFDhTx+1E6+bKw/MUyjESWpIzceAPhREfDGrRx4YHpRMeEp6RFyYhg4WaJXhprRJhbVfHCPCiIZ2PhpHSiUwmm1PRh/KpGICsATjBi21Uz8OFOWqDresAymL4fvek8+AtW6mQUrxWFuOlBpMKk1wYWTCMCbDTqOhqtA67G6dVOtr+RrUTYLXQa+FLJ4Nb7H9aHxFRlpdx1Q/EXhi5WsQyaG3snUMOoBHTypxw7iA0Uk2Omu4Ph50mkGUnw6r/1LXkfpfTYnz6X8vPzqcZOLLzgpxNBPrQmWpYKe6lToy7/AMDXb103as89pxdBUt6EkNNMTFS6VaY7rAJaqhyhlZ1zqCCyZiuZQdVzDVbjS42omRK9hiyujKoZlZWCkZgSCCAV94E9OtBgsd/0jSxM8ASHI30fDtm5jt3DH3Y8p07v2tz1rGmOvoH9IuIkdoFaNFXkQPcRhTmaMZlzfZHRelY7lVGELiiurOpMC5Rrn0c0x5NSENP2aJ9qxeuHq5cPR6YerVhoqCQj1GwFMNRMeEplw/h8kriOJC7nYD8STsAOpOgo/iPCnw7KrlWDKHV0bMjKdyrDexuD5j0o4ToRuTVlPC+zc0q5woSMaGWQhIx/bbc+S3PlTeHhmCj9p5MQ3hGOVF6F3Bdh6KKvw7c/CZN3w13UeMDkcwD9xrN6MfCl6GgrfJm1HgZcW4dCUglijEaurqyhmYB43Ot2JJJVkNFcDLx4fFiN2RssL3VipssuU6jXaSoYU58LInWN0mH7r/VP+Jiq7ghH1y/aglH90CT/ALdK/da7n/Jr9pNdV/ygIYqbrPMfWR/505wUzthsTnldhaFbM7MATJm0BO9kNJwt6ZRJbCv96aMfBUkP5uKaSX2EhJ3z0f2IcFwqPOgYXQEu3hlQFmB+C0VHiIH9uHln7UTG39yS4+RFR4YoWOd/uCMesjAf8qvQqCtVtg3bYoYjhub9jIJPu+xJ/cPtf2SaEN+ulHcPYRo83UfVx/8A1GBuR+6tz6laCjjaRljUXZiAB+th51k+bBJJ1SyyN/Ou2q7GcLyAvGwljBsXW+h+8p1UHodjQYNqZNPgnKLi6ZY1cA8TXhJUQ9EBFoqHli8aKLXqpz+r1gCzEwD4GlGNgrRSRi1K8bBm2v8Ar86xjJYyIbGlbJl9ehHh4GtFjoN73+AuKRYhCu+1c2rE7/w88Uew8+o11GnwPQ01EwpDl10+H8qvEv3qWE2h9XSUnaNxiBSueOmWIkpfK9dYlgjJUsIkhkTlZuZmXl5faz3GXL53taus1ew6ZnUZgl2UZmJAW5tmYjUAb/CgwWar+kePF5oOdzeXyYbZycvO5Y5u/v8AjWQWGtj2+wgV4Dzo5PqIFyqzE92MfWWItlbod6zMaMdlJ9ATSaXuIbW99lAhqYjqzNUWNUItnMtHcJ4Y87FVIVVGZ5G0SNBuzn8huToKALUw4Rxnk5kdeZBJYSxnS4GoZT7rqdQaErrBo1eQ7HcURUOHwoKwn23Oks5HWT7KeEY08bmruDYgTJ9DcgEkvh2OyzHeMnokm3k2U+NK+M4ARBZY35mHkJySWsQdzHKPckHhsRqNK7wfhD4mGWSIhmjeNcl1UkMGObMzAC2XbzpHtUR0puVV/wCBfDeIGCZXy6oSGQ6XGqyIw8wWWr+KQrFKVU3QgPG32onF0PrY2PmDRXHuz2LliixCxBsQwKzoJIhcoSqTZi+UllC5rHcg21NTxPZbHNho0EQaSNVde/EpyS5jLDq+vLYZw2xEj22pO2hd2N/T6lNUe7PSXl5d9JUeH4uvc/xhPlVnZ2X/AHhAT7WaP++jJ/1VTB2K4kmLWNQojWRbTlo9LWYNyuZn0PTfSmOE7JY3/wBolwipCJTOrZ4m7oPMCZQ+YX9i9rddqD1YZz0MtDUVY4Ys5w0FM5JLYaP70sp+SxAfxqXDOHcSw5xKfRUkDqwiYy4fuSBrJIM0lx3WbzvlqWK7M476JARGDIrOrR54tnZznzl8ugRBbfveRpu1i3yJ2E0njp/0nmAw6A++7P8ABAEX8TJQ6gbDUnT49BRXFuz+NUYcJHn+oQMOZEuSS7F17zjN3mOo0onBdn8TFJmIDEIjIc0Y+tcDoX1yXLX65BbestWKV2K9DUcqp9Abi0wUrCpuIgV9ZDrIfn3fRRUhMYYb6CSUaW92E9fV/wDlH3qK4d2VmOIKyqOUrMM+ZO/lvYBQxZS1uuwvQ8vCMU5llmUJlRpCc0TDujRQEckC2g6C1bfDizPT1Fctr/b10AMJi3jYOjWOx6gjqGB0IPgaZ43ABo+ci5DlzvFfVVJsJFG/LPgdR5jWguz+GMs8YADAOhe/shcwvmvprtbqTap8U4mrgpGWy58zFrXkP25PO+y7AedGXvYEil2bcvL4gDyXqssal9HkKGQIxQEKWA7oJ2BP63HjVAf9fo1Qg0y1ZagZPOq5ZD41Q8nQ0TF7Sj9WFDyrfSosaiflWCAYyO4PjWfxkJFaTEWpXjEF6WStDQltdmYxAtpb/WvCceFF4/D+VAcvyrjknFnqQalE22JkoCWWpSvQrmu45bJFq9eoCrsOyh1LgslwWUGxK37wB6Ei+tYU0XbT9rD/APaYT/yhTXsQH+j4u3P/AGemSQIM2eL2Bbuvb3vDSg+30kJeARxurfR8Obs+YcsxjItrDUdT1qfY5VOHxtxAbw2PMeUG3Mi0fI4Aj8xZr9bVzv8ALR0L81+f2MxI1ib73O+p36nqaqeSq5XAJ23O23wvramnZPh4mnu0ZkSFWndFBLOIxcRgAalmyj0J8Ks5JKzmjFydIe8EYYYxwcyOPE4kKzmWMyKInKiLDMgBsZL52vawyi43pd2j4ZA8rpgJFadSQ+HGcDOpIcYdpAC9spOTfwLVV2dhOJx6zYppFvMjXVQfruYuVCGIypuNNRYaUw4rwWH6ZK8ZcqJXY5gFIk5jFsuUm4vsbg+lQSk5cnQ5QUMq8ma7Ppiczq4zQsLTRPdUZV+11RwfZYd4H4gu5ezuWIrA5bCSurajviRQcqSC3dYXNjsw1HUDS3TED6/ukWIlFyzbD65ff/eHeFveq6PDyQNcgZGFrXzRvH4Ajcdb7g+Bp1BJ+JKWq2uceHQUcIwDR8tfbVBIixkDLklN5Ub7rdfmNqY4nC8uWJ176qipHmt+xF1MRt4Asp9fMUzECaOvej0uL6qfBrdPA9fW4qxTmKoNdbppoG6aeB2PwPSmpckt0uG/gV/QTzecGJfMHDkC9j7JOm9tD5giicTgyqBlNmCNGTpe2t7+WVwPhV2KaOFBznOhPcUi4vrZ22Wx10udTQXFu1ccUJMYC3U5SAGObxJe/wCFDnhBeLt197EuJCPiHYKTmcvcC4Iks4t8GppxZMxiw97JeMldPvEn1CyNWf7OdpeJOrM30qSxJ7qyWI6ABBai+L9tcVG4zB1U20kS413FpF+FC20uAuKUnz8v5Jw4psQxZyCQWsv2VZi5A8rsaY8Tw+do4iMzR5eg/ad0D4qFVf7PnWd4L2ww3OLS4ZUIsBJASo8s0LHIfHTLWlSPLGcRHIJlclc63GQH2uYDqrm9tfE67Vty7gbXl38fgL+I4Qh1eGQoyvJIZFt35pARJIRax0OUXG3qaz2B4ZionYRuqoUZZHbQLCbZixA220GpNgNTWhmx63KqQcozM59hF6sxHyAGpJAAJpZEz4t8qKwhBBVPflf7cluttl2UedyWpLCFUm/afy/YhwntApxeFw8YZIRiIdWHelfmKOZIdvRdlHnc00wWWFC2JjBzXKRaiVgRozEH6tOov3jfQdaJ4ZHBHioUyrLLzYhcgFI+8PZ+2/3th0vvSLFcKx8ZmMEjhs5ZwWU3a3vFjcm1tv40jKqmrfPzSD4e0UhkDMAY7FDCBlj5Te0ijpfe+9wDVPFsNynspzIwDxsfejbYnzGoPmDWUwWJcsEysGOmXU3PgttTWxxMLR4Tl4hlSVHDwxsQZcj/ALRWQXKLoGGa2oPjT4TVEalJPd8bFB3vUWeq3e/X5fyqrneVUJFrSgHpVcuIvtVLMKHc1jF7zDyoeYAi9V5q9nrBAZ496XmOm2JYH1oPJU5xsvpyoKY3ql6sdqrBqgWzlqvwrhGVyocKQSrXswBuVa2tjtpUFWisEXWRDGLyBlKWUMc9xlspBzG9tLG9AFmj7f41HeBVhRD9Hw75lzXytGLJqSMq9Otc7HTTjD43lgkCG62QN9ZzI7gHKbm3u/G1X/0kYjFM0CyhgnJhbWMIOaYxzBmCjX7t9PAVZ2FwhOHxfdc3it3ZkS55kWiqR3W++dDtUP8AEjp/zP10MUsRYnTW58tad8K4XlIkLEMpuMpsQfIjW/p470z4dwpk7xHW1jYt6flW+xOAlkzCOOGeOIiExuozqyKASGFmNzc3DddqpKaiQhByujP8DxrTTR/SI1myuhRz3ZUOZcpLrrINNmvTDi2EjlmfksFGdgyN3WaQMcxUnusCTsCD5Vbw7kxzopiaNsyjKwEiZiRY5ZLMraaG5tVHGIGkmkKGBrM4ypZG9o3JVsuZ/MXvSY3YxjyHduGc58/3FsmEKX5ikXNrEEH5dBRMWLtGVIzp1Uk3Hmp90+fzqn6a6HlzA5dSElU7fdvYr6qRSjGcXw5BVX5ROwkJMZ16SKLr/aW3i1UvGSFZ9kccPxS/+AS5FlKWGYXNrOo3BJFiNNtjoAu1PaRcMeXhyOaCFlcEHIPeiiPlsX36CkWDhlw8b4tR9e+aHDlSGABH1s6spINlbKCDu58Kz+HwoRXnxAzRxkDlk25srXKR/u6FmP2V8SKlKXXp9zohp8R4b+g/xuKV1SXEuY42/Zous0x2+rXYLfTO2ngGOlCTdqgsX1X+7KrcohFz4jNa/fmlsU2Oq21U93Sk0kWIZpHmIWeQgLJcZQACGgUrpCwBA8RbL3QSS34R2XaZS0+ZSyqkinKrH+omkLG0bXXLqGZgfZOcmpS1JSOmOjpw6gWI48QHYyzTWEBHMkkvy5UZrnKwuQci3Gl712PtBIgzJPiEQQo5RZGK5nkChbS5gRlOaxB9k7dHOI4HAsVlw7seUVvy5pO4JY3AN5Yju4Psr7J6CxW4vheGlAisYmbl31aJhyoQFOSQyIwAka4MiHu7kg3RuXUrGMOjIRYnDTGMPGc8qsyywRZJBlJBaXDIeW63DG6ZScp02BnBxHEYGRXjkVkcGzKc0E8exBB38CpsynwpVxrhcqErGLiQhM2q8qKMBkhkzWMbZQHfNa+UEEi5N+Bnzjlyd7DuDmc6SSSpe+JgQ6lkFwTu6qQ12NgFqNKjT0Iydrk08skWIiEuHKQYZGviIiTeKQ3yuzatIh9lLDTUWBJNeXtLGVMWGGRSNWawZh52Og+6D6k1mOA4xsFi3hnAeNvqplGqyQOLh18dCHU76+Zr3GeCRYKZlkmaUe1EsWmaJtY2eVhlUEfYD/Cqx1a+Bzan4dS4dM3PZvERriYBmzu0sV9L++Ln0HjQycrmFZ8QsRufq0HMlt95lukZN9jcjwrMdmu0E5xmFRAsMRxEAKRXGYc1dJHJLyb7E5fACp8LnhIYOrBiWsUZRboMwYeP8KotRyeMEXorTjnP2NA3F2CskCjDAggshLSkfemOo9EyisnOrxsSWLgnfc/EnemUEQ9983xsK7iZkNwNQNPKrbV0OXe+HwC4fGEj/Sieb8PnS+SFl1UaVbCD10ooDS6BZI9aqKmpra2nzqhzvRMReok14GuE1gnMtQ5dW1G9YNA7CuotOMN2YxchcCCQZEdzmRwCE3CnL3mPQdatwfZnFskjiCQCMKSGRwxzNl7gy94jc+Apd0e8tsl3ClEq3DQO0iLHfOzKEscpzkjLY3Ftba6U4PZvEiETGFwpcpbI+cZVzZiuXRLdaW4eFXdVZsqkgFiCQoJsSQNSBvYUbT4FaaeTU9u+H4gPAZS2XkwLq4YcxYxzDYMdfvdfGm3YzCKIZ+7GLx2JbPmPfj3I0y+mt6H4vh4XeJoZVl+qihICOpHKUDNdhsbVqoeCTrEGgfMjAGw0I8Qw2axHj02qFrYk8fQvl6jaV/US8JiBxEQtu6g/Bu9b4XppwjjHIRyqZ5ZWLkk2UC+nmdyem9AYVGjkvYqykkXXW/owq7EcTK7pCSP+Gl/IaAGnlDd4ojDU2cOn8ArC8UxM2ITvEkEXCgABMy5tD0+JNZXtliZ1xEhlJ3OUG37PM2S1unrV0PaJWxMKmCE3liW4DgglwL6PbT0pDx3ikTYidDhFa0soussyknOQTbMRc+lKltlhdBm90My6+P7CiXtHOO5FI9jpy2AaP4xuCh+IorB8NbEW5+GQXv3oWaJvivej+SinPBuD4ckMcO6k7/XBrf3o62uBwUQyAKw1HUH+ApmurQqnWItCXj+Ejw8eRRZYIsij7x77n1LM1/SsJxISGWCNEz8hFmkUsE+umyvu2hZQ0KgWPsHQ61tP6Q2JEg+05HzNZriwV58aoEl+efYj5lhG0igEZhYWI6+7SyVpIeE6lKXjXr6EeynCPrnLZrLY5JUOsmrKXU92RVys2YWNwNAGrZxYMPlexA1AWT29SMzOSe+SVAv1AtsACv4DhikegcXWRrNHlF2khXXvdAnyau8a7SGAyIqkyJFmDe5fbQemu1tDQSQZydKj39I0iwxZuaYyeWAqgC1xdiuoOp8+tZ/DOrYR5zOkyiRVEDi7MGIDHMSSl77i46XN7V8w4nxCSdzJKzOzdWJJ9LnoPDpRXZnEMJ41GoZgpBOlmNj+BNRWsrqjpf4ZpbryfQIFDAoc08bhiMwUsyIxLwyue7dSSydMwU3AfKMzjMOIJ7vI0zoVZSndSws0TZiNFylSEVbAEWYbU44fLJHFma10nhZdetpCT8eWnyFW9pIlVkCgaKyXNtRHNLEv+GNR8KfslZP+oe0RcYzSYaDEFQrRu+GYD7GssAA8ADKgv0jWnXEY/pPDcNNbvRNJhWPUrYSxfAZpB8Kt4DwYT4bHIzqgCwyqzkKquhkALsQbLZ2BPgaedmezX/uzEA4rDMTPEQwmBiXKrbtl0c8w6eAFKqjKmPLdOG9dxh+zPDmSZcSxywYaSOWRz91gyxoPeka1gB6nQUBw/i7xhrQwSXYteWPMwv0BzDT+JNb7ivY0jDQn6bh7M0zEPPaLMuRbxd3VraMf3aQ8Z7DCIx5cZhBnijkbmThbs17mOy6x6aHrrSySTwU03JrKM6cUzsxay5iTYaILm9gOgHQUww0wXqD8aaydio1xvI+lwKnNVMrTL9IykgH6vLbma6D0oWTs5lkZDjsDYMyi84DWBIGYBdD4inhqpEtX8NJ8GjwnZt5URlmiyv8ARzYyRqQJUzNcFgQRpYbtUf8AYebfmw2yym3Oh3T2dc+x6n3ap4X2dJSZzxDDExrC6lMQGRWRgiGU5e6oUkKfHSim7OE4UP8AT8NmMksV+eOVkZFZlDZb5yWJI8CKbtG/1C9io/o+p49jp86JzYMp5d/r4bjOFLWXNra5t46eNWf7ES2/aw+xI37aLdWYKPa2IAuemvhVD9kyiQS/TsMJGBOZ5wF+qbInJOXvAKqg32IpliuzBSZI1xsAVljBzzASETWaQRrltZixI8bim7R9/wBBXpJfp+oJ/sLLmA5sNs8K/tYr2kUljbNuDsPeGtZQjUjzNbjD9lC2NEJx0OUSgWWYGf6q6x9zLbmKBby1oLA9jldp74vDHJHI4yTAkMrKAZe73U1Nz0NqMdRLliS0W/djXmZS1cy1rcN2QVoZnOMwuZOXYrMDGM7EHmtl7u3d8Teg/wDZv/5zA/8A7A/9NU3xE7KS6FWC4/j1zOJpWEkcvtSyMAmod0GfustjY9KJwfGceqPHzpm5hhS7SyFlL/WRcs5+6WAPqNKuTtxiwoGZSQrqTki1LE5Wty9LX22NqNh7aYskG62zQt7Me0alXW/L98kG/u2sKTbL/VevIffH/Z+vMXy8dxnIWJppcpZpA3MkzsDeMqWzapdT3fG9BcNwwzrmBy3GYLoct9QD0Nr0y4njXxDI0liyrlvYC4zsw0UAD27fCiOD4cK6kgNqCQeo6jTxqkVS4Iylb5NYeHQx5eUri6KbswPtqG0sBqL0fJxiRVWKGyKotm3bz30H+dS4k69yyBfq47EEnQqLDXoKrwkK8t2bKSBmF2y+8o1121OtSw4pyRVuSm1B0DKgeWMO5uxtfdtvE/51keLcfwewinf1mRPhpGTXOIdocmJhy2JWWNmN9AiuC34XrMcSwZTEzQ63WWQZj4BiBlHQW/Qp371E17l+JqOzK4WWeN2w0kaCRQshlklHODqVQhQgG+58NjTvF8PgXESmOCNyXZmZhMpzFjcWMpHxFgfAVR2OgUCJHJADqQAQO+p7pNxtqR47VosThiXdgrKuZheQquuY3IOgI8KSkp5Y26UtPCXPcD4ewFljjHopt/iJoyKQi2i6fdXp8K8iKBbNf90E/ibfxqwdMq/PU/y/CnddxG5d/ryMx/SJhLpJbxJH5isvxblmWbMQonMGJTQm+dc5Gg3vK416qRX0fj+D5kdzuRlP7y6dPLLXztoHyC37XCFtNi2FZibg79xmYX6CQH3aVcJ+RR+9JefryYz4KoEel1IzKM/c0lKFCVFzbmRIt72+tpdxeEyATqpJHddSLFlsVJtqQpGlz1vtXuGWje6NzDYls1wuQ+0ZOpY326Ei2Y2s3xDGY543YZbXbe5ttiAouv71ihG+UnXPDMvaVHyTiHZlsxMLqynWzMqMvkQxAPqKP7NcF5b52YFwNAO8qn7RYaE+FideotY7WXhWYMww7EWNjA1wwH2rB11LDQWtV2BwTRmPIiwswABcky5iFYAIBe92tcKDodRU1pwTsu9fVlHb9SmPBKmRXBsjCWTS4XJblxN1zG9upvKBbQ2W8cw7ZxswQCMsNRnF2k12B5jPv61oJ8SkC2HdY95S2pVhfWbLpmUk2QXyHvHXQoMLgLTKYyVclQYgbs4NsqRts6voNb2BvqATVE87iNKtqA8aXiwMxzW50scQG10iR2k23F5Ih8aP7JRleGzkk5ZJ4VA6XRJGY2295B8qU9s8YHmSCMgpECt1HcaVmzTMo+zm7o+6i1sJ+Hth4MNhWUqyo0r3FvrJSDbzyqqD1vSRzIrP2dOvD7+mJMLw84iIxhmMyFjHET3HQ2LCK/sy6Xt73TUa5HHM7WzFjlAUZiTZRsovsB4V9D4RB/veGP8Ax4f/ADFrNLMyZ7YeKUZmJZ4y1vK4IsOvxqk0S0msMx+Ilkz83O3Mvmz5mz5hsc173870MHJuTcm9ydzc7kk7+tN8YMzMcoW5JyqLAXN7KOgFVQ4OwNxvXO9J3g7VrqslOFxrqrKGIDizDXUA3FwDrqL28qJgxLZcuZsgObLfTMQASFvvYAX30oV4AN9vxFTigB1BB9dD/KjHcmaW1qxsJWYKrMxC3ygkkC5uQo6C+tEviXJBJYsLAMWYsMui2JOlrC3halkBtRyPXVE4pLJdHO4fmZ2D3vnDHPmO5zXvfXe961I7E48FsqMAxmUkMozIqhlLd/USHSx2Iuax7MTRH02Qm5bUtM2y+1OoWU7e8AB+VqElLoGDj+o1A7EcQCsAjWIiJUMoDE6kEZ7HIT1+FDYjsTxBWZRhiwBIDB4wGANgbF7i+9JBiXIsTpaNbWG0fsDbpUMQgdmdgCzEsxtuxNydPM0Ep9Wvl/Izen0T+f8ABci0zwwFqBQa00wiX6X/ACqhzB2FgvrTvARMrAgXIItpm1B09emlC4FLeu+nSneBXVQN7gLbqSfz2oMy5HnEmY5M+lkQ+yBrlGbYfhSjF8QCwYk5lXLETqge3fQAkdRrtR3aMyrkBzWKKNTfvBRm+NAcPzFMRrKBy9MshTd0tl7ujfe8NLVCv7ao6brWd+sHy3Bxq+ha5O5IC3vvYkWA12reyjDM4naJpJXWNmBdAmYKFJWwLNcqTuNarXgo8/G+5ovA8AuTrYAEkm+gB8FuTvVWlyznjJ3S6h/CuJOJUAijQEqMoW2jMLNmvm6eNqvZTJNKcmUBiCbnLoxFyzGwPlerOFokUiiMGRjYFn2ALC+VPHzJ+FUcUkleVgbmxYAaAAXPT+NTS9vCLSf9v2nefWQ+MIo3zHy0HzOp+XxqzMemg8Bt/M/Gs8rONLdbDrc+A/lR6TFPaF2+x4fvHx+6NfEjaqNLzIJt8YQ2iAsVbRW6+DDY/jY+RrG9p+GSRuJ4bLKh8LggixBHVSCRbqDWkTFE6sdBp/kv60qRxKSjI1h0Vt7fdbxHnuPwpcq+7qPhpVh9PX2PneDyyB2hU20MmHH7SJlv34+skYzHXoDZre1U4YyAZIy3duFK+0Li7yHLqpO3gAbX7opvx7swwcSIGVwcytGddOqlfzFJMTxKRbieISPe2ZbwzepZAVJ82UmtWMZM2m84ZGfiTlXLBGtHGO/FG13lYSC7Fbnuefu12PGSNCcpCApGxEYWPQExFTkAuCSDbX2apw3EsINc2KF2BbMIJrkaC5Yr0J1tXY+L4RSWAxDEaXLxwALcmwEQJtrfQj1oeQ2e8lJhC5CFXLSDNZVvIJBoWCEjusNSTYd4n3aA4zxmPDLyoSDPlaPOrZlhQ3zJG/vytc5nHdAJC7kijiXGZpQ0cKrFE4syxAjMP+I7Eu/oxt5Uy7PdiAAs+LYpFuq/+JJbogOw27x01oSspDauOSH9HPAjdsbMuZYdY0t+0mAuqjxC2ztbYAU8ixkpLMWzB2LMGAZSxNycp0B8xrTN2E2URry+UCEjTYLe9065+p6m1x4VYsaye1ZH+1srfvjofvbePjRiq5FnK8J/yUcJhibEQGxiYSxG2ro1nGgPtIfXN6ikk3BMYobld1GJ7yumRr+DA2P56VosFhwmJhD3Dc2LfTUuLW8fKlsfF1jzkSGPcWKFlcea9R07wovnBo5WfHwMVJwkJqdfPpSjFnwt+Z+Qrdy4jC4kfWKIGOgeMZ4ifvxnVT5qx39mkHGezUsSmUBZYv66Fs6DyYgXQ7aMBRcunAIw68mQZDfc14QHcGjZIfn+dRjup1FT2ZyX7R1ghFfrp50WieRNEQxBgdNBqR4ef8KtTCVZRojKVlCgdT/H8dqsVh0H6+NTODoiHCeVMCiCCrMlGx4ap/RqwxQq00wHhQgi60dhFrHMO4bC1GxSarqALhdb2F+pA10pVzNrCrlOhs19qwLH/G1UOmVgzGKJTYMLDKLNci1jRXC3zRyg5LZOpa9s6WvYjT0pXxaa0iabwQ6/2BR3CJxy5bEgiO98gb3111/L41B/lo6V+c/P7HM4CgX+WtegxGRgbd0aW8VIsR6EGl2bT8/Tr6GpLIev4+FWq1Ryp07Q8wqMs4CnQ2YHNa8ZI63/AA8jXMSGaV79PeLAqFJNrsL28hv5Usw+OTLllDaHMhW1zfdNfdO99ba+NUzY3mADRFBJCLoB4X8T4k61JKW4u5Q2V50MGmUAhL+9d9j1vl+yPxP4V2OJGAZgMm3q2mi3/PpQEEeVS8mkfS3tOeoXwHi3TzNVS4ova9hbZR7IA2A8vxNP4L5iPvl5L16YxnZGsDYAXUAHQL+utCzQCLvKRmbRANNNmb16D4+FUYZrksdFUXY76bWX7xNgPXwFVLIJ373dUDMbe7Go1A+FgPMis+4yvnqx3hc6oozL3tcr6qfAW6E6m412qnFRwsgeVCpuVsCJFvrfSTb59aQz44s+Y9NVtsPADyA0+FS4nj2EaruSuc+rkkf4QnzobfmNvw+5BEvZvBMQDYFgGAMTDQi/uki+vjUZOzGARlVgxJtbLGdztqzaeG1LuK8WdcRIuhVHKDT7JK/wruM45IiRWO6FgfBlmkH8FoU6Wft+wbim/ZWPj+4fw7EYWMJJDhxlOztaR7eIBsqt8DVkmIu7JJ3sz2zkhrNa6ubnRCCPgwPQVmOOTcuZmjJA3AHs5HAZGA2vlZanHjTNEXv9ZGVR7aXRrmJ/UHMh9E8aNLkO55Xd6Yxn4iyMRYIVNrHNcMDbYAdfOuYrES4he4CJhclFFhKvXJZriQblfe3GtwR8RK0sJfRpIwBIOrRaBZLeK6K3kUPjSIqbhkYqQb3BO4pufiLx8DT9lePZ5oYpULASoEJ9pWLjQMOl91Oh8jrQXEsLFGM7K8sbMcksTlVv9h9yr/dNvjuDOzpGJxEDtZMSksbPsFmVXBLr4SgC5GzbjW9xcNxF4AwVUZHJDh0LK33W2v8AmNxU+uCy91X8zMWY3Ib56/M/zvTbGYfk4XkjSXEZJZR1WFdYYz+8SXPlkplFBgb/AEgN3E7xwz35hf3URrd+IncnUAG+9JMfi2ldpZDd2Ylj018ugG3kLU/vC1tXiZ6SEroarkUtr1H4jb5jT9CmWJQ3sfhVccOoPzHkd6cVFGFpsIdPzoaPDa01wybVg0DrF5VZGtGsgqtktWGo4BUb1aFrmWsMcC7UXAKogFHQiscR0NrarcPJZgSLgEHLe1wDqL9PWuFR8a9C+VgwANiDY6g26EeFYyH/AB+ZC0YWPKeVEb5ibgoLLt08etV8Lx2RXSznOLd18thcG47ps3d38DVnaDEZmjGRF+qia6gg6oO7qToOgpdCb29QPx/L1qUIpwSZbVm46jaDlF73HXz0od4rnTToBqb+VX3UAd65N7jrbpr1FdcLm7t7AXBF/D+FVIAM6lTZhfpcXt6etX8JgR2Y6tlBYRjRnI91T08T1te169LLYarcnx8T1AqrkWN1urCxuCb5tCCPO9Bq1gaLSdsjPxFpDdrDSwFu6q9FUdB+jUYMxIVRdjpYdSdgKJniE3tZUn8bgRynz6RyeegJ8L0PDE+GjLsCsz5ljVvaRASryW8Tqq/E+FJupV1KbG3beO/11L+IT5QIUIIW5c39qTr6qvsj4nrUZGVIQraPLZj4iMHuDTxILegWhOHRCRwraLYu7D3Y1F2PysB5kVRjsbndpCLZjoPBRoqjyAAHwo1mjXjd5IkmEzMFQ5iSFt66D86KmiEmJULYqZUjFv6tSEX/AAgfKq+Cv9Y0mh5aPJ8VFk/xMlS4KRzkP2cz/wBxGf8A6a0nz8AwXC72LMSAzMx95mb5kn+NW46ENBCdNGmX/kb/AKz866H/AAt4b0QYwcKdNph8M8f8eVReKBHNi/iUV48O9vc5Z9YiVH+Ax0NwlBFNdv2bgxyfuNa5HmpCuPNRTaGG+GcWvy5FcfuyqUa39pI/nQPJG1BK00M8NMvCPh5emZCVYHVWGxBHVGBI9DUeJ8OVGDR3MUgzJfe17FSftKdD8D1o/FpzIUlB70doX+A+qY+qgr/YHjXOG5ZFOHZgA5vGT7k2wv8Adb2T/ZPShfX5j7f0/IS4RmjkSQAEoyuAdiVYEX+VaXi0UeIhbExuFK95wxsC2gs4Ggl10I9seBBFK4uFMt3xJMUYJXUXkdgdUiU+0emb2R40HxbiRfKioUiT2I11sTuzndnP2vlag1ukmho+zFqXUWYm3UfryoPf02/zohyD7pv6XqDxtvYedVJ0QjhNt72/W/jV0cNqlGvgLUasQrDUULEN+lXxLUlTpRCxCsNRFrVSRRDpVRW1YZIiK9euGoZ6wQiK4omNja1CJtRmGFY4C4C2lr1LD5s6lL58wy21Oa4y2Hje1TUdbVJVuyqu5IG4Gp21O3rQMuRz2oee8fMz5eXHa4sM5QZ9bb33FKcLJr+tT8KYdpIHVoy1iOVENHDd5UF9Ab/HY0riIvf40ml7iK/iL7R2NIyLm1gLNbXr4V5E0va19PH1NqHjYNrbr/rRpJ0I9m9rb7CqESLtY2sDr8760McMd16b9fh40S81rACx31/MVWTuAfiNj1/OsEo8hluT+H51XiIw1jc3Fhe99ANBrsKKBzdNr9fOqm9L36eB67elYJZh8GzYdlj77u1nUHviJNVCruwLWJtfYUifBsCRtbcHQ/I06RLnS9tv0avbHOdHCygaWkAYgeT3DD50lNcFbjJJPAmgjKYaVrd6SRIv7KXke3x5de4ITec/ZglI8iwEf/cphjp1kVEVAirmNsxa7MRc3PoN77dajgIo8kyM/LZ1VQSrsLCRXYd0E7L+NB3tYyrckui/n7mebEnqPL4UxwU18NiPutA/p3nT/uCiW4Mh/wDiYf8A+w/7dTTBxRRTgzRsZIwoCLIe8JEcEkoBbunetKVrAYwaefHr4AfAZM0jxf1sUij95RzE/GMD40AZxYGrcBeKVJV9x1cDTUA3I+Ooos4pEJMGGiTXeTNMw190N3B/do5TwjKnHLLezcbuXzKRh3UpJI1lRRur5msCVYKbXvvSN5bXFwel76b9L7iiMZNNMbyyM5GgudB6LsvwsKH+j+f689LUUndsLapJEsVj3lOaR2ZtBd7k2GmlDMPG+nl+dFLhrHW9/wBa11ovM/r1og5BSnp6V0rfQi3wopIf1+tKtVOlvyNEagZEW+o1q4AdK7yqmqVgpEVXyq1VFRFWVhqKpapc1ewqpj0rDUUNUcwrr1XasEKjWjIDal0DmmEW1Y80Jil8aIRQSLnKCRc2vYdTbr6UMotV8bVjDDjXKYoY3L2REPcK2yKBe58fCl+S1XK1cmFvjSxVKh5S3OzkB63tRsD2tr1HwPnQMa1akljt0phQyWO5Budrn9fGqE0uCfMXG9EQnMp6WF6oeTqddBb1/jWCedr6m17abAD186pMluu/41Bpj1tYaiq1fMR53+HWsEskfQ30qJ9Px6edU8077nUa+VWYm1hpv/mawS5F8NvAH8aibeYH5n+dD8zw01qQkI/K1YajrJ+v0K5y77/r43qea9tLa2/CpKb/AJfKsEoMelV8u2mlF3qo7j41hgbl67VYIenxq1lsfhf8K4W0Gn6FYKQNydTpb8Pyrzw+H5j9Grc386izeVYainIa5b9f6VdewvbeuldAfWsNRQR0uPxr2Xr/AKVcy2+VVZutYYiRXjXbXrjDSsEg5oeQ1cw6UK53rBKpGqnNVslDVhqP/9k="
                                    onerror="this.onerror=null; this.src='{{ asset('theme/addons/images/logos/pllo-logo.png') }}';"
                                    class="img-fluid rounded-start"
                                    style="height: 100%; width: 100%; object-fit: contain;"
                                    alt="Proposed Bill">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title mb-2 text-primary fw-bold">Digital Workers Protection Act</h6>
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="bi-file-earmark-text me-2"></i>Bill No. HB 2890</li>
                                        <li><i class="bi-calendar-event me-2"></i>Filed: May 15, 2025</li>
                                        <li><i class="bi-person me-2"></i>Author: Rep. Liza Montano</li>
                                    </ul>
                                    <p class="card-text small text-muted mb-2">
                                        Establishes rights and protections for freelance and gig economy workers in the digital space.
                                    </p>
                                    <div class="text-end">
                                        <a href="#" class="fw-semibold small text-decoration-none text-primary">VIEW BILL <i class="bi-arrow-right-short align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{--  --}}

            </div>

        </div>
        
    </div>

@endsection


@section('pagejs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>

    function buynow(){
        var qty = $('#quantity').val();
        $('#buy_now_qty').val(qty);

        $('#buy-now-form').submit();
    }

    
    function add_to_cart(product, price, remaining_stock, name, image){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var qty   = 1;
        // var price = parseFloat($('#product_price').val());
        // var remaining_stock = parseFloat($('#remaining_stock').val());

        if(qty <= remaining_stock){

            $.ajax({
                data: {
                    "product_id": product, 
                    "qty": qty,
                    "price": price,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('product.add-to-cart')}}",
                success: function(returnData) {
                    $("#loading-overlay").hide();
                    if (returnData['success']) {

                        $('.top-cart-number').html(returnData['totalItems']);


                        var cartotal = parseFloat($('#input-top-cart-total').val());
                        var productotal = price*qty;
                        var newtotal = cartotal+productotal;


                        $('#top-cart-total').html('₱'+newtotal.toFixed(2));
				        $('#input-top-cart-total').val(newtotal);

                        // $('#top-cart-items').append(
                        //     '<div class="top-cart-item">'+
                        //         '<div class="top-cart-item-image border-0">'+
                        //             '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>'+
                        //         '</div>'+
                        //         '<div class="top-cart-item-desc">'+
                        //             '<div class="top-cart-item-desc-title">'+
                        //                 '<a href="#" class="fw-medium">{{--$product->name--}}</a>'+
                        //                 '<span class="top-cart-item-price d-block">'+price.toFixed(2)+'</span>'+
                        //                 '<div class="d-flex mt-2">'+
                        //                     '<a href="#" class="fw-normal text-black-50 text-smaller"><u>Edit</u></a>'+
                        //                     '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product('+returnData['cartId']+');"><u>Remove</u></a>'+
                        //                 '</div>'+
                        //             '</div>'+
                        //             '<div class="top-cart-item-quantity">x '+qty+'</div>'+
                        //         '</div>'+
                        //    '</div>'
                        // );
                        var cartItem = $('#top-cart-items').find('[data-product-id="' + product + '"]');
                        if (cartItem.length) {
                            // If the item already exists in the cart, update its quantity and price
                            var oldQty = parseFloat(cartItem.find('.top-cart-item-quantity').text().trim().replace('x ', ''));
                            var newQty = oldQty + qty;
                            var oldPrice = parseFloat(cartItem.find('.top-cart-item-price').text().trim().replace('₱', ''));
                            var productTotal = price * qty;
                            var newTotal = oldPrice + productTotal;

                            cartItem.find('.top-cart-item-quantity').text('x ' + newQty);
                            // cartItem.find('.top-cart-item-price').text('₱' + newTotal.toFixed(2));
                        } else {

                            $('#top-cart-items').append(
                                '<div class="top-cart-item" data-product-id="' + product + '">' +
                                '<div class="top-cart-item-image border-0">' +
                                '<a href="#"><img src="{{ asset('storage/products/') }}/' + image + '" alt="Cart Image 1" /></a>' +
                                '</div>' +
                                '<div class="top-cart-item-desc">' +
                                '<div class="top-cart-item-desc-title">' +
                                '<a href="#" class="fw-medium">' + name + '</a>' +
                                '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
                                '<div class="d-flex mt-2">' +
                                '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
                                '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
                                '</div>' +
                                '</div>' +
                                '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            // $('#top-cart-items').append(
                            //     '<div class="top-cart-item" data-product-id="' + product + '">' +
                            //     '<div class="top-cart-item-image border-0">' +
                            //     '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>' +
                            //     '</div>' +
                            //     '<div class="top-cart-item-desc">' +
                            //     '<div class="top-cart-item-desc-title">' +
                            //     '<a href="#" class="fw-medium">{{--$product->name--}}</a>' +
                            //     '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
                            //     // '<span class="top-cart-item-price d-block">₱' + (price * qty).toFixed(2) + '</span>' +
                            //     '<div class="d-flex mt-2">' +
                            //     '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
                            //     '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
                            //     '</div>' +
                            //     '</div>' +
                            //     '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
                            //     '</div>' +
                            //     '</div>'
                            // );
                        }

                        $.notify("Product Added to your cart",{ 
                            position:"bottom right", 
                            className: "success" 
                        });

                    } else {
                        swal({
                            toast: true,
                            position: 'center',
                            title: "Warning!",
                            text: "We have insufficient inventory for this item.",
                            type: "warning",
                            showCancelButton: true,
                            timerProgressBar: true, 
                            closeOnCancel: false

                        });
                    }
                }
            });

            $('#quantity').val(1);
            $('#remaining_stock').val(remaining_stock - qty);
        }
        else{
            swal({
                toast: true,
                position: 'center',
                title: "Warning!",
                text: "We have insufficient inventory for this item.",
                type: "warning",
                showCancelButton: true,
                timerProgressBar: true, 
                closeOnCancel: false

            });
        }
    }

    // function add_to_cart(product, price){

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     var qty   = 1
    //     // var qty   = parseFloat($('#quantity').val());
    //     // var price = parseFloat($('#product_price').val());

    //     $.ajax({
    //         data: {
    //             "product_id": product, 
    //             "qty": qty,
    //             "_token": "{{ csrf_token() }}",
    //         },
    //         type: "post",
    //         url: "{{route('product.add-to-cart')}}",
    //         success: function(returnData) {
    //             $("#loading-overlay").hide();
    //             if (returnData['success']) {

    //                 $('.top-cart-number').html(returnData['totalItems']);


    //                 var cartotal = parseFloat($('#input-top-cart-total').val());
    //                 var productotal = price*qty;
    //                 var newtotal = cartotal+productotal;

    //                 $('#top-cart-total').html('₱'+newtotal.toFixed(2));
    //                 var cartItem = $('#top-cart-items').find('[data-product-id="' + product + '"]');
    //                 // if (cartItem.length) {
    //                 //     // If the item already exists in the cart, update its quantity and price
    //                 //     var oldQty = parseFloat(cartItem.find('.top-cart-item-quantity').text().trim().replace('x ', ''));
    //                 //     var newQty = oldQty + qty;
    //                 //     var oldPrice = parseFloat(cartItem.find('.top-cart-item-price').text().trim().replace('₱', ''));
    //                 //     var productTotal = price * qty;
    //                 //     var newTotal = oldPrice + productTotal;

    //                 //     cartItem.find('.top-cart-item-quantity').text('x ' + newQty);
    //                 //     // cartItem.find('.top-cart-item-price').text('₱' + newTotal.toFixed(2));
    //                 // } else {

    //                 //     $('#top-cart-items').append(
    //                 //         '<div class="top-cart-item" data-product-id="' + product + '">' +
    //                 //         '<div class="top-cart-item-image border-0">' +
    //                 //         '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>' +
    //                 //         '</div>' +
    //                 //         '<div class="top-cart-item-desc">' +
    //                 //         '<div class="top-cart-item-desc-title">' +
    //                 //         '<a href="#" class="fw-medium">{{--$product->name--}}</a>' +
    //                 //         '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
    //                 //         // '<span class="top-cart-item-price d-block">₱' + (price * qty).toFixed(2) + '</span>' +
    //                 //         '<div class="d-flex mt-2">' +
    //                 //         '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
    //                 //         '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
    //                 //         '</div>' +
    //                 //         '</div>' +
    //                 //         '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
    //                 //         '</div>' +
    //                 //         '</div>'
    //                 //     );

    //                 // }
                    
    //                 $('#top-cart-items').append(
    //                     '<div class="top-cart-item" data-product-id="' + product + '">' +
    //                         '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>New item added. Reload to Edit</u></a>' +
    //                     '</div>'
    //                 );

    //                 $.notify("Product Added to your cart",{ 
    //                     position:"bottom right", 
    //                     className: "success" 
    //                 });

    //             } else {
    //                 swal({
    //                     toast: true,
    //                     position: 'center',
    //                     title: "Warning!",
    //                     text: "We have insufficient inventory for this item.",
    //                     type: "warning",
    //                     showCancelButton: true,
    //                     timerProgressBar: true, 
    //                     closeOnCancel: false

    //                 });
    //             }
    //         }
    //     });

    //     $('#quantity').val(1);
    // }
    
</script>

<script>
    
    // for edit quantity
	function FormatAmount(number, numberOfDigits) {
		var amount = parseFloat(number).toFixed(numberOfDigits);
		var num_parts = amount.toString().split(".");
		num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

		return num_parts.join(".");
	}

	function addCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

    function plus_qty(id){
		var qty = parseFloat($('#quantity'+id).val())+1;

		if(parseInt($('#maxorder'+id).val()) < 1){
			swal({
				title: '',
				text: 'Sorry. Currently, there is no sufficient stocks for the item you wish to order.',
				icon: 'warning'
			});

			$('#quantity'+id).val($('#prevqty'+id).val()-1);
			return false;
		}

		order_qty(id,qty);
	}

	function minus_qty(id){
		var qty = parseFloat($('#quantity'+id).val())-1;
		order_qty(id,qty);
	}

	function order_qty(id,qty){

		if(qty == 0){
			$('#quantity'+id).val(1).val();
			return false;
		}
		
		var price = $('#cartItemPrice'+id).val();
		total_price  = parseFloat(price)*parseFloat(qty);

		$('#order'+id+'_total_price').html('₱'+FormatAmount(total_price,2));
		$('#input_order'+id+'_product_total_price').val(total_price);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			data: { 
				"quantity": qty, 
				"orderID": id, 
				"_token": "{{ csrf_token() }}",
			},
			type: "post",
			url: "{{route('cart.update')}}",
			
			success: function(returnData) {

				$('#maxorder'+id).val(returnData.maxOrder);
				$('.top-cart-number').html(returnData['totalItems']);
				$('#prevqty'+id).val(qty);
				// var promo_discount = parseFloat(returnData.total_promo_discount);

				// let subtotal = 0;
				// $(".input_product_total_price").each(function() {
				//     if(!isNaN(this.value) && this.value.length!=0) {
				//         subtotal += parseFloat(this.value);
				//     }
				// });

				// $('#subtotal').val(subtotal);


				// for the sidebar cart total
				// var cartotal = parseFloat($('#input-top-cart-total').val());
				// var productotal = price*qty;
				// var newtotal = cartotal+total_price;
				
				// alert(cartotal);

				// $('#input-top-cart-total').val(newtotal);
				// $('#top-cart-total').html('₱'+newtotal.toFixed(2));
				// 
				
				// resetCoupons();
				cart_total();
			}
		});
	}

	function cart_total(){
		var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
		var promoTotalDiscount = 0;
		var subtotal = 0;

		$(".input_product_total_price").each(function() {
			if(!isNaN(this.value) && this.value.length!=0) {
				subtotal += parseFloat(this.value);
			}
		});

		if(couponTotalDiscount == 0){
			$('#couponDiscountDiv').css('display','none');
		}

		// var totalDeduction = promoTotalDiscount + couponTotalDiscount;
		// var grandtotal = subtotal - totalDeduction;
		
		// $('#subtotal').html('₱'+FormatAmount(subtotal,2));

		$('#top-cart-total').val(subtotal);
		$('#top-cart-total').html('₱'+subtotal.toFixed(2));
	}

    $("#op_hov1").on("mouseover", function () {

        $('#img_op1').removeClass('invi');
        for(var i = 2; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov2").on("mouseover", function () {

        $('#img_op2').removeClass('invi');
        $('#img_op1').addClass('invi');
        for(var i = 3; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov3").on("mouseover", function () {

        $('#img_op3').removeClass('invi');
        for(var u = 1; u <= 2; u++) {
            img_looper(u);
        }
        for(var i = 4; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov4").on("mouseover", function () {

        $('#img_op4').removeClass('invi');
        for(var u = 1; u <= 3; u++) {
            img_looper(u);
        }
        for(var i = 5; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov5").on("mouseover", function () {

        $('#img_op5').removeClass('invi');
        for(var u = 1; u <= 4; u++) {
            img_looper(u);
        }
        for(var i = 6; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov6").on("mouseover", function () {

        $('#img_op6').removeClass('invi');
        for(var u = 1; u <= 5; u++) {
            img_looper(u);
        }
        for(var i = 7; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov7").on("mouseover", function () {

        $('#img_op7').removeClass('invi');
        for(var u = 1; u <= 6; u++) {
            img_looper(u);
        }
        for(var i = 8; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov8").on("mouseover", function () {

        $('#img_op8').removeClass('invi');
        for(var u = 1; u <= 7; u++) {
            img_looper(u);
        }
        for(var i = 9; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov9").on("mouseover", function () {

        $('#img_op9').removeClass('invi');
        for(var u = 1; u <= 8; u++) {
            img_looper(u);
        }
        for(var i = 10; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov10").on("mouseover", function () {

        $('#img_op10').removeClass('invi');
        $('#img_op11').addClass('invi');

        for(var u = 1; u <= 9; u++) {
            img_looper(u);
        }
        
    });

    $("#op_hov11").on("mouseover", function () {

        $('#img_op11').removeClass('invi');
        
        for(var u = 1; u <= 10; u++) {
            img_looper(u);
        }
        
    });
    function img_looper(cnt){
        let img_op = '#img_op' + cnt;
        $(img_op).addClass('invi');
    }

    // services js animation
    $('#img_serv_trigger1').on("mouseover", function () {
        $('#img_serv1').addClass('scaleUp');
    });
    $('#img_serv_trigger1').on("mouseout", function () {
        $('#img_serv1').removeClass('scaleUp');
    });

    $('#img_serv_trigger2').on("mouseover", function () {
        $('#img_serv2').addClass('scaleUp');
    });
    $('#img_serv_trigger2').on("mouseout", function () {
        $('#img_serv2').removeClass('scaleUp');
    });

    $('#img_serv_trigger3').on("mouseover", function () {
        $('#img_serv3').addClass('scaleUp');
    });
    $('#img_serv_trigger3').on("mouseout", function () {
        $('#img_serv3').removeClass('scaleUp');
    });

    $('#img_serv_trigger4').on("mouseover", function () {
        $('#img_serv4').addClass('scaleUp');
    });
    $('#img_serv_trigger4').on("mouseout", function () {
        $('#img_serv4').removeClass('scaleUp');
    });

</script>
@endsection

