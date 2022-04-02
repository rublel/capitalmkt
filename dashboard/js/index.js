$(document).on('click', '.navbar-toggler-icon', function () {
    $('#navbarToggleExternalContent').toggle('fast');
})

$(document).ready(function () {
    $(document).on('click', '.list-item', function () {
        $(".list-item").removeClass("actived")
        $(this).addClass("actived")
    })
})

let loading = () => {
    $('#table').html("<p class='alert alert-warning mt-2'><i class='fa fa-sync'></i> Chargement des données...</p>");
}


$(document).ready(function () {
    $(document).on('keyup', '#search', function () {
        var element = $(this).val();
        if (element.length > 2) {
            $.ajax({
                url: "./controllers/search.php",
                method: "POST",
                data: { element: element },
                success: function (data) {
                    $('#list-customers').show();
                    $('#list-customers').html(data);
                }
            });
        }
    });
});

$(document).ready(function () {
    $(document).on('click', '.add-customer', function () {
        var element = $(this).attr('id');
        if (element.length > 0) {
            $.ajax({
                url: "./controllers/addCustomerForm.php",
                method: "POST",
                data: { element: element },
                success: function (data) {
                    $('#dataModal h4').html('<i class="fas fa-info-circle"></i> Création d\'un nouveau client');
                    $('#employee_detail').html(data);
                    $('#dataModal').modal("show");
                    $('#list-customers').hide();
                    $('#search').val("");
                }
            });
        }
    });
});

$(document).ready(function () {
    $(document).on('click', '.update', function () {
        var element = $(this).attr('id');
        if (element.length > 0) {
            $.ajax({
                url: "./controllers/update.php",
                method: "POST",
                data: { element: element },
                success: function (data) {
                    $('#dataModal h4').html('<i class="fas fa-info-circle text-primary"></i> Actions');
                    $('#employee_detail').html(data);
                    console.log(element);
                    $('#dataModal').modal("show");
                    $('#list-customers').hide();
                    $('#search').val("");
                }
            });
        }
    });
});
//supp apres maj 
/*let displayMaj = () => {
    let tr = document.querySelectorAll('#customers2022 tr');
    $(tr).each(function () {
        let array = [];
        $(this.cells).each(function (i, e) {
            array.push(e.textContent)
        })
        let iClass = this.cells[14].children[0].classList;
        if (array.includes("--")) {
            $(iClass.add('fa-times-circle'));
            $(iClass.add('majClient'));
        } else {
            $(iClass.add('fa-check-circle'));
        }
    });
}

//supp apres maj 
let arr = () => {
    $(".majClient").on('click', function () {
        let activite = $('#activite').text().toLowerCase()
        let id = this.parentNode.parentNode.children[0].textContent;
        let price = this.parentNode.parentNode.children[13].textContent;
        console.log(activite);
        let majPrice = prompt("Mettre à jour le client:", price)
        if (majPrice) {
            $.ajax({
                type: 'POST',
                url: './controllers/majClient.php',
                data: { id, price, activite },
                success: function () {
                    $("#table").load("./app.php?activite=" + activite);
                    displayMaj()
                }
            });
        }
    });
}
*/
$(document).ready(function () {
    $("#activite-list .list-item").on('click', function (e) {
        $(".list-item").removeClass("actived")
        $(this).addClass("actived")
        e.preventDefault();
        let activite = $(this).attr("id");
        let prop = $("#propCustomer option:selected").val()
        if (prop === "all") {
            prop = "";
        }
        $.ajax({
            type: 'POST',
            url: './app.php',
            data: { activite, prop },
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data);
                //supp apres maj 
                displayMaj()
                arr()
            }
        });
    });
});

$(document).ready(function (e) {
    $("#impayes").on('click', function () {
        $.ajax({
            type: 'POST',
            url: './controllers/impayes.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});

$(document).on('click', '.maj-unpaid', function () {
    var id = $(this).attr('id')
    var prixTTC = $(this).parent("span").attr('id')
    var prix = parseInt(prixTTC)
    var mois = $(this).attr('data-month')
    var year = $(this).attr('data-year')
    var confirm = prompt("Mis à jour du paiement:", prix)
    if (confirm) {
        $.ajax({
            url: "./controllers/updateImpayes.php",
            method: "POST",
            data: { id, confirm, mois, year },
            success: function () {
                alert('Client ' + id + ' mis à jour')
                $("#table").load("./controllers/impayes.php?y=" + year);
            }
        });
    }
});

$(document).ready(function (e) {
    $("#sepa").on('click', function (e) {
        e.preventDefault();
        let activite = $(this).attr("id");
        let date = new Date();
        let currentMonth = date.getMonth() + 1;
        let mois;
        currentMonth < 10
            ? mois = "0" + currentMonth
            : mois = currentMonth
        console.log(mois);
        $.ajax({
            type: 'POST',
            url: './controllers/sepa.php',
            data: { activite, mois },
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data);
            }
        });
    });
});

$(document).ready(function (e) {
    $("#invoice").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: {},
            url: './controllers/invoice.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});

$(document).ready(function (e) {
    $("#facture").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: {},
            url: './controllers/facture.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});

$(document).ready(function (e) {
    $("#carte-bleue").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: {},
            url: './controllers/cb.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});


$(document).on('click', '.isPaid', function (e) {
    e.preventDefault();
    var year = $(this).attr('data-year');
    var month = $(this).attr('data-month');
    var price = $(this.parentNode.parentNode).attr('data-price');
    var id = $(this.parentNode.parentNode).attr('data-id');
    var confirm = prompt('Saisir un paiement: ', price);
    var actions = $('.location-reload').attr('id');
    var table;
    var loadTable;
    actions === 'factures' ? table = "paiement_facture_" + year : table = "paiement_cb_" + year;
    actions === 'factures' ? loadTable = "facture" : loadTable = "cb";
    if (confirm) {
        $.ajax({
            url: "./controllers/paiement_cb.php",
            method: "POST",
            data: { month, confirm, table, id },
            success: function () {
                $("#table").load("./controllers/" + loadTable + ".php?y=" + year);
            }
        });
    }
});


$(document).on('click', '.delete-data', function () {
    var year = $(this).attr('data-year');
    var id = $(this).parent().parent().attr('data-id');
    var actions = $('.location-reload').attr('id');
    var table;
    var loadTable;
    actions === 'factures' ? table = "paiement_facture_" + year : table = "paiement_cb_" + year;
    actions === 'factures' ? loadTable = "facture" : loadTable = "cb";
    console.log(id);
    var deleteData = confirm("Voulez-vous vraiment supprimer cet enregistrement ?")
    if (deleteData) {
        $.ajax({
            type: 'POST',
            data: { id, table },
            url: './controllers/delete.php',
            success: function () {
                $("#table").load("./controllers/" + loadTable + ".php?y=" + year);
            }
        });
    }
});

$(document).on('click', '.view-data', function () {
    var id = $(this).attr('data-id');
    var montant = $(this).attr('data-montant');
    $.ajax({
        type: 'POST',
        data: { id, montant },
        url: './controllers/view-data.php',
        success: function (data) {
            $('#dataModal h4').html('<i class="fas fa-info-circle text-primary"></i> Informations');
            $('#employee_detail').html(data);
            $('#dataModal').modal("show");
        }
    });
});

$(document).on('click', '.delete-imp', function () {
    var id = $(this).attr('data-id');
    var deleteData = confirm("Voulez-vous vraiment annuler le client ?")
    if (deleteData) {
        $.ajax({
            type: 'POST',
            data: { id },
            url: './controllers/delete-imp.php',
            success: function () {
                alert('ok')
            }
        });
    }
});

$(document).on('click', '.sendMessage', function () {
    let id = $(this).attr('id');
    let y = $(this).attr('data-year');
    $.ajax({
        type: 'POST',
        data: { id, y },
        url: './controllers/messageForm.php',
        success: function (data) {
            $('#dataModal h4').html('<i class="fas fa-envelope text-primary"></i> Envoyer un message');
            $('#employee_detail').html(data);
            $('#dataModal').modal("show");
            let input = document.querySelectorAll('.form-check-unpaid');
            if (input.length < 2) {
                input.forEach((e) => {
                    e.checked = true;
                    var span = $('.price').text();
                    var price = span.split(':').join(' de');
                    $('#dataMess').text(price)
                })
                $('.form-content').removeClass('d-none');
                $('#totalImp').css("display", "none");
            }
            let totalArr = []
            document.querySelectorAll('.priceRef').forEach(e => totalArr.push(parseInt(e.innerHTML)))
            let total = totalArr.reduce((prev, curr) => prev + curr, 0)
            console.log(total);
            $('#totalPriceImp').text(`${total} €`)
        }
    });
});

$(document).on('input', '.form-check-input', function () {
    let span = $(this).parent().children().eq(1).eq(0).text();
    let price = span.split(':').join(' de');
    $('#prefixe').text('du');
    if (this.checked) {
        $('#dataMess').text(price)
        $('.form-content').removeClass('d-none');
    }
});

$(document).on('input', '.form-check-total', function () {
    let span = $(this).parent().children().eq(1).eq(0).text();
    let prices = span.split(':').join(' de').toLowerCase()
    $('#prefixe').text('d\'un');
    if (this.checked) {
        $('#dataMess').text(prices)
        $('.form-content').removeClass('d-none');
    }
});

$(document).on('submit', '#MessageForm', function (e) {
    e.preventDefault();
    let prix;
    let mois;
    let email = $("input[name='email']").val()
    let priceRef = document.querySelectorAll('.priceRef')
    let total = document.querySelectorAll('#totalPriceImp')
    let arr = [...priceRef, ...total]
    arr.forEach(e => {
        if (e.parentNode.parentNode.children[0].checked) {
            prix = parseInt(e.innerHTML);
            mois = e.parentNode.parentNode.children[1].children[0].innerHTML
        }
    })
    $.ajax({
        type: 'POST',
        url: './controllers/messImp.php',
        data: { prix, mois, email },
        success: function () {
            $('#dataModal h4').html('<i class="fas fa-check-circle text-success"></i> Votre message a été envoyé avec succès');
            $('#dataModal button').html('Envoyé');
        }
    });
});


$(document).ready(function () {
    $("#presence").on('click', function (e) {
        e.preventDefault();
        let date = new Date();
        let currentMonth = date.getMonth() + 1;
        let mois;
        currentMonth < 10
            ? mois = "0" + currentMonth
            : mois = currentMonth
        console.log(mois);
        $.ajax({
            type: 'POST',
            url: './controllers/presence.php',
            data: { mois },
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data);
            }
        });
    });
});

$(document).ready(function (e) {
    $("#commissions").on('click', function () {
        $.ajax({
            type: 'POST',
            url: './controllers/comm.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});

$(document).ready(function (e) {
    $("#salaire").on('click', function () {
        $.ajax({
            type: 'POST',
            url: './controllers/salaire.php',
            beforeSend: loading(),
            success: function (data) {
                $('#table').html(data)
            }
        });
    });
});