
<?php
setlocale(LC_TIME, 'fr', 'fr_FR');
require('../functions/functions.php');
require('../../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    extract($_POST);
    $statement = $dbs->query("SELECT * FROM presence WHERE id = '$id'");
    while($q = $statement->fetch()) {
        echo $total = $q['total'] - 1;
        $pause = $dbs->prepare("UPDATE presence set total = ?, pause = ? WHERE id = '$id'") ;
        $pause->execute(array($total, "true"));
    }
}

?>