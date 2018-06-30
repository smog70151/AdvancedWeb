<?php

  $url = explode("=", $_SERVER['HTTP_REFERER']);
  // $transpage = "http://140.114.212.79/AdvancedWeb-AS4/api/youtubeDL.php?urlYT=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D".$url[1]."&button=";
  header('Content-type: text/html; charset=utf-8');
  header('Vary: Accept-Language');

  # DEBUG MODE
  define ('DEBUG', true);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;
  # Source php
  include 'config/db.php';

  # GET Lyric JSON File


  $lyricJSON = $_POST['lyric'];
  #DB

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

  ## XML Parser and Send DATA to SQL

  $isInit = false;
  for ($i = 0; $i < sizeof($_POST["lyric"]); $i++) {
      list($start_min, $start_sec) = explode(":", $_POST['start_time'][$i]);
      list($end_min, $end_sec) = explode(":", $_POST['end_time'][$i]);
      $dur = ($end_min*60 + $end_sec) - ($start_min*60 + $start_sec);

      $startTime = $start_min*60 + $start_sec;
    if ($isInit == false):
      $sql_DELETE = 'DELETE FROM lyricsNET WHERE vid = "' . $url[1] . '"';
      $conn->query($sql_DELETE);

      $isInit = true;
    endif;

    $sql_TB = "INSERT INTO lyricsNET (id, vid, lang, start, dur, lyric) VALUES ";
    $sql_DATA = '("' . $i . '", "' . $url[1] . '", "' . 'en' . '", "' . $startTime . '", "' . $dur . '", "' . $_POST["lyric"][$i] . '")';
    $sql = $sql_TB . $sql_DATA;
    $conn->query($sql);    

    // echo "INSERT SQL is: " . $sql."<br>";
    // if (DEBUG):
    //   echo "INSERT SQL is: " . $sql;
    // endif;
    // if ($conn->query($sql) !== FALSE) {
    //   echo "The data created successfully. <br>";
    // } else {
    //   echo "Err: " . $sql . "<br>";
    // }

  }
  $transpage = "/AdvancedWeb-AS4/src/video.php?v=".$url[1];
  header("Location: $transpage");
  $conn->close();
?>
