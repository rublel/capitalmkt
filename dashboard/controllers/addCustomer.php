<?php

require('../../database/database.php');

$dbs = Databases::connect();
$db = Database::connect();
$id = $_POST['id'];
$nom = $_POST['nom'];  
$activite = $_POST['activite'];
$dpt = $_POST['dpt'];
$montant = $_POST['montant'] . " €";
$proprietaire = $_POST['proprietaire'];
$paiement = $_POST['paiement'];
$actions = "Création";
$date_actions = $_POST['date_actions'];     

if($paiement === 'CB') {
    $statement = $dbs->prepare('INSERT INTO clients2022 (id,nom,activite,proprietaire,prix,departement,paiement,actions,date_actions,status_presta) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute(array($id,$nom,$activite,$proprietaire,$montant,$dpt,$paiement,$actions,$date_actions,"client")); 

    $cb = $dbs->prepare('INSERT INTO paiement_cb_2022 (id,nom,activite,departement,montant,mois1,mois2,mois3,mois4,mois5,mois6,mois7,mois8,mois9,mois10,mois11,mois12) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $cb->execute(array($id,$nom,$activite,substr($dpt, 0, 2),intval($montant), "A payer", "A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer")); 
    /*
    $statement = $db->prepare("UPDATE prestataire set status_presta = ? WHERE id = $id");
    $statement->execute(array($status_presta));
    */

} elseif($paiement === 'facture') {
    $statement = $dbs->prepare('INSERT INTO clients2022 (id,nom,activite,proprietaire,prix,departement,paiement,actions,date_actions,status_presta) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute(array($id,$nom,$activite,$proprietaire,$montant,$dpt,$paiement,$actions,$date_actions,"client")); 

    $cb = $dbs->prepare('INSERT INTO paiement_facture_2022 (id,nom,activite,departement,montant,mois1,mois2,mois3,mois4,mois5,mois6,mois7,mois8,mois9,mois10,mois11,mois12) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $cb->execute(array($id,$nom,$activite,substr($dpt, 0, 2),intval($montant), "A payer", "A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer","A payer")); 

    /*
    $statement = $db->prepare("UPDATE prestataire set status_presta = ? WHERE id = $id");
    $statement->execute(array($status_presta));
    */
    
} else {
    $statement = $dbs->prepare('INSERT INTO clients2022 (id,nom,activite,proprietaire,prix,departement,paiement,actions,date_actions) values(?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute(array($id,$nom,$activite,$proprietaire,$montant,$dpt,$paiement,$actions,$date_actions)); 
}