<?php
setlocale(LC_TIME, 'fr', 'fr_FR');
require('../functions/functions.php');
require('../../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);

   
    $heureDeb = substr($str, 0, 2);
    $heureFin = substr($end, 0, 2);
    $minDeb = substr($str, 3, 2);
    $minFin = substr($end, 3, 2);
    $total = round(((($heureFin*60)+$minFin)-(($heureDeb*60)+$minDeb))/60, 2);
}
$time = $dbs->prepare("UPDATE presence set debut = ?, fin = ?, total = ?, pause = ? WHERE id = $id") ;
$time->execute(array($str,$end,$total, ""));
?>  