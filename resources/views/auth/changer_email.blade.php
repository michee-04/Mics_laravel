@extends('Mic')

@section('title', "Changement de l'adresse email")

@section('contenu')

    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h2 class="text-center text-muted mb-3 mt-5">Changement de l'adresse email</h2>

                {{-- Les messages d'alerte --}}
                @include('alertes.alert_message')


                <form action="{{ route('app_changer_email', ['token' => $token]) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="new-email" class="form-label">Nouveau adresse email</label>
                        <input type="email" name="new-email" id="new-email" class="form-control @if (Session::has('danger')) is-invalid @endif" value="@if (Session::has('new_email')) {{ Session::get('new_email') }} @endif" placeholder="Entrez le nouveau adresse email" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Changer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection