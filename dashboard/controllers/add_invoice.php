<?php

require('../../database/database.php');
require('../../ProjetProxi/phpmailer/class.phpmailer.php');
require('../functions/mailer.php');
require('../functions/functions.php');

$dbs = Databases::connect();

$from = timeCall($_POST['from']);
$to = timeCall($_POST['to']);
$montant = $_POST['montant'];
$id = $_POST['id'];
$nom = $_POST['nom'];  
$activite = $_POST['activite'];
$dpt = $_POST['dpt'];
$contact = $_POST['email'];

$uploadDir = '../files/';
$_FILES['file']['name'];
$fileName = basename($_FILES["file"]["name"]); 
$targetFilePath = $uploadDir . $fileName; 
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'); 
if(in_array($fileType, $allowTypes)){ 
    // Upload file to the server 
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
        $uploadedFile = $fileName; 
    } else {
        echo "erreur de telechargement";
    }
} 

$message = "Raison social: $nom <br>";
$message .= "Période: " . ucwords(strtolower(utf8_encode($from)))." à ". ucwords(strtolower(utf8_encode($to)))." <br>";
$message .= "Montant: $montant euros HT<br>";
//BDD
$statement = $dbs->prepare("INSERT INTO facture (client_id,nom,contact,activite,departement,montant,de,a,file_url,file_name) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$statement->execute(array($id,$nom,$contact,$activite,$dpt,$montant,$from,$to,$targetFilePath,$fileName));
//Mail
send_mail("lzahout@gmail.com", "Facturation - Laurent Zahout", "Facture $nom", $message, $targetFilePath, $fileName);