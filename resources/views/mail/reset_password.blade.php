<h1>Mde/M {{ $name }} veuillez reinitialiser votre mot de passe!</h1>

<p>
    Voulez-vous changer votre mot de passe.
    Si vous n'êtes pas a l'origine de cette action signale-le pour la sécurité de votre compte
    <br>Si vous êtes a l'origine de cette action, cliquez sur ce lien pour reinitialiser votre mot de passe<br>
    <a href="{{ route('app_changer_password', ['token' => $activation_token]) }}" target="blank">Renitialiser votre mot de passe</a>
</p>

<p>
    Mics_laravel Groupe Sécurité 
</p>