<?php 
require('../../database/database.php');
require('../functions/functions.php');

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
$table = "paiement_facture_".$time;
$dbs = Databases::connect();
$statements = $dbs->query("SELECT * FROM $table ORDER BY id");
?> 
<style>
    .list-actions-rows i {
        width: 20px;
    }
</style>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-dark text-center">
        <span class="location-reload text-white" id="factures">FACTURES</span><br>
        <span class="changeYear mr-4" id="<?= $before ?>" data-page="facture">
            <i class="fas fa-angle-double-left"></i>
        </span>
        <?= $time ?>
        <span class="changeYear ml-4" id="<?= $after ?>" data-page="facture">
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
            <?php for($i = 1; $i < 13; $i++) { 
                ($i >= 10 ? $i = $i : $i = "0". $i);
                ?>
                <th class="text-center"><?= utf8_encode(substr(ucfirst(strftime("%B", strtotime($i."/22"))), 0, 3)); ?></th>
            <?php } ?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($q = $statements->fetch()) { ?>
            <tr class="cb-isPaid" data-price="<?= $q['montant'] ?>" data-id="<?= $q['id'] ?>">
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
            $total_1 += ($q['mois1'] == 'Payé')*$q['montant'];
            $total_2 += ($q['mois2'] == 'Payé')*$q['montant'];
            $total_3 += ($q['mois3'] == 'Payé')*$q['montant'];
            $total_4 += ($q['mois4'] == 'Payé')*$q['montant'];
            $total_5 += ($q['mois5'] == 'Payé')*$q['montant'];
            $total_6 += ($q['mois6'] == 'Payé')*$q['montant'];
            $total_7 += ($q['mois7'] == 'Payé')*$q['montant'];
            $total_8 += ($q['mois8'] == 'Payé')*$q['montant'];
            $total_9 += ($q['mois9'] == 'Payé')*$q['montant'];
            $total_10 += ($q['mois10'] == 'Payé')*$q['montant'];
            $total_11 += ($q['mois11'] == 'Payé')*$q['montant'];
            $total_12 += ($q['mois12'] == 'Payé')*$q['montant'];
        } ?>
    </tbody>
    <tr class="bg-secondary">
        <td colspan="4" class="text-white" style="text-align: left; padding: inherit 30px;">TOTAL :</td>
        <?php
        $array = [$total_1, $total_2, $total_3, $total_4, $total_5, $total_6, $total_7, $total_8, $total_9, $total_10, $total_11,$total_12];
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


<script>
</script>
