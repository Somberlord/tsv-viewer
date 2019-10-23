<!DOCTYPE html>
<?php
include 'secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select * from tsv_user order by name");
$allusers = pg_fetch_all($queryres);
$queryresgn = pg_query($conn, "select distinct game_name from tsv_tsvnumber order by game_name");
$allgns = pg_fetch_all($queryresgn);

if( isset ($_POST["userid"]) ) {
  $userid = $_POST["userid"];
  $gameuser = $_POST["gamename"];
  $filtergame = "";
  $params = array($userid);
  if($gameuser != "") {
      $filtergame = "and tt.game_name = $2 ";
      $params = array($userid, $gameuser);
  }
  $tsvres = pg_query_params($conn, "select tu.name as username, tt.game_name as user_gamename, tt.tsvnumber as tsvnumber, tp.pokemon as pokemon, tp.game_name as gamename, tp.save_nb as save_nb, tp.box_nb as box_nb, tp.row as row, tp.line as line, tp.id_tsv as fournee, tt.gen as gen ".
                      "from tsv_user tu ".
                      "left join tsv_tsvnumber tt on tt.uuid = tu.uid ".
                      "left join tsv_pokemon tp on tp.esv = tt.tsvnumber and tp.gen = tt.gen ".
                      "where tu.uid = $1 ".
                      $filtergame.
                      "order by gen desc, fournee desc, save_nb, box_nb, line, row", $params);
  $alltsv = pg_fetch_all($tsvres);
  $totalsres = pg_query_params($conn, "select tt.game_name as gn, count(*) as nb ".
                      "from tsv_user tu ".
                      "left join tsv_tsvnumber tt on tt.uuid = tu.uid ".
                      "left join tsv_pokemon tp on tp.esv = tt.tsvnumber and tp.gen = tt.gen ".
                      "where tu.uid = $1 ".
                      $filtergame.
                      "group by gn ".
                      "order by gn ", $params);
  $alltotals = pg_fetch_all($totalsres);
}
?>
<html>
<head>
  <title>TSV 3DSInBordeaux</title>
  <style>
    tr:nth-child(even) {background: #CCC}
    tr:nth-child(odd) {background: #FFF}
  </style>
</head>
<body>
  <form action="#" method="post">
    Nom :
    <select name="userid"/><br/>
      <?php foreach ($allusers as $uid => $tsvvalue): ?>
        <option value="<? echo $tsvvalue['uid'] ?>"><? echo $tsvvalue['name'] ?></option>"
      <?php endforeach; ?>
    </select><br/>
    Jeu :
    <select name="gamename"/><br/>
        <option value="">Toutes</option>"
      <?php foreach ($allgns as $gnid => $gn): ?>
        <option value="<? echo $gn['game_name'] ?>"><? echo $gn['game_name'] ?></option>"
      <?php endforeach; ?>
    </select><br/>
    <input type="submit" value="R&eacute;cup&eacute;rer les TSV"/><br/>
  </form>
  <hr/>
  <?php if(isset ($alltsv)): ?>
  <?php foreach ($alltotals as $k => $valuetot): ?>
    Version <? echo $valuetot['gn'] ?>
      Total : <? echo $valuetot['nb'] ?><br/>
  <?php endforeach;?>
  <table>
    <tr>
      <td>Utilisateur</td>
      <td>Jeu utilisateur</td>
      <td>TSV Utilisateur</td>
      <td>Nom du pokemon</td>
      <td>Save</td>
      <td>Boite</td>
      <td>Ligne</td>
      <td>Colonne</td>
      <td>Jeu de generation</td>
    </tr>
    <?php foreach ($alltsv as $k => $value): ?>
      <tr>
        <td><? echo $value['username'] ?></td>
        <td><? echo $value['user_gamename'] ?></td>
        <td><? echo $value['tsvnumber'] ?></td>
        <td><? echo $value['pokemon'] ?></td>
        <td><? echo $value['save_nb'] ?></td>
        <td><? echo $value['box_nb'] ?></td>
        <td><? echo $value['line'] ?></td>
        <td><? echo $value['row'] ?></td>
        <td><? echo $value['gamename'] ?></td>
      </tr>
    <?php endforeach; endif;?>
  </table>
</body>
