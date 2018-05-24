<?php
include '../secrets.php';
$conn = pg_connect ( $conn_sentence );

if( isset ($_POST["submit"]) ) {
  if( isset($_FILES["file"])) {
    //if there was an error uploading the file
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
      //Print file details
      /*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";*/
      $storagename = $_FILES["file"]["name"];
      //if file already exists
      if (file_exists("upload/" . $_FILES["file"]["name"])) {
        echo $_FILES["file"]["name"] . " already exists. ";
      } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
        echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
      }

      // Add to database
      if ( $file = fopen( "upload/" . $storagename , r ) ) {
        echo "File opened.<br />";
        $row = 1;
        $firstline = fgets ($file, 4096 );
        while ( $line[$i] = fgets ($file, 4096) ) {
          $dsatz[$i] = str_replace("\r", "", $line[$i]);
          $i++;
        }
        pg_copy_from($conn, "tsv_pokemon", $dsatz, ";");

      }
    }
  } else {
    echo "No file selected <br />";
  }
}


 ?>
<html>
<head>
  <title>Ajouter nouvelle fourn&eacute;e</title>
</head>
<body>
  <form action="#" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file"/><br/>
    <input type="submit" name="submit" value="Ajouter nouvelle fourn&eacute;e"/><br/>
  </form>
</body>
</html>
