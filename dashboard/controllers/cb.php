<?php
require('../../database/database.php');
require('../functions/functions.php');
require('../classes/class.php');
$dbs = Databases::connect();
setlocale(LC_TIME, 'fr', 'fr_FR'); 
if(!empty($_POST)) {
    $time = $_POST['time'];
} elseif(!empty($_GET)) {
    $time = $_GET['y'];
} else {
    $time = date('Y');
}
$before = $time - 1;
$after = $time + 1;
$table = "paiement_cb_".$time;
$statements = $dbs->query("SELECT * FROM $table ORDER BY id");
$getItem = new ItemFormat();
?>
<style>
    .list-actions-rows i {
        width: 20px;
    }
</style>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-dark text-center">
        <span class="location-reload text-white" id="cb">CARTE-BLEUE</span><br>
        <span class="changeYear mr-4" id="<?= $before ?>" data-page="cb">
            <i class="fas fa-angle-double-left"></i>
        </span>
        <?= $time ?>
        <span class="changeYear ml-4" id="<?= $after ?>" data-page="cb">
            <i class="fas fa-angle-double-right"></i>
        </span>
    </div>
    <div class="card-body">
    <table class="table table-striped">
    <thead class="bg-warning">
        <tr>
            <th>ID</th>
            <th>Raison sociale</th>
            <th>Activite</th>
            <th class="text-center">Montant</th>
            <?= $getItem->getTH(); ?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($q = $statements->fetch()) { ?>
            <tr class="cb-isPaid payment-row" data-price="<?= $q['montant'] ?>" data-id="<?= $q['id'] ?>">
                <td class="border-end">#<?= $q['id'] ?></td>
                <td><?= ucwords(strtolower(utf8_encode($q['nom']))) ?></td>
                <td><?= $q['activite'] ?></td>
                <td class="text-center"><?= $q['montant'] . ",00 €" ?></td>
                <?php for($i = 1; $i < 13; $i++) { 
                    ($i >= 10 ? $s = $i : $s = "0". $i);
                ?>
                    <td class="text-center"><?= isPaid($q["mois".$i], $s, $q['year']) ?></td>
                <?php } ?>  
                <td class="text-center border-start list-actions-rows">
                    <i class="fas fa-info-circle view-data text-secondary" data-id="<?= $q['id'] ?>" data-montant="<?= $q['montant'] ?>"></i>  
                    <i class="fas fa-trash delete-data text-secondary" data-year=<?= $q['year'] ?>></i>  
                </td>
            </tr>
        <?php
            $total1 += ($q['mois1'] == 'Payé')*$q['montant'];
            $total2 += ($q['mois2'] == 'Payé')*$q['montant'];
            $total3 += ($q['mois3'] == 'Payé')*$q['montant'];
            $total4 += ($q['mois4'] == 'Payé')*$q['montant'];
            $total5 += ($q['mois5'] == 'Payé')*$q['montant'];
            $total6 += ($q['mois6'] == 'Payé')*$q['montant'];
            $total7 += ($q['mois7'] == 'Payé')*$q['montant'];
            $total8 += ($q['mois8'] == 'Payé')*$q['montant'];
            $total9 += ($q['mois9'] == 'Payé')*$q['montant'];
            $total10 += ($q['mois10'] == 'Payé')*$q['montant'];
            $total11 += ($q['mois11'] == 'Payé')*$q['montant'];
            $total12 += ($q['mois12'] == 'Payé')*$q['montant'];
        } ?>
    </tbody>
    <tr class="bg-secondary">
        <td colspan="4" class="text-white" style="text-align: left; padding: inherit 30px;">TOTAL :</td>
        <?php
        $array = [$total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8, $total9, $total10, $total11,$total12];
        foreach($array as $a) { ?>
                <td class="text-white"><?= number_format($a, 2, '.', '') . " €"?></td>
        <?php } ?>
            <td></td>
        </tr>
    </tr>
</table>
    </div>
</div>
<style>
    .cb-isPaid .fa-check {
        color: green;
    }
    .cb-isPaid .fa-times {
        color: red;
    }
</style>