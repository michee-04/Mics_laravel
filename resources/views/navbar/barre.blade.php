

<nav class="navbar navbar-expand-lg bg-body-tertiary">

    <div class="container">
      <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link @if (Request::route()->getName() == 'app_home') active  @endif " aria-current="page" href="{{ route('app_home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (Request::route()->getName() == 'app_about') active  @endif" href="{{ route('app_about') }}">About</a>
          </li>
        </li>
        </ul>
      </div>

      <div class="btn-group">
        @guest
          <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Mon compte
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
          </ul>
        @endguest

        @auth
          <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{-- Affiche le nom de l'utilisateur --}}
            {{ Auth::user()->name }}
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('app_logout') }}">Logout</a></li>
          </ul>
        @endauth

      </div>
    </div>
  </nav>