<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
/Get pour afficher la page
/POST our envoyer des requêtes 
/On utilise le LoginController pour ne pas surcharger le code 
|
*/


// Définition d'une fonction d'un controlleur groupé
Route::controller(HomeController::class)->group(function(){
        Route::get('/', 'home')->name('app_home');
        Route::get('/about', 'about')->name('app_about');
                // middleware est utilisé pour que si l'user n'est pas connecté il n'aura ppas accès a la page dashboard cela est gere manuellement par moi
                // si l'user est connecté, il ne pourra pas acceder a la page Login et register et cela est gére automatiquement par fortify
        Route::match(['get', 'post'], '/dashboard', 'dashboard')
                ->middleware('auth')
                ->name('app_dashboard');
        
});


Route::controller(LoginController::class)->group(function(){
        
        Route::get('/logout', 'logout')->name('app_logout');

        // Chemin de vérification de l'email
        Route::post('/exist_email', 'existEmail')
                ->name('app_exist_email');

        // on passe une variable dans l'url en utilisant les acolades {token} 
        Route::match(['get', 'post'], '/activation_code/{token}', 'activationcode')
                ->name('app_activation_code');

        // Route pour vérifier si l'utilisateur à activer son comppte
        Route::get('/user_checker', 'userChecker')
                ->name('app_user_checker');

        // Route poour le revoie du code d'activation
        Route::get('/renvoie_activation_code/{token}', 'renvoieActivationCode')
                ->name('app_renvoie_activation_code');

        // Route pour l'activation du code par le lien d'activation
        Route::get('/activation_account_link/{token}', 'activationAccountLink')
                ->name('app_activation_account_link');

        // Route pour la modification de l'email
        Route::match(['get', 'post'], '/changer_email/{token}', 'changementEmail')
                ->name('app_changer_email');

        // Route pour l'oubli du mot de passe
        Route::match(['get', 'post'], '/oubli_pasword', 'oubliPassword')
                ->name('app_oubli_pasword');
});