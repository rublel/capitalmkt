<?php

require('../functions/functions.php');
require('../classes/class.php');
require('../../database/database.php');
$dbs = Databases::connect();
$date = date('m');
($date >= 10 ? $month = $date : $month = substr($date, 1, 1));
$user = '';
if(!empty($_GET['u'])) {
    $user = $_GET['u'];
    ($user === 'total' ? $user = '' : $user = $user);
}
$users = $dbs->query("SELECT * FROM users");
$req_url = 'https://v6.exchangerate-api.com/v6/f97496daf8882c4849b99b14/latest/EUR';
$response_json = file_get_contents($req_url);
if(false !== $response_json) {
    try {
		$response = json_decode($response_json);
		if('success' === $response->result) {
            define("ILS_PRICE",$response->conversion_rates->ILS);
		}
    }
    catch(Exception $e) {
        echo "There is an error: " .$e;
    }
}
?>
<div class="card mt-2 mb-2 bg-light" id="filterForm">
    <div class="card-header bg-secondary text-white text-center">FILTRE</div>
    <div class="card-body">
        <form id="formSalaire">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <select class="form-select" id="user">
                        <option><?= (empty($_GET['u']) ? "Total" : ucfirst($_GET['u'])) ?></option>
                        <option>Total</option>
                        <?php while($u = $users->fetch()) { ?>
                            <option><?= $u['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary">Appliquer</button>
        </form>
    </div>
</div>
<script src="./js/salaire.js"></script> 
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-white text-center">SALAIRES</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th></th>
                        <?php for($i = 1; $i < $month+1; $i++) { ?>
                            <th class="month"><?= utf8_encode(substr(ucfirst(strftime("%B", strtotime($i."/22"))), 0, 3)) ?></th>  
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre de jours</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) {
                            ($i >= 10 ? $s = $i : $s = "0" . $i);
                            $time = $dbs->query("SELECT count(*) as days FROM presence WHERE user LIKE '$user%' AND date LIKE '%$s.2022'");
                            while($t = $time->fetch()) { ?>
                                <td><?=  round($t['days']) ?></td>
                            <?php }
                        } ?>
                    </tr>
                    <tr>
                        <td>Nombre d'heures</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) {
                            ($i >= 10 ? $s = $i : $s = "0" . $i);
                            $time = $dbs->query("SELECT sum(total) as time FROM presence WHERE user LIKE '$user%' AND date LIKE '%$s.2022'");
                            while($t = $time->fetch()) { ?>
                                <td><?=  round($t['time']) ?></td>
                            <?php }
                        } ?>
                    </tr>
                     <tr>
                        <td>Prime</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) { ?>
                            <td>0</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Congé</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) { ?>
                            <td>0</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>EUR/ILS (Actuel: <span id="currency"><?= ILS_PRICE ?></span>)</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) { ?>
                            <td><?= ILS_PRICE ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Salaire fixe (32 ₪/heure)</td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) {
                            ($i >= 10 ? $s = $i : $s = "0" . $i);
                            $time = $dbs->query("SELECT sum(total) as time FROM presence WHERE user LIKE '$user%' AND date LIKE '%$s.2022'");
                            while($t = $time->fetch()) { ?>
                                <td class="m<?= $s ?>"><?=  number_format(round($t['time'])*32, 2, ',', '.') ?></td>
                            <?php }
                        } ?>
                    </tr>
                    <tr>
                        <td>Commissions <img src="https://flagcdn.com/16x12/fr.png"></td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) {
                            ($i >= 10 ? $s = "m" . $i : $s = "m0" . $i);
                            $sum = $dbs->query("SELECT sum($s) as mois FROM clients2022 WHERE proprietaire = '$user'");
                            while($r = $sum->fetch()) { ?>
                                <td><?= number_format($r['mois']*0.05, 2, ',', '.') ?></td>
                            <?php }
                        } ?>
                    </tr>
                    <tr>
                        <td>Commissions <img src="https://flagcdn.com/16x12/il.png"></td>
                        <?php
                        for($i = 1; $i < $month+1; $i++) {
                            ($i >= 10 ? $s = "m" . $i : $s = "m0" . $i);
                            $sum = $dbs->query("SELECT sum($s) as mois FROM clients2022 WHERE proprietaire = '$user'");
                            while($r = $sum->fetch()) { ?>
                                <td class="<?= $s ?>"><?= number_format($r['mois']*0.05*ILS_PRICE, 2, ',', '.') ?></td>
                            <?php }
                        } ?>
                    </tr>
                    <tr class="bg-secondary">
                        <td class="text-white">TOTAL</td>
                        <?php
                            for($i = 1; $i < $month+1; $i++) {
                                ($i >= 10 ? $s = $i : $s = "0" . $i);
                        ?>
                            <td class="text-white" id="m<?= $s ?>"></td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>