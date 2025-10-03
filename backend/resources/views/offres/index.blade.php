@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Internship Offers</h1>
    <div class="row">
        @foreach ($offres as $offre)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $offre->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $offre->entreprise->company_name }}</h6>
                    <p class="card-text">{{ Str::limit($offre->description, 100) }}</p>
                    <a href="{{ route('offres.show', $offre->id) }}" class="card-link">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection