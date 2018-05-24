<?php
include 'secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select * from tsv_user order by name");
$allusers = pg_fetch_all($queryres);

if( isset ($_POST["userid"]) ) {
  $userid = $_POST["userid"];
  $tsvres = pg_query_params($conn, "select tu.name as username, tt.game_name as user_gamename, tt.doid as doid, tp.pokemon as pokemon, tp.game_name as gamename, tp.save_nb as save_nb, tp.box_nb as box_nb, tp.row as row, tp.line as line, tp.id_tsv as fournee ".
                      "from tsv_user tu ".
                      "left join tsv_tsvnumber tt on tt.uuid = tu.uid ".
                      "left join tsv_pokemon tp on tp.esv = tt.tsvnumber and tp.gen = tt.gen ".
                      "where tu.uid = $1 ".
                      "order by fournee desc, save_nb, box_nb, row, line", array($userid));
  $alltsv = pg_fetch_all($tsvres);
}
?>
<html>
<head>
  <title>TSV 3DSInBordeaux</title>
</head>
<body>
  <form action="#" method="post">
    Nom :
    <select name="userid"/><br/>
      <?php foreach ($allusers as $uid => $tsvvalue): ?>
        <option value="<? echo $tsvvalue['uid'] ?>"><? echo $tsvvalue['name'] ?></option>"
      <?php endforeach; ?>
    </select><br/>
    <input type="submit" value="R&eacute;cup&eacute;rer les TSV"/><br/>
  </form>
  <hr/>
  <?php if(isset ($alltsv)): ?>
  <table>
    <tr>
      <td>Utilisateur</td>
      <td>Jeu utilisateur</td>
      <td>ID utilisateur</td>
      <td>Nom du pokemon</td>
      <td>Jeu de generation</td>
      <td>Numero de save</td>
      <td>Boite</td>
      <td>Ligne</td>
      <td>Colonne</td>
    </tr>
    <?php foreach ($alltsv as $k => $value): ?>
      <tr>
        <td><? echo $value['username'] ?></td>
        <td><? echo $value['user_gamename'] ?></td>
        <td><? echo $value['doid'] ?></td>
        <td><? echo $value['pokemon'] ?></td>
        <td><? echo $value['gamename'] ?></td>
        <td><? echo $value['save_nb'] ?></td>
        <td><? echo $value['box_nb'] ?></td>
        <td><? echo $value['line'] ?></td>
        <td><? echo $value['row'] ?></td>
      </tr>
    <?php endforeach; endif;?>
  </table>
</body>
