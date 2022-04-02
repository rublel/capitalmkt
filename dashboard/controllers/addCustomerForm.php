<?php

require('../../database/database.php');
require('../functions/functions.php');
require('../classes/class.php');
$element = $_POST['element'];
$db = Database::connect();
$statements = $db->query("SELECT * FROM prestataire WHERE id = '$element'");
while ($res = $statements->fetch()) {
    $nom = $res['nom'];
    $dpt = $res['cp'] . ", ". $res['region'];
    $activite = $res['activite'];
    $proprietaire = $res['proprietaire'];
}

?>

<div class="jumbotron p-4" style="background: beige">
    <h1 class="display-6"><b>#</b><?= $element . " - <span id='activite'>".ucwords($activite)."</span>"  ?></h1>
</div>  
<form enctype="multipart/form-data" class="mt-2" role="form" id="form" class="<?= $element ?>">
    <?= inputForm('ID Client', 'id', 'number', $element) ?>
    <?= inputForm('Activité', 'activite', 'text', $activite) ?>
    <?= inputForm('Nom', 'nom', 'text', $nom) ?>
    <?= inputForm('Région', 'dpt', 'text', $dpt) ?>
    <?= inputForm('Proprietaire', 'proprietaire', 'text', $proprietaire) ?>
    <?= inputForm('Montant', 'montant', 'text', "") ?>
    <select class="form-select mb-2" aria-label="Default select example" id="select" name="paiement">
        <option value="">Moyen de paiement</option>
        <option value="sepa">SEPA</option>
        <option value="CB">CB</option>
        <option value="facture">Facture</option>
    </select>
    <select class="form-select mb-2" style="display: none" id="date_actions" aria-label="Default select example" name="date_actions">
        <option value="">A partir de:</option>
        <?php echo $months->getMonth(); ?>
    </select>

    <button class="btn btn-primary submitBtn mt-2">Ajouter comme client</button>
</form>

<script>
    $(document).ready(function(e){
        $("#select").on('change', function(e){
            let sepa = $('#select option[value="sepa"]').prop('selected');
            if(sepa === true) {
                $('#date_actions').css('display', 'block')
                $('.submitBtn').text("Création SEPA")
            } else {
                $('#date_actions').css('display', 'none')
                $('.submitBtn').text("Ajouter comme client")
            }
        });


        $("#form").on('submit', function(e){
            e.preventDefault();
            let error = $('#select option[value=""]').prop('selected');
            var date = $("#date_actions option:selected").val();
            var payment = $("#select option:selected").val();
            if(payment !== "sepa") {
                let confirm = alert("Definir comme nouveau client ?")
            }
            console.log(payment);
            if(error === false) {
                $.ajax({
                    type: 'POST',
                    url: './controllers/addCustomer.php',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function () {
                        let sepa = $('#select option[value="sepa"]').prop('selected');
                        let cb = $('#select option[value="CB"]').prop('selected');
                        let facture = $('#select option[value="facture"]').prop('selected');
                        $('#dataModal').modal("hide");
                        if(sepa === true) {
                            $("#table").load("./controllers/sepa.php?m=" + date);
                        } else if(cb === true) {
                            $("#table").load("./controllers/cb.php");
                        } else if(facture === true) {
                            $("#table").load("./controllers/facture.php");
                        }
                    }  
                });
            } else {
                $('#select').addClass('is-invalid');
            }
        });
    });
</script>
