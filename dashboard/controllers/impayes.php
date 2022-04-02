<?php
require('../../database/database.php');
require('../functions/functions.php');
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
$table = "clients".$time;
$statement = $dbs->query("SELECT * FROM $table WHERE impaye = 'true' ORDER BY id");  
?>
<style>
    .list-actions-rows i {
        width: 20px;
    }
</style>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header text-center bg-secondary text-dark">
        <span class="location-reload text-white" id="impayes">IMPAYE</span><br>
        <span class="changeYear" id="<?= $before ?>" data-page="impayes">
            <i class="fas fa-angle-double-left"></i>
        </span>
        <?= $time ?>
        <span class="changeYear" id="<?= $after ?>" data-page="impayes">
            <i class="fas fa-angle-double-right"></i>
        </span>
    </div>
    <div class="card-body">
        <table class="table table-striped">
        <thead class="bg-warning">
            <tr>
                <th>ID</th>
                <th>Nom</th>
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
    <?php while ($q = $statement->fetch()) { ?>
        <tr> 
            <td class="border-end">#<?= $q['id'] ?></td>
            <td><?= nameFormat($q['nom']) ?></td>
            <td><?= ucfirst($q['activite']) . " - (" . $q['departement'] .")" ?></td>
            <td class="text-center"><?= $q['prix'] ?></td>
            <?php for($i = 1; $i < 13; $i++) { 
                ($i >= 10 ? $i = $i : $i = "0". $i);
            ?>
                <td class="text-center"><?= impayes($q["m".$i], $q['id'], $i, $q['year']) ?></td>
            <?php } ?>
            <td class="border-start text-center list-actions-rows">
                <i class="fas fa-info-circle view-data text-secondary" data-id="<?= $q['id'] ?>" data-montant="<?= substr($q['prix'], 0, 3) ?>"></i>  
                <i class="fas fa-envelope sendMessage text-secondary" data-year="<?= $q['year'] ?>" id="<?= $q['id'] ?>" ></i>
                <i class="fas fa-trash delete-imp text-secondary" data-id="<?= $q['id'] ?>" ></i>
            </td>
        </tr>
        <?php
            $total1 += json_decode($q['m01'])->{'montant'};
            $total2 += json_decode($q['m02'])->{'montant'};
            $total3 += json_decode($q['m03'])->{'montant'};
            $total4 += json_decode($q['m04'])->{'montant'};
            $total5 += json_decode($q['m05'])->{'montant'};
            $total6 += json_decode($q['m06'])->{'montant'};
            $total7 += json_decode($q['m07'])->{'montant'};
            $total8 += json_decode($q['m08'])->{'montant'};
            $total9 += json_decode($q['m09'])->{'montant'};
            $total10 += json_decode($q['m10'])->{'montant'};
            $total11 += json_decode($q['m11'])->{'montant'};
            $total12 += json_decode($q['m12'])->{'montant'};
        }
        ?>
        </tbody>  
        <tr class="bg-secondary">
            <td colspan="4"  class="text-white">TOTAL:</td>
        <?php 

        $array = [$total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8, $total9, $total10, $total11,$total12];
        foreach($array as $a) { ?>
                <td class="text-white"><?= number_format($a, 2, '.', '') . " €"?></td>
        <?php } ?>
            <td></td>
        </tr>
    </table>
    </div>
</div>

