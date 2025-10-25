@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-half-170 d-table w-100" style="background: url('{{ asset('images/hero/bg.jpg') }}');">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="title-heading text-center">
                        <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Guides / Support</h5>
                    </div>
                </div>
            </div>

            <div class="position-middle-bottom">
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Internship Platform</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('helpcenter.overview') }}">Help Center</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Guides</li>
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

    <!-- Guides Section -->
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="mb-4 title">User Guides</h4>
                        <p class="para-desc mx-auto text-muted">Comprehensive guides to help you navigate and make the most of the Internship Platform.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>Getting Started</h5>
                            <p class="text-muted">Learn how to create your account and set up your profile.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>Applying for Internships</h5>
                            <p class="text-muted">Step-by-step guide on how to apply for internships.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>Managing Applications</h5>
                            <p class="text-muted">How to track and manage your internship applications.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>For Companies</h5>
                            <p class="text-muted">Guide for companies on posting internships and managing candidates.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>Troubleshooting</h5>
                            <p class="text-muted">Common issues and how to resolve them.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <h5>Best Practices</h5>
                            <p class="text-muted">Tips for making the most of the platform.</p>
                            <a href="#" class="btn btn-primary">Read Guide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection