
<?php
require('./functions/functions.php');
require('./classes/class.php');
require('../database/database.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    $activite = $_POST['activite'];
    if(!empty($_POST['prop'])) {
        $prop = $_POST['prop'];
        $propQuery = "AND proprietaire = '$prop'";
    } else {
        $prop = "David";
        $propQuery = "";
    }
} else {
    $activite = $_GET['activite'];
    $prop = "David";
    $propQuery = "";
}
$statement = $dbs->query("SELECT * FROM clients2022 WHERE activite = '$activite' $propQuery");
//Total clients
$statements = $dbs->query("SELECT COUNT(*) as total FROM clients2022 WHERE status_presta = 'client' AND activite = '$activite' $propQuery "); 
                            $result = $statements->fetch();
                            $statements->closeCursor();
                            $total = $result['total']; 
$table = new ItemFormat();
?>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header text-center bg-secondary text-white">
        <span id="activite"><?= strtoupper(str_replace("_", " ", $activite)) ?></span><?= " - (" .$total. ")" ?>
    </div>
    <div class="card-body">
    <table class="table table-striped">
    <thead class="bg-warning">
        <tr>
            <th>ID</th>
            <th>NOM</th>
            <?= $table->getTH(); ?>
            <th></th>
        </tr>
    </thead>
    <tbody id="customers2022">
        <?php
        while ($q = $statement->fetch()) { ?>
            <tr>
                <td class="border-end"><?= $q['id'] ?></td>
                <td class="nameCust"><span><?= ucwords(strtolower(utf8_encode($q['nom']))) . " (" . substr($q['departement'], 0, 2) . ")"?></span><?= payementMethod($q['paiement']) ?></td>
                <?php for($i = 1; $i < 13; $i++) { 
                    ($i >= 10 ? $s = $i : $s = "0". $i);
                ?>
                    <td class="text-center"><?= $table->displayitem($q["m".$s]) ?></td>
                <?php } ?>  
                <td class="border-start text-center">
                    <i class="fas"></i>
                    
                    <i class="fas fa-info-circle view-data text-secondary" data-id="<?= $q['id'] ?>" data-montant="<?= intVal($q['prix']) ?>"></i>  
                </td>
            </tr>
            <?php   
                $total_1 += $q['m01'];
                $total_2 += $q['m02'];
                $total_3 += $q['m03'];
                $total_4 += $q['m04'];
                $total_5 += $q['m05'];
                $total_6 += $q['m06'];
                $total_7 += $q['m07'];
                $total_8 += $q['m08']; 
                $total_9 += $q['m09'];
                $total_10 += $q['m10'];
                $total_11 += $q['m11'];
                $total_12 += $q['m12'];
            }
    ?>
    </tbody>
    <tfoot>
    <tr class="bg-secondary text-white">
        <td colspan="2">TOTAL :</td>
        <?php 
        $array = [$total_1, $total_2, $total_3, $total_4, $total_5, $total_6, $total_7, $total_8, $total_9, $total_10, $total_11,$total_12];
        foreach($array as $a) { ?>
                <td class="text-center"><?= number_format($a, 2, ',', '.') . " €"?></td>
        <?php } ?>
        <td></td>
    </tr>
    </tfoot>
</table>
</div>
<style>
    .fa-times-circle {
        color: red;
    }
    .nameCust {
        position: relative;
    }
    .nameCust i {
        position: absolute;
        right: 10px
    }
    .card-footer th {
        border: 0px !important
    }
</style>