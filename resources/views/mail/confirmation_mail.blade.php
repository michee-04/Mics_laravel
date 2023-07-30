<h1>Mde/M {{ $name }} veuillez confirmer votre email!</h1>

<p>
    Veuillez activer votre compte par copie et coller l'activation du code. 
    <br> Code d'activation : {{ $activation_code }}. <br>
    Ou cliquez sur le lien d'activation : <br>
    <a href="{{ route('app_activation_account_link', ['token' => $activation_token]) }}" target="blank">Confirmer votre compte</a>
</p>

<p>
    Groupe Mics_laravel
</p>