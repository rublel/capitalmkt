
$(document).on('click', '.add-invoice', function () {
    var element = $(this).attr('id');
    if (element.length > 0) {
        $.ajax({
            url: "./controllers/form_invoice.php",
            method: "POST",
            data: { element: element },
            success: function (data) {
                $('#list-customers').hide();
                $('#employee_detail').html(data);
                $('#dataModal h4').html('<i class="fas fa-info-circle"></i> Création d\'une facture');
                $('#dataModal').modal('show');
            }
        });
    }
});

$(document).on('click', '.status-invoice', function () {
    var id = $(this).attr('id');
    if (id.length > 0) {
        $.ajax({
            url: "./controllers/status_invoice.php",
            method: "POST",
            data: { id: id },
            beforeSend: function () {
                alert('Facture enregistré !')
            },
            success: function () {
                $("#table").load("./controllers/invoice.php");
            }
        });
    }
});