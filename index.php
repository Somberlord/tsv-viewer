<?php
include 'secrets.php';
$conn = pg_connect ( $conn_sentence );
$queryres = pg_query($conn, "select * from tsv_user");
print_r( pg_fetch_all($queryres));
?>
