@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Employers / Companies</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Internship Platform</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employers</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>

    <!-- Employers Section -->
    <section class="section">
        <div class="container">
            <div class="row g-4 gy-5">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/spotify.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Spotify</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>Australia</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/facebook-logo.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Facebook</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>USA</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/google-logo.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Google</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>China</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/android.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Android</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>Dubai</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <!-- Repeat for more companies... (similar structure) -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/lenovo-logo.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Lenovo</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>Pakistan</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/shree-logo.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Shreethemes</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>India</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/skype.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Skype</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>Rush</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="employer-card position-relative bg-white rounded shadow p-4 mt-3">
                        <div class="employer-img d-flex justify-content-center align-items-center bg-white shadow-md rounded shadow">
                            <img src="{{ asset('images/company/snapchat.png') }}" class="avatar avatar-ex-small" alt="">
                        </div>
                        <div class="content mt-3">
                            <a href="#" class="title text-dark h5">Snapchat</a>
                            <p class="text-muted mt-2 mb-0">Digital Marketing Solutions for Tomorrow</p>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center border-top mt-3 pt-3 mb-0">
                            <li class="text-muted d-inline-flex align-items-center"><i data-feather="map-pin" class="fea icon-sm me-1 align-middle"></i>Turkey</li>
                            <li class="list-inline-item text-primary fw-medium">6 Jobs</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-4 pt-2">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="mdi mdi-chevron-left fs-6"></i></span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true"><i class="mdi mdi-chevron-right fs-6"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection