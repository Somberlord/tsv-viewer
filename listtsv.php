<?php
include 'secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select * from tsv_user tu left join tsv_tsvnumber tt on tt.uuid = tu.uid order by tu.name, tt.gen");
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
      <th>TSV</th>
      <th>Jeu</th>
      <th>Gen</th>
      <th>ID</th>
      <th>Pseudo</th>
    </tr>

    <?php foreach ($allusers as $uid => $value): ?>
      <tr>
        <td><? echo $value['name'] ?></td>
        <td><? echo $value['tsvnumber'] ?></td>
        <td><? echo $value['game_name'] ?></td>
        <td><? echo $value['gen'] ?></td>
        <td><? echo $value['doid'] ?></td>
        <td><? echo $value['nickname'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
