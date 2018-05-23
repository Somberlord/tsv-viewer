<?php
include '../secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select * from tsv_user");
$allusers = pg_fetch_all($queryres);

if( isset ($_POST["newname"]) ) {
  $username = $_POST["newname"];
  $queryresinsert = pg_query_params($conn, "insert into tsv_user(name) values($1)", array($username));
  if($queryresinsert === FALSE) {
    echo "Erreur lors de l'ajout";
  } else {
    echo "Utilisateur $username ajout&eacute; avec succ&egrave;s";
  }
} elseif ( isset($_POST["newtsv"]) && isset($_POST["userid"]) && isset($_POST["gen"])) {
  $userid = $_POST["userid"];
  $newtsv = $_POST["newtsv"];
  $generation = $_POST["gen"];
  $queryresinsert = pg_query_params($conn,
                "insert into tsv_tsvnumber(uuid, tsvnumber, gen) values($1, $2, $3)",
                array($userid, $newtsv, $generation));
  if($queryresinsert === FALSE) {
    echo "Erreur lors de l'ajout";
  } else {
    echo "TSV $newtsv ajout&eacute; avec succ&egrave;s";
  }
}
?>
<html>
<head>
  <title>Nouvel utilisateur TSV</title>
</head>
<body>
  <hr/>
  <form action="#" method="post">
    Nom : <input type="text" name="newname"/><br/>
    <br/>
    <input type="submit" value="Ajouter nouvel utilisateur"/><br/>
  </form>
  <hr/>
  <form action="#" method="post">
    Nom :
    <select name="userid"/><br/>
      <?php foreach ($allusers as $uid => $tsvvalue): ?>
        <option value="<? echo $tsvvalue['uid'] ?>"><? echo $tsvvalue['name'] ?></option>"
      <?php endforeach; ?>
    </select><br/>
    TSV : <input type="number" name="newtsv"/><br/>
    G&eacute;n&eacute;ration : <input type="number" name="gen"/><br/>
    <br/>
    <input type="submit" value="Ajouter nouveau tsv"/><br/>
  </form>

</body>
</html>
