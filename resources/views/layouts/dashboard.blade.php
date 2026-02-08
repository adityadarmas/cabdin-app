<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Dashboard Instansi</span>
    <a href="{{ route('logout') }}" class="btn btn-danger btn-sm"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
