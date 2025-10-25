<footer class="bg-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="py-5">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <div class="text-center text-sm-start">
                                <a href="{{ url('/') }}"><img src="{{ asset('images/logo-light.png') }}" alt="Internship Platform Logo" class="h-8"></a>
                            </div>
                        </div>

                        <div class="col-sm-9 mt-4 mt-sm-0">
                            <ul class="list-unstyled footer-list terms-service text-center text-sm-end mb-0">
                                <li class="list-inline-item my-2"><a href="{{ url('/') }}" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Home</a></li>
                                <li class="list-inline-item my-2"><a href="{{ route('offres-stage') }}" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Internships</a></li>
                                <li class="list-inline-item my-2"><a href="{{ route('services') }}" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Services</a></li>
                                <li class="list-inline-item my-2"><a href="#" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> Companies</a></li>
                                <li class="list-inline-item my-2"><a href="{{ url('/about') }}" class="text-foot fs-6 fw-medium me-2"><i class="mdi mdi-circle-small"></i> About us</a></li>
                                <li class="list-inline-item my-2"><a href="{{ url('/faq') }}" class="text-foot fs-6 fw-medium"><i class="mdi mdi-circle-small"></i> FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-start">
                        <p class="mb-0 fw-medium">© <script>document.write(new Date().getFullYear())</script> Internship Platform. Design with <i class="mdi mdi-heart text-danger"></i> by Our Team.</p>
                    </div>
                </div>

                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <ul class="list-unstyled social-icon foot-social-icon text-sm-end mb-0">
                        <li class="list-inline-item"><a href="#" target="_blank" class="rounded"><i data-feather="facebook" class="fea icon-sm align-middle" title="Facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#" target="_blank" class="rounded"><i data-feather="instagram" class="fea icon-sm align-middle" title="Instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" target="_blank" class="rounded"><i data-feather="twitter" class="fea icon-sm align-middle" title="Twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#" target="_blank" class="rounded"><i data-feather="linkedin" class="fea icon-sm align-middle" title="LinkedIn"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>