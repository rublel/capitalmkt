<?php

require('../../database/database.php');
require('../../ProjetProxi/phpmailer/class.phpmailer.php');
require('../functions/mailerMaj.php');
require('../functions/functions.php');

$dbs = Databases::connect();
if(!empty($_POST)){
    $wlc_maj = "";
    $id = $_POST['id'];
    $impayes = "m".$_POST['impayes'];
    $actions = $_POST['sepa'];
    $date_actions = $_POST['date_actions'];
    $date = date('Y-m-d h:i:s');
    $selectmaj = $_POST['selectMaj'];
    $annulation = $_POST['annulation'];
    if(!empty($_POST['notes'])) {
        $newMontant = $_POST['notes'] . " €";
    } else {
        $newMontant = "";
    }
    
    if(!empty($_POST['impayes'])) {
        $currentMonth = $dbs->query("SELECT $impayes FROM clients2022 WHERE id = $id");
        while($row = $currentMonth->fetch()) {
            $data = array();
            $data["montant"]  = intval($row[$impayes]);
            $data["status"]  = "impaye";
            $json = json_encode($data);  
        }
        $impayesStatement = $dbs->prepare("UPDATE clients2022 set date_creation = ?, $impayes = ?, impaye = ? WHERE id = $id") ;
        $impayesStatement->execute(array($date,$json, "true"));
    }

    if(!empty($actions)) {
        $actionsStatement = $dbs->prepare("UPDATE clients2022 set date_creation = ?, actions = ?, date_actions = ?, status = ?, notes = ? WHERE id = $id") ;
        $actionsStatement->execute(array($date,$actions,$date_actions,"",$newMontant));
    }

    if(!empty($selectmaj)) {
        $nom = $_POST['nom_maj'];
        $tel = $_POST['tel_maj'];
        $activite = $_POST['activite_maj'];
        $dpt = $_POST['dpt_maj'];
        $notes_maj = $_POST['notes_maj'];
        $wlc_maj = $_POST['wlc_maj'];
        $message = "Raison sociale: " . $nom . "<br>";
        $message .= "Tel: " . telFormat($tel) . "<br>";
        $message .= "Département(s): " . $dpt . "<br>";
        $message .= "Sites: " . $wlc_maj . "<br>";
        $message .= "Notes: " . $notes_maj . "<br>";

        $statement = $dbs->prepare("INSERT INTO maj (client_id,nom,tel,activite,dpt,wlc,proxi,message) values(?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($id,$nom,$tel,$activite,$dpt,$wlc_maj,$wlc_maj,$notes_maj));

        send_maj("majproxi@gmail.com", "Laurent Zahout", "Mise à jour WLC $activite - ($dpt)", $message,"MAJ PROXI GROUPE");
    }

    if(!empty($annulation)) {
        $actionsStatement = $dbs->prepare("UPDATE clients2022 set date_creation = ?, actions = ?, date_actions = ? WHERE id = $id") ;
        $actionsStatement->execute(array($date,"Annulation",$annulation));
    }
}
