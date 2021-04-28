$(function(){

    //Animation du scrollSpy
    $("#navbarToSpy .navbar a, footer a").on("click", function(event){
        event.preventDefault();
        var hash = this.hash;
        $('html, body').animate({scrollTop: $(hash).offset().top} , 900 , function(){window.location.hash = hash;})
    });

    //Animation des skills-blocks
    $("#skills, #experiences").on("mouseenter touchstart", function(){
        AOS.init();
    });

    //Gestion du formulaire de contact
    $('#contact-form').submit(function(e){
        //On empêche l'envoi du formulaire (on utilise pas l'attribut action pour envoyer le formulaire à php)
        e.preventDefault();
        //On met les messages d'erreurs à zéro par défaut
        $('.comments').empty();
        //On récupère tous les champs du formulaire dans une variable
        var postdata = $('#contact-form').serialize();

        //On envoie les données au serveur grâce à une requête Ajax
        $.ajax({
            type:'POST',
            url:'php/contact.php',
            data: postdata,
            dataType: 'json',
            success: function(result){
                //Si le traitement du formulaire est un succés
                if(result.isSuccess){
                    $('#contact-form').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                    $('#contact-form')[0].reset();
                }else{//Si il y a des erreurs
                    $('#firstname + .comments').html(result.firstnameError);
                    $('#name + .comments').html(result.nameError);
                    $('#email + .comments').html(result.emailError);
                    $('#phone + .comments').html(result.phoneError);
                    $('#message + .comments').html(result.messageError);
                }
            }
        });
    });

    
})