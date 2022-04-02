<?php
require('../functions/functions.php');
require('../classes/class.php');
require('../../database/database.php');
$dbs = Databases::connect();
$query = '';
$user = '';
if(!empty($_GET['u'])) {
    $user = $_GET['u'];
    if($user === "total") {
        $user = "";
        $query = "";
    } else {
        $query = " AND proprietaire = '$user'";
        ($user === 'david' ? $query = '' : $query = $query);
    }
}
$statement = $dbs->query("SELECT DISTINCT(activite) as act FROM clients2022 WHERE status_presta = 'client' $query ORDER BY act");
$users = $dbs->query("SELECT * FROM users WHERE comm = 1");
$table = new ItemFormat();
?>
<div class="card mt-2 mb-2 bg-light" id="filterForm">
    <div class="card-header bg-secondary text-white text-center">FILTRE</div>
    <div class="card-body">
        <form id="formCompte">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <select class="form-select" id="user">
                        <option><?= (empty($_GET['u']) ? "Total" : ucfirst($_GET['u'])) ?></option>
                        <option>Total</option>
                        <?php while($u = $users->fetch()) { ?>
                            <option><?= $u['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary">Appliquer</button>
        </form>
    </div>
</div>
<script src="./js/compte.js"></script> 
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-white text-center">GRAPHIQUE</div>
    <div class="card-body">
        <div id="chart_div"></div>
    </div>
</div> 
<div class="card bg-light mt-2 mb-2">
    <div class="card-header bg-secondary text-white text-center">COMPTES</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="bg-warning">
                    <tr>
                        <th>Activite</th>
                        <?= $table->getTH(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while($q = $statement->fetch()) {
                        $act = $q['act'];
                    ?>
                    <tr>
                        <td><?= ucwords($act) ?></td>
                        <?php
                            for($i = 1; $i < 13; $i++) {
                                ($i >= 10 ? $s = "m" . $i : $s = "m0" . $i);
                                $sum = $dbs->query("SELECT sum($s) as mois FROM clients2022 WHERE activite = '$act' $query");
                                while($r = $sum->fetch()) { ?>
                                    <td class="<?=$s?> text-center"><?= commission($user, $act, $r['mois']) ?> €</td>
                                <?php }
                            }
                        ?>
                    </tr>
                    <?php } ?>
                    <tr class="bg-secondary">
                        <td class="text-white">TOTAL</td>
                        <?php
                            for($i = 1; $i < 13; $i++) {
                                ($i >= 10 ? $s = "m" . $i : $s = "m0" . $i);
                            ?>
                            <td id=<?= $s ?> class="totalMonth text-center text-white"></td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $("#formCompte").on('submit', function (e) {
        e.preventDefault();
        let val = $('#user')
        let arr = [];
        val.map((i,e)=>arr.push(e.value.split(' ')[0].toLowerCase()))
        let user = arr[0]
        $.ajax({
            type: 'POST',
            url: './controllers/comm.php?u='+user,
            data: {user},
            success: (data) => {
                $('#table').html(data)
            }
        })
    });
</script>