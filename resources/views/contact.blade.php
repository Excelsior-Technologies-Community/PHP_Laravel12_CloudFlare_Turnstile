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