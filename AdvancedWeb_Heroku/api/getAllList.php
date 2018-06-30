<?php

  header('Content-type: text/html; charset=utf-8');
  header('Vary: Accept-Language');

  # DEBUG MODE
  define ('DEBUG', false);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;

  # Source php
  include './config/db.php';

  # DB - conn
  $hostname = DBHOST;
  $username = DBUSER;
  $password = DBPWD;
  $dbname   = DBNAME;

  $conn = new mysqli($hostname, $username, $password, $dbname);

  if ($conn->connect_error) {
    die('Connect Error: ' . $conn->connect_error);
  }

  ## Set UTF-8 ENCODE

  $conn->set_charset("utf-8");

  mysqli_query($conn, "SET NAMES UTF8");

  $playlist = [];
  ## Check Duplicate
  $sql = 'SELECT playlistID FROM playlistsNET';
  $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

  if (mysqli_num_rows($result) != 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $listID = $row['playlistID'];
        $playlist[] = array("playlistID" => $listID);
      }
      echo json_encode($playlist);
    } else {
      # echo " Err: No lyrics in DB ! <br> ";
    }

  $conn->close();

?>
