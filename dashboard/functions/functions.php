<?php
function color ($data) {
    if($data === 'client') {
        return "green";
    } 
}

function isClient ($data) {
    if($data === 'client') {
        return "update";
    } else {
        return "add-customer";
    }
}

function inputForm($label, $name, $type, $value) {
    if($value === '0 €') {
        $class = "unpaid";
    } elseif(empty($value)) {
        $class = "no-client";
        $placeholder = "Pas client";  
    }
    return     
    "<div class='col-auto'>
        <label class='sr-only' for='inlineFormInputGroup'>$label</label>
        <div class='input-group mb-2'>
        <div class='input-group-prepend'>
            <div class='input-group-text'>$label</div>
        </div>
        <input type=$type class='form-control $class' id='$name' name='$name' placeholder='$placeholder' value='$value'>
        </div>
    </div>";
}

function invoiceForm($label, $name, $type, $value) {
    return     
    "<div class='col-auto'>
        <label class='sr-only' for='inlineFormInputGroup'>$label</label>
        <div class='input-group mb-2'>
        <div class='input-group-prepend'>
            <div class='input-group-text'>$label</div>  
        </div>
        <input type=$type class='form-control $class' id='$name' name='$name' placeholder='$placeholder' value='$value'>
        </div>
    </div>";
}

function commission ($user, $activite, $val) {
    if(!empty($user)) {
        $arr15 = ['monte-meuble', 'container'];
        if($user === 'david') {
            if(in_array($activite, $arr15)) {
                return number_format($val * 0.15, 2, ',', '.');
            } else {
                return number_format($val * 0.26, 2, ',', '.');
            }
        } elseif($user === 'ruben') {
            return number_format($val * 0.08, 2, ',', '.');
        } else {
            return number_format($val * 0.05, 2, ',', '.');
        }
    } else {
        return number_format($val, 2, ',', '.');
    }
}

function impayes($q, $id, $month, $year) {
    $json = json_decode($q);  
    $status = $json->{'status'};
    $montant = $json->{'montant'};
        if($status === 'impaye') {
            return "<span id=$montant><i class='fas fa-times-circle maj-unpaid' id=$id data-month=$month data-year=$year></i></span>";
        } else {
            return "<i class='fas fa-check-circle'></i>";
        }
}


//invoices
function timeCall($date) {
    setlocale(LC_TIME, 'fr', 'fr_FR');
    $h3=strtotime($date);
    return $date = ucfirst(strftime("%B %Y", $h3));
}  

function timeAdding($date) {
    setlocale(LC_TIME, 'fr', 'fr_FR');
    $h3=strtotime($date);
    return $date = utf8_encode(ucfirst(strftime("%d/%m/%y", $h3)));
} 

function statusInvoice($status) {
    if($status === "done") {
        return "far fa-check-square";
    } else {
        return "fas fa-sync-alt status-invoice";
    }
}
function statusModif($status) {
    if($status === "done") {
        return "far fa-check-square";
    } else {
        return "fas fa-sync-alt status-modif";
    }
}

function telFormat($tel){
    $num = str_replace(" ", "", $tel);    
    $a = substr($num, 0, 2);
    $b = substr($num, 2, 2);
    $c = substr($num, 4, 2);
    $d = substr($num, 6, 2);
    $e = substr($num, 8, 2);
    return $a . "." . $b . "." . $c . "." . $d . "." . $e;
}


function isPaid($status, $i, $year) {
    if($status === "Payé") {
        return "<i class='fa fa-check-circle'></i>";
    } elseif($status === "A payer") {
        return "<i class='fa fa-times-circle isPaid' data-month='$i' data-year='$year'></i>";
    } else {
        return "--";
    }
} 

function payementMethod($data) {
    if($data === "sepa") {
        return "<i class='fas fa-receipt text-secondary'></i>";
    } elseif($data === "CB") {
        return "<i class='fas fa-credit-card text-secondary'></i>";
    } else {
        return "<i class='fas fa-file-pdf text-secondary'></i>";
    }
}

function statusPause($pause) {
    if($pause === 'true') {
        return 'text-success';
    } else {
        return 'text-danger';
    }
}

function nameFormat($data) {
    return ucwords(strtolower(utf8_encode($data))); 
}

function getCurrMonth($date) {
    return substr(preg_replace("/[^0-9]/","",$date), 2, 2);
}