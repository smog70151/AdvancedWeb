<?php

  # DEBUG MODE
  define ('DEBUG', false);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;

  # ENV.
  header('content-type:application/json;charset=utf8');
  ini_set("allow_url_fopen", 1);

  # Source php
  include './config/db.php';

  # DB - conn
  $hostname = DBHOST;
  $username = DBUSER;
  $password = DBPWD;
  $dbname   = DBNAME;

  $conn = new mysqli ($hostname, $username, $password, $dbname);

  if ($conn->connect_error) {
    die('Connect Error: ' . $conn->connect_error);
  }

  ## Set UTF-8 ENCODE

  $conn->set_charset("utf-8");

  mysqli_query($conn, "SET NAMES UTF8");

  //$listID = 'PLYH8WvNV1YEnYtfmH-sGRRfCcVhwA7TDD';
  $listID = $_GET["playlistID"];
  $pID = $_GET["pID"];
  $videolist = array();
  $sql = 'SELECT * FROM playlistsNET WHERE playlistID = "' . $listID . '" AND ' . 'pID = ' . $pID;
  $result = $conn->query($sql);
  if ($result !== FASLE) {
    # echo "Access data successfully. <br>";
  } else {
    //echo "Err: " . $sql . "<br>";
  }
  $row = mysqli_fetch_assoc($result);

  $playlistTitle = $row['playlistTitle'];
  $videolist[] = array("playlistTitle" => $playlistTitle);
  ## RETRIEVE DATA FROM lyricsNET
  

  $sql = 'SELECT * FROM playlistsDATA WHERE pID = "' . $listID . '" AND' . ' playlistID = ' . $pID;
  $result = $conn->query($sql);

  if ($result !== FASLE) {
    # echo "Access data successfully. <br>";
  } else {
    //echo "Err: " . $sql . "<br>";
  }

  ## PARSE and ENCODE DATA in JSON File



  if (mysqli_num_rows($result) != 0) {
    while ($row = mysqli_fetch_assoc($result)) {

      $videoID = $row['vID'];

      # fetch video title
      $sql = 'SELECT * FROM videosNET WHERE vid = "' . $videoID . '"';
      $result2 = $conn->query($sql);
      if ($result2 !== FASLE) {
        # echo "Access data successfully. <br>";
      } else {
      //  echo "Err: " . $sql . "<br>";
      }

      $row2 = mysqli_fetch_assoc($result2);
      $videoTitle = $row2['title'];
      $videolist[] = array("videoID" => $videoID, "videoTitle" => $videoTitle);

    } 
    # return $lyricJSON;
    echo json_encode($videolist);
  } else {
#    echo "Err: No lyrics in DB ! <br>";
  }



?>

