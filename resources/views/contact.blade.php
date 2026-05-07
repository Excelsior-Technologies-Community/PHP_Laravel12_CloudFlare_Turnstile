<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Form</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container{
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            flex-wrap: wrap;
        }

        .left{
            flex: 1;
            background: linear-gradient(135deg, #4338ca, #7e22ce);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left h1{
            font-size: 45px;
            margin-bottom: 20px;
        }

        .left p{
            font-size: 18px;
            line-height: 1.7;
            color: #ddd;
        }

        .features{
            margin-top: 30px;
        }

        .features div{
            margin-bottom: 15px;
            font-size: 17px;
        }

        .right{
            flex: 1;
            padding: 50px;
        }

        .right h2{
            text-align: center;
            font-size: 35px;
            margin-bottom: 10px;
            color: #333;
        }

        .right p{
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .form-group{
            margin-bottom: 20px;
        }

        label{
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input,
        textarea{
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
        }

        input:focus,
        textarea:focus{
            border-color: #4f46e5;
        }

        textarea{
            resize: none;
        }

        .btn{
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover{
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .view-btn{
            display: block;
            text-align: center;
            background: #111827;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
        }

        .view-btn:hover{
            background: #000;
        }

        .success{
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #86efac;
        }

        .error{
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #fca5a5;
        }

        ul{
            margin-left: 20px;
        }

        @media(max-width: 768px){

            .container{
                flex-direction: column;
            }

            .left,
            .right{
                padding: 30px;
            }

            .left h1{
                font-size: 35px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- Left Side -->
    <div class="left">

        <h1>
            Contact Us
        </h1>

        <p>
            Secure contact form built with Laravel 12 and simple CSS design.
        </p>

        <div class="features">

            <div>✔ Responsive Design</div>

            <div>✔ Form Validation</div>

            <div>✔ Success Alerts</div>

            <div>✔ Contact Management</div>

        </div>

    </div>

    <!-- Right Side -->
    <div class="right">

        <h2>
            Get In Touch
        </h2>

        <p>
            Fill out the form below.
        </p>

        {{-- Success Message --}}
        @if(session('success'))

            <div class="success">

                {{ session('success') }}

            </div>

        @endif

        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="error">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- Form -->
        <form
            action="{{ route('contact.submit') }}"
            method="POST">

            @csrf

            <!-- Name -->
            <div class="form-group">

                <label>
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name">

            </div>

            <!-- Email -->
            <div class="form-group">

                <label>
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address">

            </div>

            <!-- Message -->
            <div class="form-group">

                <label>
                    Message
                </label>

                <textarea
                    name="message"
                    rows="5"
                    placeholder="Write your message...">{{ old('message') }}</textarea>

            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="btn">

                Send Message

            </button>

            <!-- View Messages -->
            <a
                href="{{ route('contacts.index') }}"
                class="view-btn">

                View Submitted Messages

            </a>

        </form>

    </div>

</div>

</body>
</html>