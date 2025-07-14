@extends('theme.main')

@section('pagecss')
<style>
    .icon-contact-style {
        border: 1px solid gray;
        border-radius: 100px;
        height: 30px;
        width: 30px;
        align-items: center;
        display: flex;
        justify-content: center;
        padding: 26px;
        font-size: 24px;
    }
    .nav-link.contact-tabs.active {
        font-weight: 800;
    }
    .contact-map-container iframe {
        max-height: 400px !important;
        min-height: 400px !important;
    }
    .contact-map-container .fluid-width-video-wrapper {
        padding-top: 28% !important;
    }
</style>
@endsection

@section('content')
<div class="container bottommargin-lg">
    <h3>CONTACT US</h3>
    <div class="row">
        <div class="col-lg-4">
            <ul class="nav canvas-tabs tabs-bordered canvas-tabs tabs nav-tabs mb-3 border-0" id="canvas-tab-border" role="tablist">
                <!-- osec tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active border-0 contact-tabs bg-white" id="osec-tab" data-bs-toggle="pill" data-bs-target="#osec-border" type="button" role="tab" aria-controls="tab-osec-border" aria-selected="true" style="border-right: 2px solid black !important;">
                        OSEC
                    </button>
                </li>
                <!-- senate tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 contact-tabs bg-white" id="senate-tab" data-bs-toggle="pill" data-bs-target="#senate-border" type="button" role="tab" aria-controls="tab-senate-border" aria-selected="true" style="border-right: 2px solid black !important;">
                        SENATE
                    </button>
                </li>
                <!-- hrep tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 contact-tabs bg-white" id="hrep-tab" data-bs-toggle="pill" data-bs-target="#hrep-border" type="button" role="tab" aria-controls="tab-hrep-border" aria-selected="true">
                        HREP
                    </button>
                </li>
            </ul>
            <div class="tab-content mb-3 relative border-0">
                <div class="tab-pane fade show active" id="osec-border" role="tabpanel" aria-labelledby="tab-osec-border-tab" tabindex="0">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="bi-geo-alt-fill"></i>
                            </span>
                            <p class="px-3">Room G-101-D, Mabini Hall, Malacanang Complex, San Miguel, Manila</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-phone"></i>
                            </span>
                            <p class="px-3">8736-1116 | 8736-1152 | 0917-12356789</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-envelope"></i>
                            </span>
                            <p class="px-3">pllo.osec@pllo.gov.ph <br /> info@pllo.gov.ph</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="senate-border" role="tabpanel" aria-labelledby="tab-senate-border-tab" tabindex="0">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="bi-geo-alt-fill"></i>
                            </span>
                            <p class="px-3">Room G-302-A, Mabini Hall, Malacanang Complex, San Miguel, Manila</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-phone"></i>
                            </span>
                            <p class="px-3">8886-1116 | 8886-1152 | 8886-12356789</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-envelope"></i>
                            </span>
                            <p class="px-3">pllo.senate@pllo.gov.ph <br /> senate@pllo.gov.ph</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="hrep-border" role="tabpanel" aria-labelledby="tab-hrep-border-tab" tabindex="0">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="bi-geo-alt-fill"></i>
                            </span>
                            <p class="px-3">Room A-505-B, Mabini Hall, Malacanang Complex, San Miguel, Manila</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-phone"></i>
                            </span>
                            <p class="px-3">9997-1116 | 9997-1152 | 9997-12356789</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <span class="shadow icon-contact-style">
                                <i class="icon-envelope"></i>
                            </span>
                            <p class="px-3">pllo.hrep@pllo.gov.ph <br /> hrep@pllo.gov.ph</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">

            @if(session()->has('success'))
                <div class="style-msg successmsg">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('success') }}</div>
                    {{-- <button type="button" class="btn-close btn-sm" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                </div>
            @endif
            
            @if(session()->has('error'))
                <div class="style-msg successmsg">
                    <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('error') }}</div>
                    {{-- <button type="button" class="btn-close btn-sm" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                </div>
            @endif

            <p>The purpose of the Contact Us page is to allow users to reach out for assistance or inquiries, and it is important that all information is entered accurately to ensure a prompt and effective response.</p>
            <br />

            <div class="form-style fs-sm">
                <form id="contactUsForm" action="{{ route('contact-us') }}" method="POST">
                    @csrf
                    <div class="form-group">

                        <input type="text" id="fullName" class="form-control form-input" name="name" placeholder="Full Name" />
                    </div>

                    <div class="form-group">
                        <input type="email" id="emailAddress" class="form-control form-input" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email Address" />
                    </div>
                    <div class="form-group">
                        <input type="number" id="contactNumber" class="form-control form-input" name="contact" placeholder="Contact Number" />
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="message" class="form-control form-input textarea" rows="5" placeholder="Enter your message"></textarea>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <!-- <a class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" href="javascript:void(0)" onclick="document.getElementById('contactUsForm').submit()">Submit</a> -->
                            <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d m-0 custom-primary-bg" href="javascript:void(0)" onclick="document.getElementById('contactUsForm').submit()">
                                <i class="bi-send" style="margin-right: 5px;"></i> Send Message
                            </button>
                        </div>
                        {{-- <div class="col-md-6">
                            <!-- <a href="javascript:void(0)" class="button button-circle button-dark border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" onclick="resetForm();">Reset</a> -->
                            <button name="reset" type="reset" id="reset-button" tabindex="5" class="button button-3d m-0 reset-button" href="javascript:void(0)" onclick="resetForm();">

                                <i class="bi-arrow-counterclockwise" style="margin-right: 5px;"></i>Reset
                            </button>
                        </div> --}}
                    </div>
                    
                    {{-- hidden inputs --}}
                    <div class="form-group" style="display:none;">
                        <input type="text" id="services" class="form-control form-input" name="services" placeholder="Enter Subject" value="Design" required/>
                        <input type="text" id="subject" class="form-control form-input" name="subject" placeholder="Enter Subject" value="Design" required/>
                    </div>

                </form>
                {{-- captcha script --}}
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>

        </div>
    </div>
    <br />
    <br />
    <br />
    <div class="row">
        <div class="col-lg-12 contact-map-container">
            {!! $page->contents !!}
        </div>

    </div>
    
    <!-- <div class="row contact-details">
        <div class="col-lg-4 my-2">
            <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon">
                    <a href="#"><i class="uil uil-map-marker"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>Main Office
                        <span class="subtitle">
                            Rm. 301, 3rd Floor, Right Wing, Electoral Tribunal Building
                            Commonwealth Avenue, Quezon City
                        </span>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 my-2">
            <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-telephone"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>Speak to Us
                        <span class="subtitle">(+632) 931 7642</span>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 my-2">
            <div class="feature-box fbox-center fbox-bg fbox-plain">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-envelope"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>Email Us
                        <span class="subtitle">isjrms@hret.gov.ph</span>
                    </h3>
                </div>
            </div>
        </div>
    </div> -->

</div>
@endsection

@section('pagejs')
<script>

    /** form validations **/
    $(document).ready(function () {
        //called when key is pressed in textbox
        $("#contact").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            var charCode = (e.which) ? e.which : event.keyCode
            if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;

        });
    });

    // $('#contactUsForm').submit(function (evt) {
    //     let recaptcha = $("#g-recaptcha-response").val();
    //     if (recaptcha === "") {
    //         evt.preventDefault();
    //         $('#catpchaError').show();
    //         return false;
    //     }
    // });
    
    function resetForm() {
        document.getElementById("contactUsForm").reset();
    }
</script>
@endsection
