<?php
setlocale(LC_TIME, 'fr', 'fr_FR'); 
class Month {
    function getCurrentMonth($i) {
            return "<option value=$i>".utf8_encode(ucfirst(strftime("%B", strtotime("$i/".date('y')))))."</option>";
    }
    function getMonth() {
        echo "<option value=''>--</option>";
        for($i = 1; $i < 13; $i++) {
            ($i >= 10 ? $i = $i : $i = "0". $i);
            echo $this->getCurrentMonth($i);
        }
    }
}
$months = new Month();

class ItemFormat {

    function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    function DisplayIsJson($str) {
        if($this->isJSON($str)){
            return true;
        } else {
            return false;
        }
    }

    function displayItem ($item) {
        if($this->DisplayIsJson($item)) {
            return "<i class='fas fa-times-circle'></i>";
        } elseif(empty($item)) {
            return "--";
        } elseif(substr($item, -2) === "AP") {
            return "?";
        } else {
            return $item;
        }
    }

    function getTH () {
        for($i = 1; $i < 13; $i++) { 
            ($i >= 10 ? $i = $i : $i = "0". $i);
            echo "<th class='text-center'>".utf8_encode(substr(ucfirst(strftime("%B", strtotime($i."/22"))), 0, 3))."</th>";
        }
    }
}
