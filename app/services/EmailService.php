<?php

namespace App\services;
use PHPMailer\PHPMailer\PHPMailer; 

class EmailService
{
    //  création des attributs pour récupere des valeurs
    protected $app_name;
    protected $host;
    protected $port;
    protected $username;
    protected $password;


    // fonction pour récupere les vleurs 
    function __construct()
    {
        $this->app_name = config('app.name');
        $this->host = config('app.mail_host');
        $this->port = config('app.mail_port');
        $this->username = config('app.mail_username');
        $this->password = config('app.mail_password');
    }
    
    // foncion pour l'envoi des mail
    public function sendEmail($subject, $emailUser, $nameUser, $isHtml, $activation_code, $activation_token)
    {
        // cette fonction permettra de recueillir les information qui seront envoyée a l'utilisateur (Configuration de nos mails)
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPAuth = true;
        $mail->Subject = $subject;
        $mail->setFrom($this->app_name, $this->app_name);
        $mail->addReplyTo($this->app_name, $this->app_name);
        $mail->addAddress($emailUser, $nameUser);
        $mail->isHTML($isHtml);
        $mail-> Body = $this->viewSendEmail($nameUser, $activation_code, $activation_token);
        $mail->send();
        // Pour appeler une foncion dans une autre fontion dans une même classe o fait $this->nom_fonction

    }
    

    // fonction pour la reinitialisation du mot de passe 
    public function resetPassword($subject, $emailUser, $nameUser, $isHtml, $activation_token)
    {
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPAuth = true;
        $mail->Subject = $subject;
        $mail->setFrom($this->app_name, $this->app_name);
        $mail->addReplyTo($this->app_name, $this->app_name);
        $mail->addAddress($emailUser, $nameUser);
        $mail->isHTML($isHtml);
        $mail-> Body = $this->viewResetPassword($nameUser, $activation_token);
        $mail->send();
        
    }
    // fonction pour les messages 
    public function viewSendEmail($name, $activation_code, $activation_token)
    {
        return view('mail.confirmation_mail')
                ->with([
                    'name'=> $name,
                    'activation_code'=> $activation_code,
                    'activation_token'=> $activation_token,
                ]);
    }

    // fonction qui permet d'envoyer le lien de reinitialisation
    public function viewResetPassword($name, $activation_token)
    {
        return view('mail.reset_password')
                ->with([
                    'name'=> $name,
                    'activation_token'=> $activation_token,
                ]);
    }

    
}