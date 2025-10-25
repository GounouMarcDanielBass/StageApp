<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function signup()
    {
        return view('signup');
    }

    public function adminDashboard()
    {
        return view('admin-dashboard');
    }

    public function companyDashboard()
    {
        return view('company-dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function encadrantDashboard()
    {
        return view('encadrant-dashboard');
    }

    public function offresStage()
    {
        return view('offres-stage');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function faq()
    {
        return view('faq');
    }

    public function services()
    {
        return view('services');
    }

    public function blogs()
    {
        return view('blogs');
    }

    public function blogDetail()
    {
        return view('blog-detail');
    }

    public function helpcenterOverview()
    {
        return view('helpcenter-overview');
    }

    public function helpcenterFaqs()
    {
        return view('helpcenter-faqs');
    }

    public function helpcenterGuides()
    {
        return view('helpcenter-guides');
    }

    public function helpcenterSupport()
    {
        return view('helpcenter-support');
    }

    public function employers()
    {
        return view('employers');
    }

    public function candidates()
    {
        return view('candidates');
    }
}
