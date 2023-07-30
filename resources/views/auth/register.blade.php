@extends('Mic')

@section('title', 'Register')

@section('contenu')

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Register</h1>
                <p class="text-center text-muted mb-5">Créer un compte si vous n'avez pas de compte</p>

                <form method="POST" action="{{ route('register') }}" class="row g-3" id="form-r">
                    {{-- @csrf permet de proteger le formulaire et si vous l'oublier, le formulaire ne sera pas acceder --}}
                    @csrf

                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                        <small class="text-danger fw-bold" id="e-nom"></small>
                    </div>

                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
                        <small class="text-danger fw-bold" id="e-prenom"></small>
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" url-emailExist="{{ route('app_exist_email') }}" token="{{ csrf_token() }}">
                        <small class="text-danger fw-bold" id="e-email"></small>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required autocomplete="password">
                        <small class="text-danger fw-bold" id="e-password"></small>
                    </div>

                    <div class="col-md-6">
                        <label for="password_cc" class="form-label">Confirmation de mot de passe</label>
                        <input type="password" class="form-control" id="password_c" name="password_c" value="{{ old('password-confirm') }}" required autocomplete="password_c">
                        <small class="text-danger fw-bold" id="e-confirm"></small>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="accepter">
                            <label class="form-check-label" for="accepter">Accepter la politique de confidentialité</label><br>
                            <small class="text-danger fw-bold" id="e-accepter"></small>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" id="user">S'inscrire</button>
                    </div>

                    <p class="text-center text-muted mt-5">Avez-vous déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>

                </form>

            </div>
        </div>
    </div>

@endsection