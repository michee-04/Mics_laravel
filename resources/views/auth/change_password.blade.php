@extends('Mic')

@section('title', "Changement du ot de passe")

@section('contenu')

    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Changez de mot de passe</h1>
                <p class="text-center text-muted mb-5">S'il vous plaît veuillez entrez votre nouveau mot de passe</p>

                <form method="POST" action="{{ route('app_changer_password', ['token' => $activation_token]) }}">

                    @csrf

                    {{-- Les messages d'alerte --}}
                    @include('alertes.alert_message')

                    <label for="new-password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="new-password" id="new-password" class="form-control mb-3 @error('password-error') is-invalid @enderror @error('passwoord-success') is-valid @enderror" placeholder="Entrez le nouveau mot de passe" value="@if (Session::has('old-new-password')) {{ Session::get('old-new-password') }} @endif">


                    <label for="new-password-confirm" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="new-password-confirm" id="new-password-confirm" class="form-control mb-3 @error('password-error-confirm') is-invalid @enderror" placeholder="Confirmer le nouveau mot de passe" value="@if (Session::has('old-new_password_confirm')) {{ Session::get('old-new_password_confirm') }} @endif">

                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Nouveau mot de passe</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection