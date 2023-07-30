<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\services\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        /*Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();*/

        $email = $input['email'];
        // création d'un variable pour recupere le token et le token sera génerer pour l'activation des utilisateurs
        $activation_token = md5(uniqid()) . $email . sha1($email);

        //Génerer un code de l'activation du code
        $activation_code = "";
        $length_code = 5;

        for($i=0; $i < $length_code; $i++)
        {
            // mt_rand est une fonction qui va permettre de generer 5 chiffres de nombres aléatoires de 0 à 9
            $activation_code .= mt_rand(0, 9);
        }

        $name = $input['nom'].' '.$input['prenom'];
        
        // importation de la classe EmailService
        $emailSend = new EmailService;
        $subject = "Activer votre compte";
        $emailSend->sendEmail($subject, $email, $name, true, $activation_code, $activation_token);
        
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($input['password']),
            'activation_code' => $activation_code,
            'activation_token' => $activation_token
        ]);
    }
}