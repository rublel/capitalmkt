<?php

require('../../database/database.php');
require('../functions/functions.php');
$element = $_POST['element'];

$db = Database::connect();
$statements = $db->query("SELECT * FROM prestataire WHERE id = $element");
while ($res = $statements->fetch()) {
    $nom = $res['nom'];
    $contact = $res['mail'];
    $cp = $res['cp'];
    $dpt = $res['departement'];
    $region = $res['region'];
    $activite = $res['activite'];
    $cpRegion = $cp . ", " . $region;
}

?>


<div class="jumbotron p-4" style="background: beige">
    <h1 class="display-6"><b>#</b><?= $element . " - <span id='activite'>" . $activite ?></span></h1>
</div>  

<form enctype="multipart/form-data" role="form" id="form" class="<?= $element ?> pt-2">
    <?= invoiceForm('ID Client', 'id', 'number', $element) ?>
    <?= invoiceForm('Activité', 'activite', 'text', $activite) ?>
    <?= invoiceForm('Nom', 'nom', 'text', $nom) ?>
    <?= invoiceForm('Région', 'dpt', 'text', $cpRegion) ?>
    <?= invoiceForm('Email', 'email', 'email', $contact) ?>
    <?= invoiceForm('De', 'from', 'month', "") ?>
    <?= invoiceForm('A', 'to', 'month', "") ?>
    <?= invoiceForm('Montant', 'montant', 'number', $montant) ?>
    <?= invoiceForm('Facture', 'file', 'file', "") ?>
    <button class="btn btn-primary submitBtn">Ajouter</button>
</form>

<script>
$(document).ready(function(e){
    $("#form").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: './controllers/add_invoice.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                $('.modal-content').css('opacity', '.5')
                $('#dataModal h4').html('En cours d\'enregistrement...')
            },
            success: function () {
                $('#table').load('./controllers/invoice.php')
                $('.modal-content').css('opacity', '1')
                $('#dataModal').modal("hide");
                $('#dataModal h4').html('<i class="fas fa-info-circle"></i> Informations');
                $.notify("Facture enregistrée", {className: "success", position: "top-right" });
            }
        });
    });
});
</script>