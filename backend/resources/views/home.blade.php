@extends('layouts.app')

@section('content')
        <!-- Hero Start -->
        <section class="bg-half-170 d-table w-100 bg-primary">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <div class="title-heading">
                            <h1 class="heading text-white fw-bold">Find Your Next <br> Internship Opportunity</h1>
                            <p class="para-desc text-white-50 mb-0">Explore thousands of internship opportunities from top companies. Get your own personalized career path.</p>

                            <div class="text-center subscribe-form mt-4">
                                <form style="max-width: 800px;">
                                    <div class="mb-0">
                                        <div class="position-relative">
                                            <i data-feather="search" class="fea icon-20 position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                                            <input type="text" id="help" name="name" class="shadow rounded-pill bg-white ps-5" required="" placeholder="Search internships & companies ...">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-pills">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-md-6">
                        <div class="position-relative ms-lg-5">
                            <img src="{{ asset('images/hero1.png') }}" class="img-fluid p-5" alt="Internship Hero">

                            <div class="spinner">
                                <div class="position-absolute top-0 start-0 mt-lg-5 mt-4 ms-lg-5 ms-4">
                                    <img src="{{ asset('images/company/circle-logo.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute top-0 start-50 translate-middle-x">
                                    <img src="{{ asset('images/company/facebook-logo.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute top-0 end-0 mt-lg-5 mt-4 me-lg-5 me-4">
                                    <img src="{{ asset('images/company/google-logo.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute top-50 start-0 translate-middle-y">
                                    <img src="{{ asset('images/company/lenovo-logo.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute top-50 end-0 translate-middle-y">
                                    <img src="{{ asset('images/company/android.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute bottom-0 start-0 mb-lg-5 mb-4 ms-lg-5 ms-4">
                                    <img src="{{ asset('images/company/linkedin.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute bottom-0 start-50 translate-middle-x">
                                    <img src="{{ asset('images/company/skype.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                                <div class="position-absolute bottom-0 end-0 mb-lg-5 mb-4 me-lg-5 me-4">
                                    <img src="{{ asset('images/company/snapchat.png') }}" class="avatar avatar-md-sm rounded shadow p-2 bg-white" alt="">
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Start -->
        <section class="section">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 col-md-6 mb-5">
                        <div class="about-left">
                            <div class="position-relative shadow rounded img-one">
                                <img src="{{ asset('images/about/ab01.jpg') }}" class="img-fluid rounded" alt="internship-image">
                            </div>

                            <div class="img-two shadow rounded p-2 bg-white">
                                <img src="{{ asset('images/about/ab02.jpg') }}" class="img-fluid rounded" alt="internship-image">

                                <div class="position-absolute top-0 start-50 translate-middle">
                                    <a href="#!" data-type="youtube" data-id="yba7hPeTSjk" class="avatar avatar-md-md rounded-pill shadow card d-flex justify-content-center align-items-center lightbox">
                                        <i class="mdi mdi-play mdi-24px text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-6 col-md-6">
                        <div class="section-title ms-lg-5">
                            <h4 class="title mb-3">Millions of Internships. <br> Find the one that's right for you.</h4>
                            <p class="text-muted para-desc mb-0">Search all the open internship positions. Get your own personalized career estimate. Read reviews on over 30000+ companies worldwide.</p>

                            <ul class="list-unstyled text-muted mb-0 mt-3">
                                <li class="mb-1"><span class="text-primary h5 me-2"><i class="mdi mdi-check-circle-outline align-middle"></i></span>Digital Career Solutions for Tomorrow</li>
                                <li class="mb-1"><span class="text-primary h5 me-2"><i class="mdi mdi-check-circle-outline align-middle"></i></span>Our Talented & Experienced Internship Platform</li>
                                <li class="mb-1"><span class="text-primary h5 me-2"><i class="mdi mdi-check-circle-outline align-middle"></i></span>Create your own profile to match your skills</li>
                            </ul>

                            <div class="mt-4">
                                <a href="{{ url('/about') }}" class="btn btn-primary">About Us <i class="mdi mdi-arrow-right align-middle"></i></a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row justify-content-center mb-4 pb-2">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h4 class="title mb-3">Popular Categories</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Search all the open internship positions. Get your own personalized career estimate. Read reviews on over 30000+ companies worldwide.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="tiny-five-item">
                            <div class="tiny-slide">
                                <div class="position-relative job-category text-center px-4 py-5 rounded shadow m-2">
                                    <div class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <i data-feather="airplay" class="fea icon-ex-md"></i>
                                    </div>

                                    <div class="mt-4">
                                        <a href="#" class="title h5 text-dark">Business <br> Development</a>
                                        <p class="text-muted mb-0 mt-3">74 Internships</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="tiny-slide">
                                <div class="position-relative job-category text-center px-4 py-5 rounded shadow m-2">
                                    <div class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <i data-feather="award" class="fea icon-ex-md"></i>
                                    </div>

                                    <div class="mt-4">
                                        <a href="#" class="title h5 text-dark">Marketing & <br> Communication</a>
                                        <p class="text-muted mb-0 mt-3">20 Internships</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="tiny-slide">
                                <div class="position-relative job-category text-center px-4 py-5 rounded shadow m-2">
                                    <div class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <i data-feather="at-sign" class="fea icon-ex-md"></i>
                                    </div>

                                    <div class="mt-4">
                                        <a href="#" class="title h5 text-dark">Project <br> Management</a>
                                        <p class="text-muted mb-0 mt-3">35 Internships</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="tiny-slide">
                                <div class="position-relative job-category text-center px-4 py-5 rounded shadow m-2">
                                    <div class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <i data-feather="codesandbox" class="fea icon-ex-md"></i>
                                    </div>

                                    <div class="mt-4">
                                        <a href="#" class="title h5 text-dark">Customer <br> Service</a>
                                        <p class="text-muted mb-0 mt-3">46 Internships</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="tiny-slide">
                                <div class="position-relative job-category text-center px-4 py-5 rounded shadow m-2">
                                    <div class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <i data-feather="chrome" class="fea icon-ex-md"></i>
                                    </div>

                                    <div class="mt-4">
                                        <a href="#" class="title h5 text-dark">Software <br> Engineering</a>
                                        <p class="text-muted mb-0 mt-3">60 Internships</p>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div>
                    </div>
                </div>
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row align-items-end mb-4 pb-2">
                    <div class="col-lg-6 col-md-9">
                        <div class="section-title text-md-start text-center">
                            <h4 class="title mb-3">Explore Internships</h4>
                            <p class="text-muted para-desc mb-0">Search all the open internship positions. Get your own personalized career estimate. Read reviews on over 30000+ companies worldwide.</p>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-6 col-md-3 d-none d-md-block">
                        <div class="text-md-end">
                            <a href="{{ route('offres-stage') }}" class="btn btn-link primary text-muted">See More Internships <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row g-4 mt-0">
                    @foreach($recentOffers as $offer)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="job-post rounded shadow p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/company/facebook-logo.png') }}" class="avatar avatar-small rounded shadow p-3 bg-white" alt="">

                                        <div class="ms-3">
                                            <a href="#" class="h5 company text-dark">{{ $offer['company'] }}</a>
                                            <span class="text-muted d-flex align-items-center small mt-2"><i data-feather="clock" class="fea icon-sm me-1"></i> 2 days ago</span>
                                        </div>
                                    </div>

                                    <span class="badge bg-soft-primary">Full Time</span>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('offres.show', $offer['id']) }}" class="text-dark title h5">{{ $offer['title'] }}</a>

                                    <span class="text-muted d-flex align-items-center mt-2"><i data-feather="map-pin" class="fea icon-sm me-1"></i>{{ $offer['location'] }}</span>

                                    <div class="progress-box mt-3">
                                        <div class="progress mb-2">
                                            <div class="progress-bar position-relative bg-primary" style="width:50%;"></div>
                                        </div>

                                        <span class="text-dark">20 applied of <span class="text-muted">40 vacancy</span></span>
                                    </div>
                                </div>
                            </div><!--end job post-->
                        </div><!--end col-->
                    @endforeach

                    <div class="col-12 d-md-none d-block">
                        <div class="text-center">
                            <a href="{{ route('offres-stage') }}" class="btn btn-link primary text-muted">See More Internships <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
@endsection