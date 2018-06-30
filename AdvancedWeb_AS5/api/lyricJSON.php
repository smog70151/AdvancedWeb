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

  ## RETRIEVE DATA FROM lyricsNET

  $lyricID;
  # $videoID = 'AP1Scjdy_Kc';

  $sql = 'SELECT * FROM lyricsNET WHERE vid = "' . $videoID . '"';

  $result = $conn->query($sql);

  if ($result !== FASLE) {
    # echo "Access data successfully. <br>";
  } else {
#    echo "Err: " . $sql . "<br>";
  }

  ## PARSE and ENCODE DATA in JSON File

  $lyricJSON = array();

  if (mysqli_num_rows($result) != 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $start = $row['start'];
      $dur = $row['dur'];
      $lyric = $row['lyric'];

      $lyricJSON[] = array("id" => $id, "start" => $start, "dur" => $dur, "lyric" => $lyric);
    }
    # return $lyricJSON;
    
  } else {
#    echo "Err: No lyrics in DB ! <br>";
  }

  # echo "0 result <br>";

?>
