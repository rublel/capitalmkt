<?php

function impayes($q, $id, $month, $currYear) {
    $json = json_decode($q);  
    $status = $json->{'status'};
    $montant =  $json->{'montant'};
    $year = $json->{'annee'};
    if($year === $currYear) {
        if($status === 'impaye') {
            return "<span id=$montant><i class='fas fa-times-circle maj-unpaid' id=$id data-month=$month></i></span>";
        } else {
            return "<i class='fas fa-check-circle'></i>";
        }
    }
}
