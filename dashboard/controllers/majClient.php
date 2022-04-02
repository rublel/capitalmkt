<?php

require('../../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);
    for($i = 1; $i < 13; $i ++){
        ($i >= 10 ? $s = "m".$i : $s = "m0". $i);
        $actionsStatement = $dbs->prepare("UPDATE clients2022 set $s = ? WHERE id = $id") ;
        $actionsStatement->execute(array($price));
    }
}