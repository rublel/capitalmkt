<?php

require('./functions/functions.php');
require('./classes/class.php');
require('../database/database.php');
$dbs = Databases::connect();
$statement = $dbs->query("SELECT DISTINCT(activite) as act FROM clients2022 WHERE status_presta = 'client' ORDER BY act");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/0fb4643e56.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/invoice.js"></script>
    <script src="./js/sepa.js"></script>
    <script src="./js/notify.min.js"></script>
    <script src="./js/impayes.js"></script>  
    <script src="./js/maj.js"></script>  
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <title>Dashboard</title> 
    <style>
        .menu-content ul li {
            list-style: none;
        }
        .menu-sidebar {
            padding: 0px !important;
        }
        .search-data .form-control {
            padding: 5px;
            margin: 5px;
            width: 95% !important
        }
        .angle-down-list {
            position: absolute;
            margin-top: 2px;
            right: 0px;
        }
        .menu-content h4 {
            position: relative;
            font-size: 15px;
        }
        .menu-content h4 i {
            width: 30px;
            padding: 0px 15px;
            margin-right: 10px;
        }
        .menu-sidebar li {
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            transition: .1s;
        }
        .menu-sidebar li:hover {
            background: #EBECED;
            color: #6C757D !important;
        }
        #list-data .inactive:hover i{
            color: #6C757D !important;
        }
        #list-data .actived ul li:hover {
            margin-left: 40px;
        }
        #list-data .actived {
            background: #EBECED;
            color: #6C757D
        }
        .menu-list .actived:hover{
            color: #fff !important;
        }
        .menu-sidebar {
            border-right: 1px silver solid;
            position: relative;
            height: 100vh !important;
            overflow: auto:
        }
        #list-home-link {
            position: absolute;
            bottom: 0px
        }
        .menu-list {
            max-height: 200px;
            overflow: auto;
        }
        .menu-list li, .menu-list select {
            padding: 5px;
            margin-left: 30px;
            border: none;
            border-radius: 0px;
            font-size: 13px
        }
        .menu-list .actived {
            border-radius: 5px;
            background: #6C757D !important;
            color: #fff !important;
        }
        #propCustomer {
            border-radius: 5px;
            background: #6C757D !important;
            color: #fff !important;
        }
        .actived:not(.list-item), .inactive {
            margin-bottom: 20px !important
        }
        #list-customers li {
            position: relative;
        }
        .fa-exchange-alt {
            color: #B2B200;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <section class="body">
            <div class="row">
                <div class="col-lg-2 menu-sidebar">
                    <div class="menu">
                        <div class="search-data">
                            <h4></h4>
                            <input type="search" name="search" id="search" class="form-control" placeholder="Rechercher parmis les prestataires">
                            <ul id="list-customers"></ul>
                        </div>
                        <ul id="list-data">
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fas fa-users"></i> Clients <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul id="activite-list" class="menu-list d-none">
                                        <select name="propCustomer" id="propCustomer" class="mt-2">
                                            <option value="all">Filtrer par proprietaire</option>
                                            <option value="Ruben">Ruben</option>
                                            <option value="Morgane">Morgane</option>
                                            <option value="Shirel">Shirel</option>
                                        </select>
                                        <?php while($q = $statement->fetch()) { ?>
                                            <li id="<?= $q['act'] ?>" class="list-item"><?= ucwords($q['act']) ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-gear"></i> Gestion <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li id="impayes" class="list-item">Impayés </li>
                                        <li id="invoice" class="list-item">Facturation</li>
                                        <li id="sepa" class="list-item">SEPA</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-credit-card"></i> Paiements <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li id="facture" class="list-item">Facture</li>
                                        <li id="carte-bleue" class="list-item">Carte Bancaire</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-sync"></i> Mise a jour <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li class="list-item">Proxi & WLC</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-calendar"></i> Rappels <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li class="list-item">Alertes</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-calculator"></i> Comptabilite <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li class="list-item" id="presence">Presence</li>
                                        <li class="list-item" id="commissions">Commissions</li>
                                        <li class="list-item" id="salaire">Salaires</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="inactive">
                                <div class="menu-content">
                                    <h4><i class="fa fa-envelope"></i> Message <i class="fas fa-angle-right angle-down-list"></i></h4>
                                    <ul class="menu-list d-none">
                                        <li class="list-item" id="presence">Nouveau message</li>
                                        <li class="list-item" id="presence">Reçus</li>
                                        <li class="list-item">Envoyés</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <ul id="list-home-link">
                            <li>
                                <div class="menu-content">
                                    <h4><i class="fa fa-home"></i> Retour a l'accueil </h4>
                                </div>
                            </li>
                        </ul>
                </div>
                <div class="col-lg-10 dashboard-content">
                    <div class="content-table" id="table"></div>
                </div>
            </div>
        </section>
        <section class="footer">
            <div id="dataModal" class="modal fade ">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i> Informations</h4>
                        </div>
                        <div class="modal-body" id="employee_detail"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

<script>
    let angle = document.querySelectorAll(".menu-content h4")
    angle.forEach((e,i)=>{
        e.addEventListener("click", () => {
            let icon = e.getElementsByTagName('i')[1];
            if(e.parentNode.parentNode.className === "inactive") {
                angle.forEach(li=>{
                    li.parentNode.parentNode.className = "inactive"
                    li.parentNode.lastElementChild.className = "menu-list d-none"
                })
                //li.getElementsByTagName('i')[1]
                icon.classList.remove('fa-angle-right');
                icon.classList.add('fa-angle-down');
                e.parentNode.parentNode.className = "actived" 
                if(e.parentNode.lastElementChild.tagName === "UL") {
                    e.parentNode.lastElementChild.className = "menu-list"
                }
            } else {
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-right');
                e.parentNode.parentNode.className = "inactive"
                if(e.parentNode.lastElementChild.tagName === "UL") {
                    e.parentNode.lastElementChild.className = "menu-list d-none"
                } 
            }
        })
    })
    
</script>