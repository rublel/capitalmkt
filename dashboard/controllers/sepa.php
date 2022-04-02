<?php 
setlocale(LC_TIME, 'fr', 'fr_FR');
require('../../database/database.php');
require('../functions/functions.php');
$dbs = Databases::connect();
if(!empty($_POST)) {
    $mois = $_POST['mois'];
} elseif(!empty($_GET)) {
    $mois = $_GET['m'];
} else {
    $mois = date('m');
}
if($mois >= 9) {
    $before = $mois - 1;
    $after = $mois + 1;
} else {
    $before = "0" . ($mois - 1);
    $after = "0" . ($mois + 1);
}

$creation = $dbs->query("SELECT * FROM clients2022 WHERE paiement = 'sepa' AND actions = 'Création' AND date_actions = '$mois' ORDER BY date_creation DESC");
$modification = $dbs->query("SELECT * FROM clients2022 WHERE paiement = 'sepa' AND (actions = 'Modification' OR actions = 'rib') AND date_actions = '$mois' ORDER BY date_creation DESC");
$annulation = $dbs->query("SELECT * FROM clients2022 WHERE paiement = 'sepa' AND actions = 'Annulation' AND date_actions = '$mois'");
$moisNom = utf8_encode(ucfirst(strftime("%B", strtotime("$mois/22"))));

$creationTotal = $dbs->query("SELECT COUNT(*) as creationTotal FROM clients2022 WHERE paiement = 'sepa' AND actions = 'Création' AND date_actions = '$mois'"); 
$resultCreation = $creationTotal->fetch();
$creationTotal->closeCursor();
$totalCreation = $resultCreation['creationTotal'];

$modifTotal = $dbs->query("SELECT COUNT(*) as modifTotal FROM clients2022 WHERE 
                                                                            paiement = 'sepa' AND actions = 'Modification' AND date_actions = '$mois' OR
                                                                            paiement = 'sepa' AND actions = 'rib' AND date_actions = '$mois'                                                                            
                                                                            "); 
$resultModif = $modifTotal->fetch();
$modifTotal->closeCursor();
$totalModif = $resultModif['modifTotal'];

$annulTotal = $dbs->query("SELECT COUNT(*) as annulTotal FROM clients2022 WHERE paiement = 'sepa' AND actions = 'Annulation' AND date_actions = '$mois'"); 
$resultAnnul = $annulTotal->fetch();
$annulTotal->closeCursor();
$totalAnnul = $resultAnnul['annulTotal'];


?>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header text-center bg-secondary text-dark">
        <span class="text-white">SEPA</span><br>
        <span class="month_before mr-4" id="<?= $before ?>">
            <i class="fas fa-angle-double-left"></i>
        </span>
        <?= $moisNom ?>
        <span class="month_after ml-4" id="<?= $after ?>">
            <i class="fas fa-angle-double-right"></i>
        </span>
    </div>
    <div class="card-body">
    <div class="card bg-light mt-1 mb-3 border border-secondary displayTable">
        <div class="card-header text-center text-secondary">Création <?= ($totalCreation > 0 ? " - (" . $totalCreation . ")" : "") ?></div>
        <div class="card-body d-none">
            <table class="table table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Activité</th>
                        <th>DPT</th>
                        <th class="text-center">Montant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($q = $creation->fetch()) { ?>
                            <tr> 
                                <td class="border-end">#<?= $q['id'] ?></td>
                                <td><?= nameFormat($q['nom']) ?></td>
                                <td><?= ucwords($q['activite']) ?></td>
                                <td><?= nameFormat($q['departement']) ?></td>
                                <td class="text-center"><?= $q['prix'] ?></td>
                                <td class="text-center border-start">
                                    <i class="<?= statusModif($q['status']) ?>" id="<?= $q['id'] ?>" data-action="<?= $q['actions'] ?>" data-montant="<?= $q['prix'] ?>" data-date="<?= $q['date_actions'] ?>"></i>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card bg-light mb-3 border border-secondary displayTable">
        <div class="card-header text-center text-secondary">Modification <?= ($totalModif > 0 ? " - (" . $totalModif . ")" : "") ?></div>
        <div class="card-body d-none">
            <table class="table table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Activité</th>
                        <th>DPT</th>
                        <th>A modifier</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($q = $modification->fetch()) {
                        if($q['actions'] === 'Modification') {
                            $notes = $q['prix'] . " <i class='fas fa-exchange-alt'></i> " .$q['notes'];
                        } elseif($q['actions'] === 'rib') {
                            $notes = "<i class='fas fa-receipt'></i> RIB";
                        } ?>
                            <tr> 
                                <td class="border-end">#<?= $q['id'] ?></td>
                                <td><?= nameFormat($q['nom']) ?></td>
                                <td><?= ucwords($q['activite']) ?></td>
                                <td><?= $q['departement'] ?></td>
                                <td><span style='text-align: right'><?= $notes ?></span></td>
                                <td class="text-center border-start">
                                    <i class="<?= statusModif($q['status']) ?>" id="<?= $q['id'] ?>" data-action="<?= $q['actions'] ?>" data-montant="<?= $q['notes'] ?>" data-date="<?= $q['date_actions'] ?>"></i>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card bg-light mb-2 border border-secondary displayTable">
        <div class="card-header text-center text-secondary">Annulation <?= ($totalAnnul > 0 ? " - (" . $totalAnnul . ")" : "") ?></div>
        <div class="card-body d-none">
            <table class="table table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Activité</th>
                        <th>DPT</th>
                        <th class="text-center">Montant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($q = $annulation->fetch()) { ?>
                            <tr> 
                                <td class="border-end">#<?= $q['id'] ?></td>
                                <td><?= nameFormat($q['nom']) ?></td>
                                <td><?= ucwords($q['activite']) ?></td>
                                <td><?= $q['departement'] ?></td>
                                <td class="text-center"><?= $q['prix'] ?></td>
                                <td class="text-center border-start">
                                    <i class="<?= statusModif($q['status']) ?>" id="<?= $q['id'] ?>" data-action="<?= $q['actions'] ?>" data-montant="<?= $q['notes'] ?>" data-date="<?= $q['date_actions'] ?>"></i>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

    <script>
    $(document).ready(function () {
        let table = $('.displayTable')
        table.each((e,i) => {
            $(i).on('click', function() {
                $(this).find('.card-body').removeClass('d-none')
                var numAct = $(this).find('.card-header').html().replace(/\D+/g, '')

                if(numAct < 1) {
                    $(this).find('.card-body').html('<p class="alert alert-danger border border-danger text-dark"><i class="fa fa-exclamation-circle text-danger"></i> Ce dossier est vide</p>')
                } 
            })
        })
    })
    </script>