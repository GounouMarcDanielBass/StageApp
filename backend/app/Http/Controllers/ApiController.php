<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Stage;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Retrieve the latest internship offers.
     */
    public function latestOffers()
    {
        $offers = Offer::latest()->take(3)->get();
        return response()->json($offers);
    }

    /**
     * Retrieve platform statistics.
     */
    public function stats()
    {
        $stats = [
            'entreprises' => Entreprise::count(),
            'etudiants' => Etudiant::count(),
            'stages' => Stage::where('status', 'completed')->count(), // Assuming 'completed' status
        ];
        return response()->json($stats);
    }

    /**
     * Retrieve testimonials.
     * For now, returns a static list.
     */
    public function testimonials()
    {
        $testimonials = [
            [
                'name' => 'Julie Martin',
                'quote' => 'Une super plateforme, j\'ai trouvé mon stage en 2 semaines !',
                'image' => 'https://randomuser.me/api/portraits/women/65.jpg'
            ],
            [
                'name' => 'Marc Dubois',
                'quote' => 'Le processus de recrutement est très simple pour les entreprises.',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg'
            ],
            [
                'name' => 'Carole Durand',
                'quote' => 'Enfin un outil efficace pour gérer les stages de nos étudiants.',
                'image' => 'https://randomuser.me/api/portraits/women/44.jpg'
            ]
        ];
        return response()->json($testimonials);
    }
}
