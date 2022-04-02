<?php

$db = Database::connect();
$statement = $db->query("SELECT * FROM prestataire WHERE id = '$element'");
while ($maj = $statement->fetch()) {
    $tel = $maj['portable'];
}

?>

<div class="jumbotron p-4 alert alert-success" style="background: beige">
    <h1 class="display-6"><i class="fas fa-sync-alt"></i> Mise à jour ...</h1>
</div>

<div class="input-group mb-2">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">Nom</label>
  </div>
  <select class="form-select" name="nom_maj">
    <option selected value="<?= $nom ?>"><?= $nom ?></option>
    <option value="Proxi <?= $activite ?>">Proxi <?= $activite ?></option>
  </select>
</div>

<div class="input-group mb-2" name="tel_maj">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">Tel</label>
  </div>
  <select class="form-select" name="tel_maj">
    <option selected value="<?= $tel ?>"><?= telFormat($tel) ?></option>
    <option value="09.75.18.12.30">09.75.18.12.30</option>
    <option value="09.75.18.12.30">07.56.78.02.30</option>
  </select>
</div>
<input type="hidden" name="activite_maj" value="<?= $activite ?>">
<?= inputForm('Départ.', 'dpt_maj', 'text', $dpt) ?>
<?= inputForm('Sites WLC', 'wlc_maj', 'text', " ") ?>
<?= inputForm('Notes', 'notes_maj', 'text', " ") ?>
