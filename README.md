# PHP_Laravel12_CloudFlare_Turnstile

## Introduction

`PHP_Laravel12_CloudFlare_Turnstile` is a simple Laravel 12 project that demonstrates how to integrate **Cloudflare Turnstile** into a web form for bot protection.

Cloudflare Turnstile is a modern CAPTCHA alternative that protects forms from automated bots without negatively impacting user experience. Unlike traditional CAPTCHA systems, Turnstile works silently in the background and provides a more privacy-friendly solution.

This project shows how to implement Turnstile validation in a Laravel application while securely processing form submissions and storing data in a database.

---

## Project Overview

This project demonstrates the complete integration of **Cloudflare Turnstile with Laravel 12** using a contact form example.

The application allows users to submit a contact form that is protected by Cloudflare Turnstile to prevent spam and automated bot submissions. When the form is submitted, Laravel verifies the Turnstile token using Cloudflare's verification API before saving the data into the database.

The project covers:

- Laravel 12 project setup
- Installing and configuring the Cloudflare Turnstile package
- Creating a contact form with a modern UI
- Implementing server-side Turnstile verification
- Storing form submissions in the database
- Displaying success and validation messages

This project can be used as a reference for developers who want to implement **secure form validation using Cloudflare Turnstile in Laravel applications**.

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_CloudFlare_Turnstile "12.*"
cd PHP_Laravel12_CloudFlare_Turnstile
```

---

## Step 2: Install Cloudflare Turnstile Package

```bash
composer require ryangjchandler/laravel-cloudflare-turnstile
```

---

## Step 3: Get Cloudflare Turnstile Site & Secret Keys

1) Go to the Cloudflare Turnstile Dashboard:

- [Cloudflare Turnstile Dashboard](https://dash.cloudflare.com/turnstile)

2) Login to your Cloudflare account.

3) From the left sidebar navigate to:

```
Application Security → Turnstile
```

4) Click Add Widget.

5) Enter your Domain Name (for local development you can use localhost).

6) Choose the Widget Mode (Managed / Invisible / Non-interactive).

7) Click Create.

8) After creating the widget, Cloudflare will provide:

- Site Key (Used in frontend)

- Secret Key (Used in backend validation)

Copy both keys and add them to your Laravel .env file

---

## Step 4: Configure .env

Update .env

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cloudflare_turnstile_db
DB_USERNAME=root
DB_PASSWORD=
```

Add your Cloudflare Turnstile keys:

```.env
TURNSTILE_SITEKEY=your_site_key_here
TURNSTILE_SECRET=your_secret_key_here
```

---

## Step 5: Create Model and Migration

```bash
php artisan make:model Contact -m
```

### Migration Table

database/migrations/xxxx_xx_xx_create_contacts_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
```

Run the migration:

```bash
php artisan migrate
```

### Model

app/Models/Contact.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message'];
}
```

---

## Step 6: Create Controller

```bash
php artisan make:controller ContactController
```

app/Http/Controllers/ContactController.php 

```php
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
```

---

## Step 7: Define Routes

routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

Route::get('/', function () {
    return view('welcome');
});
```

---

## Step 8: Create Blade View

resources/views/contact.blade.php

```blade
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Form | Cloudflare Turnstile</title>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Turnstile -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</head>

<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg bg-white shadow-2xl rounded-xl p-8">

    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">
        Contact Us
    </h1>

    <p class="text-center text-gray-500 mb-6">
        Secure form protected by Cloudflare Turnstile
    </p>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">

        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Name
            </label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                placeholder="Enter your name"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Email
            </label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                placeholder="Enter your email"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Message
            </label>
            <textarea
                name="message"
                rows="4"
                required
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                placeholder="Write your message..."
            >{{ old('message') }}</textarea>
        </div>

        <!-- Cloudflare Turnstile -->
        <div class="flex justify-center pt-2">
            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITEKEY') }}"></div>
        </div>

        <button
            type="submit"
            class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition duration-200"
        >
            Send Message
        </button>

    </form>

</div>

</body>
</html>
```

---

## Step 9: Run Laravel Server

```bash
php artisan serve
```
Visit: 

```bash
http://localhost:8000/contact
```

- Fill the form

- Complete the Turnstile verification

- Click Send Message

- If verification succeeds, the form data will be stored in the database and a success message will appear.

---

## Output

<img width="1919" height="1028" alt="Screenshot 2026-03-12 104707" src="https://github.com/user-attachments/assets/1ef4e1e8-47f8-4ba0-90a2-87848d7f287a" />

<img width="1919" height="1031" alt="Screenshot 2026-03-12 104735" src="https://github.com/user-attachments/assets/bcf0e910-4b8e-4e42-b727-f91c653a98c7" />

---

## Project Structure

```
PHP_Laravel12_CloudFlare_Turnstile/
├── app/
│   ├── Http/Controllers/ContactController.php
│   └── Models/Contact.php
├── database/migrations/
│   └── xxxx_xx_xx_create_contacts_table.php
├── resources/views/contact.blade.php
├── routes/web.php
├── .env
├── composer.json
└── README.md
```

---

Your PHP_Laravel12_CloudFlare_Turnstile Project is now ready!
