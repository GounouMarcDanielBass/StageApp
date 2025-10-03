<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Document;

class StudentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $applications = Application::where('user_id', $user->id)->with('offer.company')->get();
        $documents = Document::where('user_id', $user->id)->get();

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'applications' => $applications,
            'documents' => $documents,
        ]);
    }
}