<?php

require('../../database/database.php');
require('../functions/functions.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);
    $monthCl = "m". $month;
    $clients = $dbs->prepare("UPDATE clients2022 set $monthCl = ? WHERE id = '$id'") ;
    $clients->execute(array($confirm . " €"));
echo $table;
    (substr($month, 0, 1) === "0" ? $monthCb = "mois".substr($month, 1, 1) : $monthCb = "mois".$month);
    $cb = $dbs->prepare("UPDATE $table set $monthCb = ? WHERE id = '$id'") ;
    $cb->execute(array("Payé"));
}