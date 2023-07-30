/**
 *
 * script pour la verification des enregistrements des utilisateurs 
 * 
 */

$('#user').click(function(){
    var nom = $('#nom').val()
    var prenom = $('#prenom').val()
    var email = $('#email').val()
    var password = $('#password').val()
    var password_c = $('#password_c').val()
    var pass_l = password.length
    var accepter = $('#accepter')

    // Vérification du nom
    if (nom != "" && /^[a-zA-Z ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/.test(nom)){
        $('#nom').removeClass('is-invalid');
        $('#nom').addClass('is-valid');
        $('#e-nom').text("");

        // Vérification du prenom
        if (prenom != "" && /^[a-zA-Z ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/.test(prenom)){
            $('#prenom').removeClass('is-invalid');
            $('#prenom').addClass('is-valid');
            $('#e-prenom').text("");
    
            // Vérification de l'email
            if (email != "" && /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email)){
                $('#email').removeClass('is-invalid');
                $('#email').addClass('is-valid');
                $('#e-email').text("");
        
                // Vérification du mot de passe que sa aatteint au moin 8 caractères
                if (pass_l >= 8){
                    $('#password').removeClass('is-invalid');
                    $('#password').addClass('is-valid');
                    $('#e-password').text("");
                    
                    //Confirmation du mot de passe
                    if (password == password_c){
                        $('#password_c').removeClass('is-invalid');
                        $('#password_c').addClass('is-valid');
                        $('#e-confirm').text("");
                        
                        // Vérification si la politique de confidentialité est acceppter
                        if (accepter.is(':checked')){
                            $('#accepter').removeClass('is-invalid');
                            $('#e-accepter').text("");
                            
                            // Vérification si l'email(condition ternaire) saisi existe déjà dans la base de donné e di sa n'existe pas alors envoi du formulaire 
                           var res = emailExistjs(email);
                            (res != "exist") ? $('#form-r').submit() 
                                        :   ($('#email').addClass('is-invalid'),
                                            $('#email').removeClass('is-valid'),
                                            $('#e-email').text("Lemail saisi est déjà utilisé"));


                        // Quand la politique de confidentialité n'est ppas accepter
                        }else{
                            $('#accepter').addClass('is-invalid');
                            $('#e-accepter').text("Vous devez accepter la politique de confidentialiité");
                        }

                    // Le mot de passe confirmé n'est pas égale au mot de passe
                    }else{
                        $('#password_c').addClass('is-invalid');
                        $('#password_c').removeClass('is-valid');
                        $('#e-confirm').text("Mot de passe non identique");
                    }

                // SLe mot de passe n'atteint pas 8 caractères
                }else{
                    $('#password').addClass('is-invalid');
                    $('#password').removeClass('is-valid');
                    $('#e-password').text("Mot de passe incorrect");
                }


            // Email incorrecte
            }else{
                $('#email').addClass('is-invalid');
                $('#email').removeClass('is-valid');
                $('#e-email').text("Email incorrect");
            }

        // Prénom incorrecte
        }else{
            $('#prenom').addClass('is-invalid');
            $('#prenom').removeClass('is-valid');
            $('#e-prenom').text("Prénom incorrect");
        }

    // Nom incorrecete
    }else{
        $('#nom').addClass('is-invalid');
        $('#nom').removeClass('is-valid');
        $('#e-nom').text("Nom incorrect");
    }

})


// Evenement pour la politique de confidentialité
$('#accepter').change(function(){

    var accepter = $('#accepter');

    // Vérification si la politique de confidentialité est acceppter
    if (accepter.is(':checked')){
        $('#accepter').removeClass('is-invalid');
        $('#e-accepter').text("");
        
        // Envoie du formulaire

    // Quand la politique de confidentialité n'est ppas accepter
    }else{
        $('#accepter').addClass('is-invalid');
        $('#e-accepter').text("Vous devez accepter la politique de confidentialiité");
    }

})

// création de fonction pour récuper la route
function emailExistjs(email) {
    // Récupération du contenu se trouvant dans l'attribut url-emailExist à partir de l'id
    var url = $('#email').attr('url-emailExist');
    var token = $('#email').attr('token');
    var res = "";

    // Envoi des données par l'url
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
            email: email
        },

        success:function(result){
            res = result.response;
            // result.response   response est la valeur récupere dans LoginController dans 'response' = $response
        }, async:false
    })
    
    return res;

}