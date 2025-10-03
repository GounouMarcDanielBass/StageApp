<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use App\Models\Stage;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques avec mise en cache pour 1 heure
        $stats = Cache::remember('home_stats', 3600, function () {
            return [
                'total_offers' => Offre::where('status', 'active')->count(),
                'total_companies' => Entreprise::count(),
                'total_students' => User::where('role', 'etudiant')->count(),
                'total_internships' => Stage::where('status', 'completed')->count()
            ];
        });

        // Récupérer les offres récentes actives
        $recentOffers = Offre::with('entreprise')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($offre) {
                return [
                    'id' => $offre->id,
                    'title' => $offre->titre,
                    'company' => $offre->entreprise->nom,
                    'location' => $offre->lieu,
                    'type' => $offre->type,
                    'duration' => $offre->duree,
                    'created_at' => $offre->created_at->diffForHumans(),
                    'logo' => $offre->entreprise->logo ?? 'images/company-default.png'
                ];
            });

        // Récupérer les domaines distincts depuis les offres
        $domains = Cache::remember('domains', 3600, function () {
            return Offre::distinct('type')
                ->pluck('type')
                ->filter()
                ->values()
                ->toArray();
        });

        // Récupérer les entreprises partenaires
        $partners = Cache::remember('partners', 3600, function () {
            return Entreprise::where('is_partner', true)
                ->select('id', 'nom', 'logo')
                ->take(8)
                ->get();
        });

        return view('home', compact('stats', 'recentOffers', 'domains', 'partners'));
    }
}