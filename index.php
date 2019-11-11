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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
  <section class="section">
    <div class="container">
      <form action="#" method="post">
        <div class="field">
          <label class="field-label">Nom : </label>
          <div class="field-body">
            <div class="control">
              <div class="select is-fullwidth">
                <select name="userid">
                  <?php foreach ($allusers as $uid => $tsvvalue): ?>
                    <option value="<? echo $tsvvalue['uid'] ?>"><? echo $tsvvalue['name'] ?></option>"
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="field-label">Jeu : </label>
          <div class="field-body">
            <div class="control">
              <div class="select is-fullwidth">
              <select name="gamename"/><br/>
                  <option value="">Toutes</option>"
                <?php foreach ($allgns as $gnid => $gn): ?>
                  <option value="<? echo $gn['game_name'] ?>"><? echo $gn['game_name'] ?></option>"
                <?php endforeach; ?>
              </select>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="button is-link" type="submit" value="R&eacute;cup&eacute;rer les TSV"/>
          </div>
        </div>
      </form>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <?php if(isset ($alltsv)): ?>
      <?php foreach ($alltotals as $k => $valuetot): ?>
      <div class="content">Version <? echo $valuetot['gn'] ?>
        Total : <? echo $valuetot['nb'] ?></div>
      <?php endforeach;?>
      <table class="table is-hoverable is-narrow is-striped">
        <thead>
          <tr>
            <th>Utilisateur</th>
            <th>Jeu utilisateur</th>
            <th>TSV Utilisateur</th>
            <th>Nom du pokemon</th>
            <th>Save</th>
            <th>Boite</th>
            <th>Ligne</th>
            <th>Colonne</th>
            <th>Jeu de generation</th>
          </tr>
        </thead>
        <tbody>
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
        </tbody>
      </table>
    </div>
  <section>
</body>
