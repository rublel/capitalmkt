<?php
require('../functions/functions.php');
if(!empty($_POST)) {
    extract($_POST);
}
?>

  <form id="form">
      <span class="d-none" id="id"><?= $id ?></span>
      <?php
       echo inputForm('Debut', 'start', 'time', $str);
       echo inputForm('Fin', 'start', 'time', $end);
      ?>
      <button class="btn btn-primary mt-2" type="submit">Enregistrer</button>
  </form>


  <script>
      $("#form button").on('click', function(e) {
        e.preventDefault();
        let id = $('#id').text()
        let str = $($('input')[1]).val()
        let end = $($('input')[2]).val()
        $.ajax({
            type: 'POST',
            url: './controllers/updateTime.php',
            data: {id, str, end},
            success: function() {
                $('#dataModal').modal("hide");
                $.notify("Modification enregistré", "success")
            }
        })
    });
  </script>