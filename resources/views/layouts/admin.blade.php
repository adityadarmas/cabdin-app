<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS sederhana, bisa diganti Bootstrap/Tailwind --}}
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
        }
        .container {
            display: flex;
        }
        aside {
            width: 220px;
            background: #34495e;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        aside a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        aside a:hover {
            text-decoration: underline;
        }
        main {
            flex: 1;
            padding: 20px;
            background: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        table th {
            background: #eee;
        }
    </style>
</head>
<body>

<header>
    <h2>E-Cabdin</h2>
    <h4>Selamat Datang {{ auth()->user()->name }}</h4>
</header>

<div class="container">

    @include('partials.sidebars.' . auth()->user()->role)
    

    <div class="content">
        @include('partials.alert')
        @yield('content')
    </div>
</div>

</body>
</html>
