<?php 

require('../../ProjetProxi/phpmailer/class.phpmailer.php');
require('../functions/mailerMaj.php');

if(!empty($_POST)) {
    extract($_POST);
    if($mois === "Total") {
        $str = "d'un total de ";
    } else {
        $str = "du " . $mois . " de "; 
    }
    $message = "Bonjour, <br>veuillez nous recontacter au 01.77.47.38.84 afin de régulariser l'impayé ". $str . number_format($prix, 2, ".", " ") . "€.<br>";
    $message .= "Cordialement. <br>Mr Dahan -  L'équipe Proxi Groupe";
    send_maj ($email,"Partenaire Proxi Groupe","Impayé - Demande de contact",$message,"Proxi Groupe - Comptabilité");
}