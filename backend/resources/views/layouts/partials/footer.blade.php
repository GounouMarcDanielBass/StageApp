<!-- Footer Start -->
<footer class="footer footer-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-60">
                    <div class="row">
                        <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                            <a href="#" class="logo-footer">
                                <img src="{{ asset('images/logo-dark.png') }}" height="24" alt="">
                            </a>
                            <p class="mt-4">Plateforme de gestion des stages permettant de faciliter le processus de recherche, de candidature et de suivi des stages pour les étudiants, entreprises et encadrants.</p>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Navigation</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li><a href="{{ route('home') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> Accueil</a></li>
                                <li><a href="{{ route('offres') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> Offres de Stages</a></li>
                                <li><a href="{{ route('about') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> À propos</a></li>
                                <li><a href="{{ route('contact') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> Contact</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Liens utiles</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li><a href="{{ route('terms') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> Conditions d'utilisation</a></li>
                                <li><a href="{{ route('privacy') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> Politique de confidentialité</a></li>
                                <li><a href="{{ route('faq') }}" class="text-foot"><i class="mdi mdi-chevron-right me-1"></i> FAQ</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <h5 class="footer-head">Contact</h5>
                            <ul class="list-unstyled footer-list mt-4">
                                <li class="d-flex align-items-center">
                                    <i data-feather="mail" class="fea icon-sm text-foot align-middle me-2"></i>
                                    <a href="mailto:contact@example.com" class="text-foot">contact@example.com</a>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i data-feather="phone" class="fea icon-sm text-foot align-middle me-2"></i>
                                    <a href="tel:+152534-468-854" class="text-foot">+152 534-468-854</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-py-30 footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-start">
                        <p class="mb-0">© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
                    </div>
                </div>

                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <ul class="list-unstyled social-icon foot-social-icon text-sm-end mb-0">
                        <li class="list-inline-item"><a href="#" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->