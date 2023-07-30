@extends('Mic')

@section('title', 'Activation du compte')

@section('contenu')

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Activation du compte</h1>

                {{-- Les messages d'alerte --}}
                @include('alertes.alert_message')
                

                {{-- {{ route('app_activation_code', ['token' => $token]) }} sans l'ajout du token er du $token la page activation_code va présenter une erreur 404 --}}
                <form method="POST" action="{{ route('app_activation_code', ['token' => $token]) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="activation-code" class="form-label">Activation du code</label>
                        <input type="text" id="activation-code" name="activation-code" class="form-control @if (Session::has('danger')) is-invalid @endif" value="@if (Session::has('activation_code')) {{ Session::get('activation_code') }} @endif" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="{{ route('app_changer_email', ['token' => $token]) }}">Changé d'adresse email</a>
                        </div>
                        <div class="col-md-6 text-end">
                            {{-- Route pour le renvoie du code de l'activation --}}
                            <a href="{{ route('app_renvoie_activation_code', ['token' => $token]) }}">Renvoyez le code d'activation</a>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Activer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection