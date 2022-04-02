<form id="MessageForm">
    <div class="card bg-light p-3 mb-2">
<?php
require('../../database/database.php');
require('../functions/functions.php');
require('../classes/class.php');
$db = Database::connect();
$dbs = Databases::connect();
$isJson = new Itemformat();
setlocale(LC_TIME, 'fr', 'fr_FR'); 
if(!empty($_POST)) {
    extract($_POST);
    $table = "clients". $y;
    $mess = $db->query("SELECT mail FROM prestataire WHERE id = $id");  
    while($q = $mess->fetch()) {
        $mail = $q['mail'];
    }
    $imp = $dbs->query("SELECT * FROM $table WHERE id = $id");  
    while($impaye = $imp->fetch()) {
        foreach($impaye as $k => $v) {
            if($isJson->DisplayIsJson($v)){
                if(strlen($k) > 2) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input form-check-unpaid" name="radio" type="radio" id="inlineCheckbox<?= $k ?>" <?= $checked ?> value="option1">
                        <label class="form-check-label price" for="inlineCheckbox<?= $k ?>"><span class="monthRef text-primary"><?= substr($k, 1, 2)."/".substr($y, 2, 2) ?></span>: <span class="priceRef"><?= json_decode($v)->{'montant'}*1.2.' €'?></span></label>
                    </div>
                <?php };
            };
        } ?>
        <div class="form-check form-check-inline" id="totalImp">
            <input class="form-check-input form-check-total" name="radio" type="radio" id="inlineCheckbox1" <?= $checked ?> value="option1">
            <label class="form-check-label price" for="inlineCheckbox1"><span class="monthRef text-primary">Total</span>: <span id="totalPriceImp"></span></label>
        </div>
    <?php
    } 
}

?>
</div>

    <div class="form-content d-none">
        <?= inputForm('Email', 'email', 'email', $mail) ?>
        <?= inputForm('Objet', 'objet', 'text', 'Impayé') ?>
        <div class="alert alert-primary">
            <p>
                Bonjour,</br> veuillez nous recontacter au 01.77.47.38.84 afin de régulariser l'impayé <span id="prefixe">du</span> <span id="dataMess"></span>.<br>
                Cordialement.<br>
                Mr Dahan - L'equipe Proxi Groupe.<br>
            </p>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </div>
</form>



<style>
    .form-check {
        padding-left: 0px !important;
    }
</style>
