<?php
require('../functions/functions.php');
require('../../database/database.php');
$element = $_POST['element'];
$db = Database::connect();
$dbs = Databases::connect();
$statement = $db->query("SELECT * FROM prestataire WHERE id LIKE '%$element%' OR nom LIKE '%$element%' OR mail LIKE '%$element%'");    
$isClient = false;                                     
while ($q = $statement->fetch()) { 
    if($q['status_presta'] === 'client') {
        $facture = "<i class='fas fa-file add-invoice' id=".$q['id']."></i>";
        $isClient = true;
    } else {
        $facture = "";
    }
    $idPresta = $q['id'];
    $key = "<i class='fas fa-user' style='color: ". color($q['status_presta']) ."'></i>";
    if($isClient) {
        $ref = $dbs->query("SELECT * FROM clients2022 WHERE id = $idPresta AND status_presta = 'client'");                                         
        while ($i = $ref->fetch()) { 
            if(!empty($i[0])) {
                $key = "<i class='fas fa-key'></i>";
            } 
        }
    }
    ?>
    <li>
        <?= $key ?>
        <?= ucwords(strtolower(utf8_encode($q['nom']))) ?>
        <span class="list-actions">        
            <?= $facture ?>
            <i class="far fa-plus-square <?= isClient($q['status_presta']) ?>" id=<?= $q['id'] ?>></i>
        </span>
    </li>

<?php } ?>  