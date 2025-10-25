@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-half-170 d-table w-100" style="background: url(" {{ asset('images/hero/bg.jpg') }}");">
    <div class="bg-overlay bg-gradient-overlay"></div>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-12">
                <div class="title-heading text-center">
                    <h5 class="heading fw-semibold mb-0 sub-heading text-white title-dark">Hello! <br> How can we help
                        you?</h5>
                </div>

                <div class="subscribe-form mt-4">
                    <form class="mx-auto" action="{{ url('/') }}">
                        <div class="position-relative">
                            <i data-feather="search"
                                class="fea icon-20 position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                            <input type="text" id="help" name="name" class="shadow rounded-pill bg-white ps-5"
                                required="" placeholder="Search jobs & candidates ...">
                        </div>
                        <button type="submit" class="btn btn-primary btn-pills">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="position-middle-bottom">
            <nav aria-label="breadcrumb" class="d-block">
                <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Internship Platform</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Help Center</li>
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

<!-- Help Center Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title text-center mb-4 pb-2">
                    <h4 class="mb-4 title">Find the help you need</h4>
                    <p class="para-desc mx-auto text-muted">We are a huge marketplace dedicated to connecting great
                        artists of all Internship Platform with their fans and unique token collectors!</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4 mt-4 pt-2">
                <div class="position-relative features text-center mx-lg-4 px-md-1">
                    <div
                        class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                        <i data-feather="help-circle" class="fea icon-ex-md"></i>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('helpcenter.faqs') }}" class="title h5 text-dark">FAQs</a>
                        <p class="text-muted mt-3 mb-0">The phrasal sequence of the is now so that many campaign and
                            benefit</p>
                        <div class="mt-3">
                            <a href="{{ route('helpcenter.faqs') }}" class="btn btn-link primary text-primary">Read More
                                <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4 pt-2">
                <div class="position-relative features text-center mx-lg-4 px-md-1">
                    <div
                        class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                        <i data-feather="bookmark" class="fea icon-ex-md"></i>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('helpcenter.guides') }}" class="title h5 text-dark">Guides / Support</a>
                        <p class="text-muted mt-3 mb-0">The phrasal sequence of the is now so that many campaign and
                            benefit</p>
                        <div class="mt-3">
                            <a href="{{ route('helpcenter.guides') }}" class="btn btn-link primary text-primary">Read
                                More <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4 pt-2">
                <div class="position-relative features text-center mx-lg-4 px-md-1">
                    <div
                        class="feature-icon bg-soft-primary rounded shadow mx-auto position-relative overflow-hidden d-flex justify-content-center align-items-center">
                        <i data-feather="settings" class="fea icon-ex-md"></i>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('helpcenter.support') }}" class="title h5 text-dark">Support Request</a>
                        <p class="text-muted mt-3 mb-0">The phrasal sequence of the is now so that many campaign and
                            benefit</p>
                        <div class="mt-3">
                            <a href="{{ route('helpcenter.support') }}" class="btn btn-link primary text-primary">Read
                                More <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-60">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-4 pb-2">
                        <h4 class="mb-4">Get Started</h4>
                        <p class="para-desc mx-auto text-muted">We are a huge marketplace dedicated to connecting great
                            artists of all Internship Platform with their fans and unique token collectors!</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 mt-4 pt-2">
                    <div class="accordion" id="buyingquestion">
                        <div class="accordion-item rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-0 bg-light" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    How does it work?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse border-0 collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#buyingquestion">
                                <div class="accordion-body text-muted">
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded mt-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Do I need a designer to use Internship Platform?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingTwo" data-bs-parent="#buyingquestion">
                                <div class="accordion-body text-muted">
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded mt-2">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    What do I need to do to start selling?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingThree" data-bs-parent="#buyingquestion">
                                <div class="accordion-body text-muted">
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded mt-2">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    What happens when I receive an order?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingFour" data-bs-parent="#buyingquestion">
                                <div class="accordion-body text-muted">
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection