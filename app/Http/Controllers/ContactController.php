<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Contact;

class ContactController extends Controller
{
    // Show Contact Form
    public function showForm()
    {
        return view('contact');
    }

    // Submit Contact Form
    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Turnstile Verification (Optional for Localhost)
        |--------------------------------------------------------------------------
        */

        if ($request->filled('cf-turnstile-response')) {

            $response = Http::asForm()->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => env('TURNSTILE_SECRET'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]
            );

            $result = $response->json();

            if (!isset($result['success']) || $result['success'] !== true) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'captcha' => 'Captcha verification failed. Please try again.',
                    ]);
            }
        }

        // Save Contact
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with(
            'success',
            'Your message has been submitted successfully!'
        );
    }

    // Contact List
    public function index(Request $request)
    {
        $search = $request->search;

        $contacts = Contact::when($search, function ($query) use ($search) {

            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('message', 'LIKE', "%{$search}%");
        })
            ->oldest()
            ->paginate(5);

        return view('contacts.index', compact('contacts'));
    }

    // Delete Contact
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with(
            'success',
            'Contact deleted successfully!'
        );
    }
}