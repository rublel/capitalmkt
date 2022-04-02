<?php

require('../../database/database.php');

$dbs = Databases::connect();

$id = $_POST['id'];


$statement = $dbs->prepare("UPDATE facture set facture.status = ? WHERE id = '$id'") ;
$statement->execute(array("done"));