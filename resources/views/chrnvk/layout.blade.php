<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>@yield('title_name')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Home</a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">first page</a>
              </li>
            </ul>
          </div>
          <!-- <a class="btn btn-outline-primary" href="/login">Log in</a>
          <a class="btn btn-outline-warning" href="/register">Register</a> -->
          @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a class="btn btn-outline-success" href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a class="btn btn-outline-warning" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
           @endif
        </div>
    </nav>
    <div class="container">
        @yield('body_content')
    </div>
</body>
</html>