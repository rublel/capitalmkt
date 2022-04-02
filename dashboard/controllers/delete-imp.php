<?php
require('../../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);
    $impayesStatement = $dbs->prepare("UPDATE clients2022 set impaye = ?, actions = ?, date_actions = ?, status = ? WHERE id = $id") ;
    $impayesStatement->execute(array('false','Annulation', date('m'), ''));
}
