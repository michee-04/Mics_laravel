<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\services\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    // création d'un controlleur qui va gardé toutes les valeurs
    protected $request;

    function __construct(Request $request)
    {
        $this -> request = $request; 
    }

    // Fonction permettant de se déconnecter 
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Vérification de l'email saisi si c'est déja utilisé
    public function existEmail()
    {
        // La valeur de l'input sera récupere par $email
        $email = $this->request->input('email');
        $user = User::where('email', $email)
            ->first();
        $ressponse = "";
        ($user) ? $response = "exist" : $response = "not_exist";

        return response()->jsson([
            'response'=> $response,
        ]);
        
    }

    //fonction pour l'activation de compte 
    public function activationcode($token)
    {

        $user = user::where('activation_token', $token)->first();

        // Condition permettant de verifier si le token n'est pas été changé par l'utilisateur et si c'est le cas le renvoie a la page de login
        if(!$user)
        {
            return redirect()->route('login')->with('danger', "Ce token ne correspond a aucun utilisateur");
        }
        // Activation du compte
        if($this->request->isMethod('post'))
        {
            $code = $user -> activation_code;            
            $activation_code = $this->request->input('activation-code');
            /**
             * Comparaison du code de saisi par l'utilisateur et le code de la base de données et s'il sont les mêmes alors le compte sera activée et la modification de certains champs 
             * Sinon affiche un message d'eerreur qui va montré que le code saisi n'est pas correcte et revenir a la page précedent 
             */

             if($activation_code != $code)
             {
                return back()->with([
                    'danger'=> "Le code d'activation est invalide",
                    'activation_code' => $activation_code
                ]);
             }else
             {
                DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'is_verified' => 1,
                            'activation_code' => "",
                            'activation_token' => "",
                            'email_verified_at' => new \DateTimeImmutable,
                            'updated_at' => new \DateTimeImmutable
                        ]);
                        
                        // Rédirection de l'utilisateur vers la page Login
                        return redirect()->route('login')->with('success', "Votre addresse email a été bien vérifié");
             }

        }
        // retourner a la page de la vue de activation_code
        return view('auth.activation_code', [
            'token' => $token
        ]);
    }

    
    /**
     * verifie si l'utilisateur a déjà activé son compte ou
     * pas avant d''être authentifié
     */
       public function userChecker()
       {
           $activation_token = Auth::user()->activation_token;
           $is_verified = Auth::user()->is_verified;

           if($is_verified != 1)
           {
                // Si l'utilisateur n'est pas activé son compte déconnecter le et renvoi le a la page activation_code
                Auth::logout();
                return redirect()->route('app_activation_code', ['token' => $activation_token])
                                ->with('warning', "Votre compte n'est pas encore activé, Veuillez vérifier votre boite de réception
                                        pour activer votre compte ou renvoyez le message de confirmation");
           }else
           {
                return redirect()->route('app_dashboard');
           }
       }

         //    Foncttion pour le renvoie du code d'activation
         public function renvoieActivationCode($token)
         {
            $user = user::where('activation_token', $token)->first();
            $email = $user->email;
            $name = $user ->name;
            $activation_token = $user->activation_token;
            $activation_code = $user->activation_code;

        
            // Réenvoie de l'email
            $emailSend = new EmailService;

            $subject = "Activer votre compte";

            $emailSend->sendEmail($subject, $email, $name, true, $activation_code, $activation_token);

            return redirect()->route('app_activation_code', 
                            ['token'=> $token])
                            ->with('success', "Le nouveau code d'activation vient d'être envoyer");
         }

        //  fonction pour l'activation du compte par le lien d'activation
        public function activationAccountLink($token)
        {
            $user = user::where('activation_token', $token)->first();
            if(!$user)
            {
                return redirect()->route('login')->with('danger', "Ce token ne correspond a aucun utilisateur");
            }else
            {
                DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'is_verified' => 1,
                            'activation_code' => "",
                            'activation_token' => "",
                            'email_verified_at' => new \DateTimeImmutable,
                            'updated_at' => new \DateTimeImmutable
                ]);

                // Rédirection de l'utilisateur vers la page Login
            return redirect()->route('login')->with('success', "Votre addresse email a été bien vérifié");
            } 
            
        }

        // fonction pour le changement de l'email
        public function changementEmail($token)
        {
            
            $user = user::where('activation_token', $token)->first();

            if($this->request->isMethod('post'))
            {
                // Récupération de l'attribut new-email
                $new_email = $this->request->input('new-email');
                
                // Vérification de l'adresse email resaisi par l'utilisateur et si cette adresse email (meme son ancienne adresse email) est déjà utlisé alors lui envoi un message qui qtimule que l'adresse email est dzjà utiisé
                $user_existe = user::where('email', $new_email)->first();
                
                if($user_existe)
                {
                    return back()->with([
                        'danger'=> "Cet adresse email est déjà utilisé par un autre utilisateur donc veuillez changer d'dresse email",
                        'new_email' => $new_email
                    ]);
                }else
                {
                    // L'ajout de la nouvelle adresse email si elle n'est pas déjà utilisé par d'autre utilisateur
                    // Où si c'est pas l'ancienne adresse email de l'utilisateur qui veut modifier son adresse email
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'email' => $new_email,
                            'updated_at' => new \DateTimeImmutable
                        ]);

                    // Renvoi du code d'activation avec la nouvelle adresse email
                    $activation_code = $user->activation_code;
                    $activation_token =$user->activation_token;
                    $name = $user->name;
                    
                    $emailSend = new EmailService;

                    $subject = "Activer votre compte";
                    

                    $emailSend->sendEmail($subject, $new_email, $name, true, $activation_code, $activation_token);

                    // Rédirection vvers la page d'activation pour activer son compte
                    return redirect()->route('app_activation_code', 
                            ['token'=> $token])
                            ->with('success', "La modification de l'adresse email a été effectuer avec succès");
                    
                }
                
            }else
            {
                return view('auth.changer_email', ['token' => $token]);
                
            }
                
        }
        
}