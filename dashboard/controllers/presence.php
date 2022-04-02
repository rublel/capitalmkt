
<?php
setlocale(LC_TIME, 'fr', 'fr_FR');
require('../functions/functions.php');
require('../../database/database.php');
$dbs = Databases::connect();
$isUser = false;
$currM = $_GET['m'];
if(!empty($_POST)) {
    extract($_POST);
    if(!empty($user)) {
        $query = " WHERE user = '$user' ";
        $isUser = true;
    }
}
$statement = $dbs->query("SELECT * FROM presence $query ORDER BY id DESC");
$users = $dbs->query("SELECT * FROM users WHERE role = 'user'");
?>

<div class="card mt-2 mb-2 bg-light" id="filterForm">
    <div class="card-header bg-secondary text-white text-center">FILTRE</div>
    <div class="card-body">
        <form id="form">
            <div class="row mb-3">
                <div class="col-lg-6">
                    <select class="form-select" id="user">
                        <option><?= (empty($_GET['u']) ? "Employé" : $_GET['u']) ?></option>
                        <?php while($u = $users->fetch()) { ?>
                            <option><?= $u['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6">
                    <select class="form-select" id="month">
                        <option value=<?= empty($currM) ? date('m') . "/" . date('Y') : $currM . "/" . date('Y') ?>>
                            <?= (empty($currM) ? utf8_encode(ucfirst(strftime("%B", strtotime(date('m')."/22")))) : utf8_encode(ucfirst(strftime("%B", strtotime("$currM/22"))))) ?>
                        </option>
                        <?php for($i = 1; $i < 13; $i++) { 
                            ($i >= 10 ? $s = $i : $s = "0".$i)
                        ?>
                        <option value=<?= $s ."/". date('Y') ?>><?= utf8_encode(ucfirst(strftime("%B", strtotime("$s/22")))); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary">Appliquer</button>
        </form>
    </div>
</div>
<div class="card bg-light mb-2">
    <div class="card-header bg-secondary text-white text-center">PRESENCE</div>
    <div class="card-body">
    <table class="table table-striped">
        <thead class="bg-warning">
            <tr>
                <th><?= (!$isUser ?  utf8_encode(ucfirst(strftime("%B", strtotime(date('m')."/22")))) : "Date") ?></th>
                <th><?= (!$isUser ? "Nom" : "") ?></th>
                <th colspan="2">Horraire</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($q = $statement->fetch()) { 
                if($mois === getCurrMonth($q['date'])) {
            ?>
            <tr class="rows">
                <td class="date-td"><?= $q['date'] ?></td>
                <td><?= (!$isUser ? $q['user'] : "") ?></td>
                <td class="editable start"><?= substr($q['debut'], 0, 5) ?></td>
                <td class="editable end"><?= substr($q['fin'], 0, 5) ?></td>
                <td><?= $q['total'] ?></td>
                <td data-id=<?= $q['id'] ?> class="text-end">
                    <i class="fa fa-pause-circle pause <?= statusPause($q['pause']) ?>"></i>
                    <i class="fa fa-edit updateTime"></i>
                    <i class="fa fa-trash delete"></i>
                </td>
            </tr>
        <?php
            $total += $q['total'];
        } }?>
        </tbody>
    </table>
</div>
</div>
<?php if(!empty($user)) { ?>
    <div class="card bg-light mt-2 mb-2">
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th>JOURS</th>
                <th id="numDays" class="text-end"></th>
            </tr>
            <tr>
                <th>HEURES</th>
                <th class="text-end"><?= $total ?></th>
            </tr>
            <tr>
                <th>FIXE</th>
                <th class="text-end"><?= $total*32 ?></th>
            </tr>
        </table>
    </div>
</div>
<?php } ?>

<style>
</style>

<script>
$(document).ready(function () {
    let tr = $('.rows').length
    if(tr < 1) {
        $('.table').html('<p class="alert alert-primary"><i class="fa fa-exclamation-circle text-primary"></i> Aucun horraire a afficher</p>')
    }
    $('#numDays').html(tr)
    $("#form").on('submit', function (e) {
        e.preventDefault();
        let val = $('.form-select')
        let arr = [];
        val.map((i,e)=>arr.push(e.value))
        let user = arr[0];
        let mois = arr[1].substr(0, 2);
        let datetd = $('.date-td')
        datetd.select();
        document.execCommand("copy");
        datetd.map((i, e)=>{
            let month = e.textContent.match(/\d+/g).join('').substr(2, 2)
            console.log(month);
        })
        $.ajax({
            type: 'POST',
            url: './controllers/presence.php?u='+user+'&m='+mois,
            data: {user, mois},
            success: (data) => {
                $('#table').html(data)
            }
        })

    });
    $(".pause").on('click', function (e) {
        e.preventDefault();
        let id = $(this).parent().attr('data-id')
        let pause = confirm('Voulez-vous attribuer une pause ?')
        if(pause) {
            $.ajax({
                type: 'POST',
                url: './controllers/pause.php',
                data: {id},
                success: () => {
                    $.notify("Pause enregistré", "success")
                }
            })
        }
    });
    $(".delete").on('click', function (e) {
        e.preventDefault();
        let id = $(this).parent().attr('data-id')
        let table = "presence";
        let pause = confirm('Voulez-vous supprimer cet enregistrement ?')
        if(pause) {
            $.ajax({
                type: 'POST',
                url: './controllers/delete.php',
                data: {id, table},
                success: () => {
                    $.notify("Enregistement supprimé", "error")
                }
            })
        }
    });
    $(".updateTime").on('click', function () {
        let id = $(this).parent().attr('data-id')
        let str = $(this).parent().parent().find('td.start').html()
        let end = $(this).parent().parent().find('td.end').html()
        $.ajax({
            type: 'POST',
            url: './controllers/timeForm.php',
            data: {id, str, end},
            success: function(data) {
                $('#dataModal h4').html('<i class="fas fa-edit text-primary"></i> Modifier');
                $('#dataModal').modal("show");
                $('#employee_detail').html(data);
            }
        })
    });
});
</script>
