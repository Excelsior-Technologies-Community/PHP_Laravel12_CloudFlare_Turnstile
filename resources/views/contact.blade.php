<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        :root {
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --left-bg: linear-gradient(135deg, #4338ca, #7e22ce);
            --right-text: #333;
            --input-bg: #ffffff;
            --input-border: #ccc;
            --input-focus: #4f46e5;
            --label-color: #444;
            --sub-text: #777;
            --btn-bg: linear-gradient(135deg, #4f46e5, #9333ea);
            --view-btn-bg: #111827;
            --view-btn-hover: #000000;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --success-border: #86efac;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
            --error-border: #fca5a5;
            --toggle-bg: #e2e8f0;
            --toggle-thumb: #4f46e5;
        }
        [data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --left-bg: linear-gradient(135deg, #1e1b4b, #4c1d95);
            --right-text: #e2e8f0;
            --input-bg: #334155;
            --input-border: #475569;
            --input-focus: #818cf8;
            --label-color: #cbd5e1;
            --sub-text: #94a3b8;
            --btn-bg: linear-gradient(135deg, #4f46e5, #9333ea);
            --view-btn-bg: #334155;
            --view-btn-hover: #475569;
            --success-bg: #14532d;
            --success-text: #dcfce7;
            --success-border: #22c55e;
            --error-bg: #450a0a;
            --error-text: #fecaca;
            --error-border: #ef4444;
            --toggle-bg: #334155;
            --toggle-thumb: #818cf8;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }
        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: background 0.3s;
        }
        .theme-toggle {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 999;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card-bg);
            border: 1px solid var(--input-border);
            border-radius: 30px;
            padding: 8px 14px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: background 0.3s, border 0.3s;
        }
        .theme-toggle span { font-size: 18px; }
        .theme-label { font-size: 13px; color: var(--label-color); font-weight: bold; }
        .container {
            width: 100%;
            max-width: 1000px;
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            flex-wrap: wrap;
            transition: background 0.3s;
        }
        .left {
            flex: 1;
            background: var(--left-bg);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .left h1 { font-size: 45px; margin-bottom: 20px; }
        .left p { font-size: 18px; line-height: 1.7; color: #ddd; }
        .features { margin-top: 30px; }
        .features div { margin-bottom: 15px; font-size: 17px; }
        .right { flex: 1; padding: 50px; background: var(--card-bg); transition: background 0.3s; }
        .right h2 { text-align: center; font-size: 35px; margin-bottom: 10px; color: var(--right-text); }
        .right > p { text-align: center; color: var(--sub-text); margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: var(--label-color); }
        input, textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--input-border);
            border-radius: 10px;
            outline: none;
            font-size: 16px;
            background: var(--input-bg);
            color: var(--right-text);
            transition: border 0.3s, background 0.3s;
        }
        input:focus, textarea:focus { border-color: var(--input-focus); }
        textarea { resize: none; }
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: var(--btn-bg);
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .view-btn {
            display: block;
            text-align: center;
            background: var(--view-btn-bg);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .view-btn:hover { background: var(--view-btn-hover); }
        .success {
            background: var(--success-bg);
            color: var(--success-text);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid var(--success-border);
        }
        .error {
            background: var(--error-bg);
            color: var(--error-text);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid var(--error-border);
        }
        ul { margin-left: 20px; }
        @media(max-width: 768px) {
            .container { flex-direction: column; }
            .left, .right { padding: 30px; }
            .left h1 { font-size: 35px; }
        }
    </style>
</head>
<body>

<button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle dark mode">
    <span id="theme-icon">🌙</span>
    <span class="theme-label" id="theme-label">Dark</span>
</button>

<div class="container">
    <div class="left">
        <h1>Contact Us</h1>
        <p>Secure contact form built with Laravel 12 and simple CSS design.</p>
        <div class="features">
            <div>✔ Responsive Design</div>
            <div>✔ Form Validation</div>
            <div>✔ Success Alerts</div>
            <div>✔ Contact Management</div>
        </div>
    </div>
    <div class="right">
        <h2>Get In Touch</h2>
        <p>Fill out the form below.</p>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" placeholder="Write your message...">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
            <a href="{{ route('contacts.index') }}" class="view-btn">View Submitted Messages</a>
        </form>
    </div>
</div>

<script>
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const icon = document.getElementById('theme-icon');
        const label = document.getElementById('theme-label');
        if (theme === 'dark') {
            icon.textContent = '☀️';
            label.textContent = 'Light';
        } else {
            icon.textContent = '🌙';
            label.textContent = 'Dark';
        }
        localStorage.setItem('theme', theme);
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }

    const saved = localStorage.getItem('theme') || 'light';
    applyTheme(saved);
</script>
</body>
</html>