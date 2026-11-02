<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        try {
            Mail::raw(
                "New LDTECS Website Inquiry\n\n" .
                "Name: " . $validated['name'] . "\n" .
                "Email: " . $validated['email'] . "\n" .
                "Phone: " . $validated['phone'] . "\n" .
                "Message: " . $validated['message'],

                function ($mail) {
                    $mail->to(env('CONTACT_EMAIL'))
                         ->subject('New LDTECS Contact Inquiry');
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ]);

        } catch (\Throwable $e) {

            Log::error('Contact form error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Message could not be sent. Please try again.'
            ], 500);
        }
    }
}