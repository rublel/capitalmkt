<?php

require('../../database/database.php');
require('../functions/functions.php');
require('../classes/class.php');
setlocale(LC_TIME, 'fr', 'fr_FR'); 
$element = $_POST['element'];

$db = Database::connect();
$dbs = Databases::connect();
$user = $db->query("SELECT * FROM prestataire WHERE id = '$element'");
while ($res = $user->fetch()) {
    $nom = $res['nom'];
    $tel = $res['portable'];
    $mail = $res['mail'];
    $cp = $res['cp'];
    $reg = $res['region'];
    $activite = $res['activite'];
    $compte = $dbs->query("SELECT * FROM clients2022 WHERE id = '$element'");
    while ($row = $compte->fetch()) {
        $prix = $row['prix'];
        $isSuccess = true;
    }
}

?>  
<form enctype="multipart/form-data" role="form" id="form" class="<?= $element ?>">
<div class="row">
    <div class="col-lg-5 info-customer pt-3">
        <div class="card bg-light p-3">
            <p><i class="fas fa-user"></i> <?= $nom ?></p>
            <p><i class="fas fa-map"></i> <?= $reg . ", " . $cp ?></p>
            <p><i class="fas fa-phone"></i> <?= $tel ?></p>
            <p><i class="fas fa-envelope"></i> <?= $mail ?></p>
            <p><i class="fas fa-check"></i> <?= $activite ?></p>
        </div>
        <div class="info-price">
            <div class="row">
                <div class="col-8">
                    <p class="alert alert-primary"><i class="fas fa-star"></i><?= $prix ?> HT/mois</p>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary submitBtn">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 maj-content mb-2">
        <input type="hidden" id='id' name='id' value='<?= $element ?>'>
        <input type="hidden" id='activite_maj' name='activite_maj' value='<?= $activite ?>'>
        <div class="row mt-2">
            <div class="col-lg-6">
                <div class="card card-info-update card-select bg-light p-3 mb-2 mt-2" id="impayes">
                    <div class="card-content">
                        <p class="small-label"><i class="fas fa-times"></i> <span>Impayé</span></p>
                    </div>
                    <select class="default-val bg-light" name="impayes">
                        <?php echo $months->getMonth(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-info-update bg-light p-3 mb-2 mt-2" id="impayes">
                    <div class="card-content">
                        <p class="small-label"><i class="fas fa-file"></i> <span>Facture</span></p>
                    </div>
                    <span class="default-val"></span>
                    <p class="small-label"><span>Demande de facture</span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-info-update card-select bg-light p-3 mb-2 mt-2" id="impayes">
                    <div class="card-content">
                        <p class="small-label"><i class="fas fa-edit"></i> <span>Modification</span></p>
                    </div>
                    <select class="default-val bg-light" name="sepa" id="select">
                        <option value="">--</option>
                        <option value="Modification">SEPA</option>
                        <option value="rib">RIB</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-info-update card-select bg-light p-3 mb-2 mt-2" id="annulation">
                    <div class="card-content">
                        <p class="small-label"><i class="fas fa-sign-out-alt"></i> <span>Annulation</span></p>
                    </div>
                    <select class="default-val bg-light" name="annulation" id="select">
                        <?php echo $months->getMonth(); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-info-update card-select bg-light p-3 mb-2 mt-2" id="impayes">
                    <div class="card-content">
                        <p class="small-label"><i class="fas fa-sync"></i> <span>Mise à jour</span></p>
                    </div>
                    <select class="default-val bg-light" name="selectMaj" id="selectMaj">
                        <option value="">--</option>
                        <option value="oui">OUI</option>
                        <option value="">NON</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='card bg-light p-2 col-auto mt-2 mb-2' id="montant" style="display: none">
            <label class='sr-only' for='inlineFormInputGroup'>Montant</label>
            <div id="montant-sepa">
                <div class='input-group mt-2'>
                    <div class='input-group-prepend'>
                        <div class='input-group-text'>Prix:</div>
                    </div>
                    <input type=text class='form-control' name='notes' placeholder="Ajouter le tarif modifie">
                </div>
            </div>
            <div class="input-group mb-2 mt-2" id="date_actions">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">A partir de:</label>
                </div>
                <select class="form-select" name="date_actions">
                    <?php echo $months->getMonth(); ?>
                </select>
            </div>
        </div>
        <div id="majForm" class="card bg-light p-2 mt-2 nb-2" style="display: none">
            <div class="input-group mt-2 mb-2">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Nom:</label>
                </div>
                <select class="form-select" name="nom_maj">
                    <option selected value="<?= $nom ?>"><?= $nom ?></option>
                    <option value="Proxi <?= $activite ?>">Proxi <?= $activite ?></option>
                </select>
            </div>
            <div class="input-group mb-2" name="tel_maj">
                <div class="input-group-prepend">
                    <label class="input-group-text">Tel (sur sites):</label>
                </div>
                <select class="form-select" name="tel_maj">
                    <option selected value="<?= $tel ?>"><?= telFormat($tel) ?></option>
                    <option value="0975181230">09.75.18.12.30</option>
                    <option value="0756780230">07.56.78.02.30</option>
                </select>
            </div>
            <input type="hidden" name="activite_maj" value="<?= $activite ?>">
            <?= inputForm('Départements:', 'dpt_maj', 'text', substr($cp, 0, 2)) ?>
            <?= inputForm('Sites WLC:', 'wlc_maj', 'text', "--") ?>
            <?= inputForm('Notes:', 'notes_maj', 'text', "--") ?>
        </div>
    </div>
</div>
</form>

<script>
$(document).ready(function(){
    $("#select").on('change', function(){
        var sepa = $('#select option[value="Modification"]').prop('selected');
        var rib = $('#select option[value="rib"]').prop('selected');
        if(sepa === true) {
            $('#montant').css('display', 'block')
            $('#montant-sepa').css('display', 'block')
            $('#majForm').css('display', 'none')
        } else {
            $('#montant').css('display', 'none')
        }
        if(rib === true) {
            $('#montant').css('display', 'block')
            $('#montant-sepa').css('display', 'none')
            $('#majForm').css('display', 'none')
        } 
    });
    $("#selectMaj").on('change', function(){
        var maj = $('#selectMaj option[value="oui"]').prop('selected');
        if(maj === true) {
            $('#majForm').css('display', 'block')
            $('#montant').css('display', 'none')
        } else {
            $('#majForm').css('display', 'none')
        }
    });
    $("#form").on('submit', function(e){
        var mois = $('#date_actions option:selected').val()
        e.preventDefault();
        let defVal = document.querySelectorAll(".default-val");
        let arr = [];
        defVal.forEach(v=>arr.push(v.value))
        if(arr.join('') === "") {
            defVal.forEach(v=>{v.parentNode.classList.add("border"),v.parentNode.classList.add("border-danger")})
        } else {
            $.ajax({
                type: 'POST',
                url: './controllers/finalUpdate.php',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function() {
                    $('#dataModal').css('opacity', '0.7')
                },
                success: function(data) {
                    $('#dataModal').css('opacity', '1')
                    $('#dataModal h4').html('<i class="fas fa-info-circle"></i> Informations');
                    $('#dataModal').modal("hide");
                    if(mois >= 1) {
                        $('#table').load('./controllers/sepa.php?m=' + mois)
                        $.notify("Enregistrée", {className: "success", position: "top-right" });
                    } else {
                        $('#table').load('./controllers/impayes.php')
                        $.notify("Enregistré", {className: "success", position: "top-right" });
                    }
                }
            }) 
        }
    });
});
</script>

<style>
    .modal-body {
        padding: 0rem 1rem !important
    }
    .info-customer {
        border-right: 1px solid silver;
    }
    .info-customer p {
        font-size: 13px
    }
.info-customer i {
    margin-right: 10px
}
.input-group-text {
    width: 160px !important;
}
.card-select select {
        border-radius: 5px;
        padding: 5px;
        border: 1px solid rgba(0,0,0,.125);
}
.small-label {
    text-align: center;
    font-size: 14px;
    margin-top: 5px;
}
.small-label i {
    display: block;
    font-size: 20px;
    margin-bottom: 5px;
    color: #5F5F60;
}
.small-label span, #majForm .input-group-text {
    color: #5F5F60;
}
.card-info-update {
    transition: 0.1s;
    height: 140px;
}
.card-info-update:hover {
    box-shadow: rgb(0 0 0 / 30%) 0px 1px 4px;
}
select:focus {
    outline: none !important;
}
.info-customer {
    position: relative;
}
.info-price {
    position: absolute;
    bottom: 1px;
    width: 83%;
}
.info-price .alert {
    padding: 0.5rem !important;
}
</style>