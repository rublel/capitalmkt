$(document).on('click', '.month_after', function () {
    var mois = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: './controllers/sepa.php',
        data: { mois },
        beforeSend: loading(),
        success: function (data) {
            $('#table').html(data);
        }
    });
});

$(document).on('click', '.month_before', function () {
    var mois = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: './controllers/sepa.php',
        data: { mois },
        beforeSend: loading(),
        success: function (data) {
            $('#table').html(data);
        }
    });
});

$(document).on('click', '.changeYear', function () {
    var page = $(this).attr('data-page');
    let time = $(this).attr('id');
    if (time > 2022 || time < 2021) {
        alert('Désolé, nous n\'avons pas d\'informations sur l\'anneé ' + time + ' !')
    } else {
        $.ajax({
            type: 'POST',
            url: './controllers/' + page + '.php',
            data: { time },
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data);
            }
        });
    }
});

$(document).on('click', '.status-modif', function () {
    var id = $(this).attr('id');
    var actions = $(this).attr('data-action')
    var prix = $(this).attr('data-montant')
    var date = $(this).attr('data-date')
    let annul;
    if (actions === 'Annulation') {
        annul = confirm('Voulez vous annuler ce client ?')
    } else {
        annul = true;
    }
    if (annul) {
        if (id.length > 0) {
            $.ajax({
                url: "./controllers/status_modif.php",
                method: "POST",
                data: { id, actions, prix, date },
                success: function () {
                    alert(actions + ' enregistré')
                    $("#table").load("./controllers/sepa.php?m=" + date);
                }
            });
        }
    }
});
