<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Submitted Contacts</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#0f172a;
            min-height:100vh;
            padding:40px 20px;
            color:white;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            flex-wrap:wrap;
            gap:15px;
        }

        .title-box h1{
            font-size:38px;
            font-weight:bold;
        }

        .title-box p{
            color:#cbd5e1;
            margin-top:8px;
        }

        .back-btn{
            text-decoration:none;
            background:linear-gradient(135deg,#6366f1,#8b5cf6);
            color:white;
            padding:12px 22px;
            border-radius:12px;
            font-weight:bold;
            transition:0.3s;
        }

        .back-btn:hover{
            transform:translateY(-2px);
            opacity:0.9;
        }

        .card{
            background:#1e293b;
            border-radius:20px;
            padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
            border:1px solid rgba(255,255,255,0.08);
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            flex-wrap:wrap;
            gap:15px;
        }

        .search-box{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .search-box input{
            width:280px;
            padding:14px;
            border:none;
            border-radius:12px;
            background:#334155;
            color:white;
            outline:none;
        }

        .search-box input::placeholder{
            color:#cbd5e1;
        }

        .search-box button{
            padding:14px 22px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,#3b82f6,#6366f1);
            color:white;
            cursor:pointer;
            font-weight:bold;
            transition:0.3s;
        }

        .search-box button:hover{
            transform:scale(1.04);
        }

        .success{
            background:#14532d;
            border:1px solid #22c55e;
            color:#dcfce7;
            padding:16px;
            border-radius:14px;
            margin-bottom:20px;
        }

        .table-wrapper{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:900px;
        }

        table th{
            background:#334155;
            color:white;
            padding:16px;
            text-align:left;
            font-size:15px;
        }

        table td{
            padding:18px 16px;
            border-bottom:1px solid #334155;
            color:#e2e8f0;
        }

        table tr:hover{
            background:#273449;
        }

        .id-badge{
            background:#6366f1;
            padding:6px 12px;
            border-radius:30px;
            font-size:13px;
            font-weight:bold;
            display:inline-block;
        }

        .message-box{
            max-width:300px;
            line-height:1.6;
            color:#cbd5e1;
        }

        .delete-btn{
            border:none;
            padding:10px 18px;
            border-radius:10px;
            background:linear-gradient(135deg,#ef4444,#dc2626);
            color:white;
            cursor:pointer;
            font-weight:bold;
            transition:0.3s;
        }

        .delete-btn:hover{
            transform:scale(1.05);
        }

        .empty{
            text-align:center;
            padding:30px;
            color:#cbd5e1;
        }

        .pagination{
            margin-top:35px;
            display:flex;
            justify-content:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .pagination a{
            text-decoration:none;
            padding:12px 18px;
            border-radius:10px;
            background:#334155;
            color:white;
            transition:0.3s;
        }

        .pagination a:hover{
            background:#6366f1;
        }

        .pagination span{
            padding:12px 18px;
            border-radius:10px;
            background:#6366f1;
            color:white;
            font-weight:bold;
        }

        .disabled{
            opacity:0.5;
        }

        @media(max-width:768px){

            body{
                padding:20px 12px;
            }

            .header{
                flex-direction:column;
                align-items:flex-start;
            }

            .top-bar{
                flex-direction:column;
                align-items:stretch;
            }

            .search-box{
                width:100%;
            }

            .search-box input{
                width:100%;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- Header -->
    <div class="header">

        <div class="title-box">

            <h1>
                Submitted Contacts
            </h1>

            <p>
                Manage all submitted contact messages easily
            </p>

        </div>

        <a
            href="{{ route('contact.form') }}"
            class="back-btn">

            + Back To Form

        </a>

    </div>

    <!-- Card -->
    <div class="card">

        {{-- Success Message --}}
        @if(session('success'))

            <div class="success">

                {{ session('success') }}

            </div>

        @endif

        <!-- Top Bar -->
        <div class="top-bar">

            <!-- Search -->
            <form
                action="{{ route('contacts.index') }}"
                method="GET"
                class="search-box">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name or email...">

                <button type="submit">

                    Search

                </button>

            </form>

        </div>

        <!-- Table -->
        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Message</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($contacts as $contact)

                    <tr>

                        <td>

                            <span class="id-badge">

                                #{{ $contact->id }}

                            </span>

                        </td>

                        <td>

                            {{ $contact->name }}

                        </td>

                        <td>

                            {{ $contact->email }}

                        </td>

                        <td>

                            <div class="message-box">

                                {{ $contact->message }}

                            </div>

                        </td>

                        <td>

                            <form
                                action="{{ route('contacts.destroy', $contact->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this contact?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-btn">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="empty">

                            No contacts found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        @if ($contacts->hasPages())

            <div class="pagination">

                {{-- Previous --}}
                @if ($contacts->onFirstPage())

                    <span class="disabled">

                        Prev

                    </span>

                @else

                    <a href="{{ $contacts->previousPageUrl() }}">

                        Prev

                    </a>

                @endif

                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $contacts->lastPage(); $i++)

                    @if ($i == $contacts->currentPage())

                        <span>

                            {{ $i }}

                        </span>

                    @else

                        <a href="{{ $contacts->url($i) }}">

                            {{ $i }}

                        </a>

                    @endif

                @endfor

                {{-- Next --}}
                @if ($contacts->hasMorePages())

                    <a href="{{ $contacts->nextPageUrl() }}">

                        Next

                    </a>

                @else

                    <span class="disabled">

                        Next

                    </span>

                @endif

            </div>

        @endif

    </div>

</div>

</body>
</html>