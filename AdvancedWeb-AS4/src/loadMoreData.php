<?php
   require('../api/config/db.php');
   $mysqli = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
   $sql = "SELECT * FROM videosNET
          WHERE id < '".$_GET['last_id']."' ORDER BY id DESC LIMIT 12"; 

    $result = $mysqli->query($sql);

   $json = include('data.php');


   echo json_encode($json);
?>