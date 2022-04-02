<?php

require('../../database/database.php');

function impayeJson($q) {
    $json = json_decode($q);  
    $status = $json->{'status'};
    if($status === 'impaye') {
        return true;
    } else {
        return false;
    }
}

$dbs = Databases::connect();
if(!empty($_POST)) {
$id = $_POST['id'];
$prix = $_POST['confirm'];
$mois = "m".$_POST['mois'];
$date = date('Y-m-d');
$table = "clients". $_POST['year'];
$statement = $dbs->prepare("UPDATE $table set date_creation = ?, $mois = ? WHERE id = $id");
$statement->execute(array($date,$prix . " €"));
echo "updated";
$statement = $dbs->query("SELECT * FROM $table WHERE id = $id");  
while ($q = $statement->fetch()) {
    $array = [
        impayeJson($q['m01']),
        impayeJson($q['m02']),
        impayeJson($q['m03']),
        impayeJson($q['m04']),
        impayeJson($q['m05']),
        impayeJson($q['m06']),
        impayeJson($q['m07']),
        impayeJson($q['m08']),
        impayeJson($q['m09']),
        impayeJson($q['m10']),
        impayeJson($q['m11']),
        impayeJson($q['m12'])                        
    ];
    if(!in_array(true, $array)) {
        $statement = $dbs->prepare("UPDATE $table set impaye = ? WHERE id = $id") ;
        $statement->execute(array("reglé le $date"));
    }
}
}