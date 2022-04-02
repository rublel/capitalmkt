<?php
require('../../database/database.php');
require('../functions/functions.php');

if(!empty($_POST)) {
    $db = Database::connect();
    extract($_POST);
    $statement = $db->query("SELECT * FROM prestataire WHERE id = '$id'");
    while($row = $statement->fetch()) {
        
?>
<style>
    .badge-activite {
        background: orange;
        color: #000;
    }
    .label {
        text-align: center;
    }
    .view-card i{
        width: 30px;
        color: #CFE2FF;
    }
</style>
<div class="card">
  <h5 class="card-header">#<?= $row['id'] ?></h5>
  <div class="card-body">
    <h5 class="card-title"><span class="badge badge-activite mb-2"><?= $row['activite'] ?></span><br><?= $row['nom'] ?></h5>
    <div class="card-text mt-4 view-card">
        <p><span class="label"><i class="fas fa-map-pin"></i> </span> <span class="details"><?= $row['region']. ", (" . $row['cp'] . ")" ?></span></p>
        <p><span class="label"><i class="fas fa-phone"></i> </span> <span class="details"><?= $row['portable'] ?></span></p>
        <p><span class="label"><i class="fas fa-envelope"></i> </span> <span class="details"><a href="mailto:<?= $row['mail'] ?>"><?= $row['mail'] ?></a></span></p>
        <p class="alert alert-primary mt-4"><b>Abonnement:</b> <?= $montant ?>,00€ HT/mois</p>
  </div>
</div>


<?php
    }
}

?>