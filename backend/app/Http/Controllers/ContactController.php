<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Créer un nouveau message
        $message = Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread'
        ]);

        // Envoyer un email de notification
        try {
            Mail::send('emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'content' => $request->message
            ], function($mail) use ($request) {
                $mail->to(config('mail.admin_email', 'admin@gestionstages.fr'));
                $mail->subject('Nouveau message de contact - ' . $request->subject);
            });
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas bloquer la réponse
            \Log::error('Erreur lors de l\'envoi de l\'email de contact : ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Message envoyé avec succès',
            'data' => $message
        ], 201);
    }
}