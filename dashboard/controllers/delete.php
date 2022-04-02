<?php

require('../../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);
    $clients = $dbs->prepare("DELETE FROM $table WHERE id = '$id'") ;
    $clients->execute(array($id));
}