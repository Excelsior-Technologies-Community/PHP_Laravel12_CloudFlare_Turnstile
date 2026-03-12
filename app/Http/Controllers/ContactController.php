<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Contact;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'cf-turnstile-response' => 'required|string',
        ]);

        // Verify Turnstile token
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!isset($result['success']) || $result['success'] !== true) {
            return back()->withErrors(['captcha' => 'Turnstile validation failed.']);
        }

        // Save to database
        Contact::create($request->only('name', 'email', 'message'));

        return back()->with('success', 'Form submitted successfully!');
    }
}