<?php
require('../../database/database.php');
require('../functions/functions.php');
$dbs = Databases::connect();
$statement = $dbs->query("SELECT * FROM facture ORDER BY id DESC");
?>
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-white text-center">FACTURES</div>
        <div class="card-body">
        <table class="table table-striped">
            <thead class="bg-warning">
                <tr>
                    <th>ID</th>
                    <th>Raison sociale</th>
                    <th>Email</th>
                    <th class="text-center">Montant</th>
                    <th>Periode</th>
                    <th>Ajouté le</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($q = $statement->fetch()) { ?>
                <tr>
                    <td class="border-end">#<?= $q['client_id'] ?></td>
                    <td><?= nameFormat($q['nom']) ?></td>
                    <td><?= $q['contact'] ?></td>
                    <td class="text-center"><?= $q['montant'] ?> €</td>
                    <td><?= utf8_encode($q['de']) . " - " . utf8_encode($q['a'])  ?></td>
                    <td><?= timeAdding($q['date']) ?></td>
                    <td class="border-start text-center">
                        <a href="./dashboard/<?= str_replace(" ", "%20", $q['file_url']) ?>" target="_blank" class="m-2"><i class="far fa-file-pdf"></i></a>
                        <i class="<?= statusInvoice($q['status']) ?> " id="<?= $q['id'] ?>"></i>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>
</div>