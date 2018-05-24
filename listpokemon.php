<?php
include 'secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select distinct pokemon, id_tsv from tsv_pokemon order by id_tsv desc;");
$allusers = pg_fetch_all($queryres);
?>
<html>
<head>
  <title>Liste des TSV</title>
</head>
<body>
  <table>
    <tr>
      <th>Nom</th>
      <th>Fournee</th>
    </tr>

    <?php foreach ($allusers as $uid => $value): ?>
      <tr>
        <td><? echo $value['pokemon'] ?></td>
        <td><? echo $value['id_tsv'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
