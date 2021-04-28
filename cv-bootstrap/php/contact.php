<?php 

    //Au départ les valeurs des champs sont initialisées avec des string vides
    $array = [
        "firstname" => "",
        "name" => "",
        "email" => "",
        "phone" => "",
        "message" => "",
        "firstnameError" => "",
        "nameError" => "",
        "emailError" => "",
        "phoneError" => "",
        "messageError" => "",
        "isSuccess" => false
    ];
       
    //On définit l'envoi d'email
    $emailTo = "vbouvarel@lilo.org";

    //Fonction de vérification du champ email 
        function isEmail($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
    //Fonction de vérification du champ phone    
        function isPhone($phone){
            return preg_match("/^[0-9 ]*$/", $phone);
        }
    //Fonction pour sécuriser tous les champs saisis par l'utilisateur
        function verifyInput($data){
            $data = trim($data);//Enleve les espaces
            $data = stripSlashes($data);//Enleve les antislashs
            $data = htmlspecialchars($data);//Traduit les éventuels scripts en balises html
            return $data;
        }


    /*1/Traitement du formulaire reçu depuis la requête Ajax*/ 
    //SI le formulaire a déjà été soumis (= si on arrive sur le formulaire depuis une requête post), 
        //on préremplit les champs
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $array["firstname"] = verifyInput($_POST["firstname"]);
                $array["name"] = verifyInput($_POST["name"]);
                $array["email"] = verifyInput($_POST["email"]);
                $array["phone"] = verifyInput($_POST["phone"]);
                $array["message"] = verifyInput($_POST["message"]);

                //On indique que le formulaire a été envoyé avec succés (tous les champs sont valides)
                $array["isSuccess"] = true;

                //On initialise la variable qui contiendra le corps du mail
                $emailText = "";

                //On gère les messages d'erreur en cas de champs invalides (et on construit le mail au fur et à mesure)
                if(empty($array["firstname"])){
                    $array["firstnameError"] = "Merci de renseigner un prénom";
                    $array["isSuccess"] = false; //Formulaire non valide puisque'il y a une erreur sur ce champ
                }else{
                    $emailText .= "FirstName: {$array['firstname']}\n";
                }

                if(empty($array["name"])){
                    $array["nameError"] = "Merci de renseigner un nom";
                    $array["isSuccess"] = false;
                }else{
                    $emailText .= "Name: {$array['name']}\n";
                }

                if(!isEmail($array["email"])){
                    $array["emailError"] = "Merci de renseigner un mail valide";
                    $array["isSuccess"] = false;
                }else{
                    $emailText .= "Email: {$array['email']}\n";
                }

                if(!isPhone($array["phone"])){
                    $array["phoneError"] = "Seulement des chiffres et des espaces";
                    $array["isSuccess"] = false;
                }else{
                    $emailText .= "Phone: {$array['phone']}\n";
                }

                if(empty($array["message"])){
                    $array["messageError"] = "Merci de laisser un message";
                    $array["isSuccess"] = false;
                }else{
                    $emailText .= "Message: {$array['message']}\n";
                }

                if($array["isSuccess"]){
                    $headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\r\nReply-To: {$array['email']}";
                    mail($emailTo, "Contact depuis le portfolio", $emailText, $headers);
                }

                /*2/A la fin, renvoi vers Ajax du formulaire traité par PHP*/ 
                //On met les données au format json
                    echo json_encode($array);
            }
            

?>
