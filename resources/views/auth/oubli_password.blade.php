@extends('Mic')

@section('title', 'Oublie du mot de passe')

@section('contenu')

    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Mot de passe oublié</h1>
                <p class="text-center text-muted mb-5">S'il vous plaît entrez votre adresse email. Nous allons vous envoyez un lien pour rénitialiser votre mot de passe</p>

                <form method="POST" action="{{ route('app_oubli_pasword') }}">

                    @csrf

                    {{-- Les messages d'alerte --}}
                    @include('alertes.alert_message')

                    <label for="email-send" class="form-label">Email:</label>
                    <input type="email" name="email-send" id="email-send" class="form-control @error('email-error') is-invalid @enderror" value="@if(Session::has('old_email')) {{ Session::get('old_email') }} @endif" placeholder="Entrez votre adresse email" required>

                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Rénitialisation</button>
                    </div>

                    <p class="text-center text-muted mt-3">Revenir a la page <a href="{{ route('login') }}">Login</a></p>

                </form>


            </div>
        </div>
    </div>

@endsection