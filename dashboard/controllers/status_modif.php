<?php

require('../../database/database.php');

$dbs = Databases::connect();

$id = $_POST['id'];
$date = $_POST['date'];
$newMontant = $_POST['prix'];
$actions = $_POST['actions'];
if($actions === "Modification") {
    if($date < 10) {
        $mois = substr($date, 1, 1);
    } else {
        $mois = $date;
    }
    echo "Nouveau montant: " . $newMontant . "<br>";
    for($i = $mois; $i < 13; $i++) {
        if($i < 10) {
            $i = "0" . $i;
        }
        $mois = "m" . $i;
        $statement = $dbs->prepare("UPDATE clients2022 set prix = ?, $mois = ?, status = ? WHERE id = $id") ;
        $statement->execute(array($newMontant,$newMontant,"done"));
        echo $mois . " ";
    }
    echo "ont été modifié";
} elseif($actions === "Création") {
    if($date < 10) {
        $mois = substr($date, 1, 1);
    } else {
        $mois = $date;
    }
    echo "Nouveau montant: " . $newMontant . "<br>";
    for($i = $mois; $i < 13; $i++) {
        if($i < 10) {
            $i = "0" . $i;
        }
        $mois = "m" . $i;
        $db = Database::connect();
        $statement = $db->prepare("UPDATE prestataire set status_presta = ? WHERE id = $id");
        $statement->execute(array("client"));
        $statements = $dbs->prepare("UPDATE clients2022 set $mois = ?, status_presta = ?, status = ? WHERE id = $id") ;
        $statements->execute(array($newMontant,"client","done"));
        echo $mois . " à ete crée<br>";
    }

} elseif($actions === "rib") {

    $statement = $dbs->prepare("UPDATE clients2022 set status = ? WHERE id = $id") ;
    $statement->execute(array("done"));

} elseif($actions === "Annulation") {

    if($date < 10) {
        $mois = substr($date, 1, 1);
    } else {
        $mois = $date;
    }
    for($i = $mois; $i < 13; $i++) {
        if($i < 10) {
            $i = "0" . $i;
        }
        $mois = "m" . $i;
        $db = Database::connect();
        $statement = $db->prepare("UPDATE prestataire set status_presta = ? WHERE id = $id");
        $statement->execute(array("Ancien"));
        $statements = $dbs->prepare("UPDATE clients2022 set $mois = ?, status_presta = ?, status = ? WHERE id = $id") ;
        $statements->execute(array("Annulé","old","done"));
    }

}
