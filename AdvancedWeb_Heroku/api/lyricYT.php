<?php

  header('Content-type: text/html; charset=utf-8');
  header('Vary: Accept-Language');

  # DEBUG MODE
  define ('DEBUG', false);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;
  # Source php
  include 'config/db.php';

  function lyricDL($videoID = 'tCXGJQYZ9JA', $lang = 'en') {

    $urlYT = 'http://www.youtube.com/watch?v='. $videoID;

    # Get Video HTML Tag

    $videoYT = file_get_contents($urlYT);

    # Method 1 - This method have a little bug, it needs to slipt out default lang from the other side.

    // $sep1 = explode('TTS_URL', $videoYT);
    // $sep2 = explode(' ', $sep1[1]);
    // $sep3 = explode(",", $sep2[1]);
    // $tt = $sep3[0];
    // Encoding - Unicode - ASCII

    // $ttURL = str_replace("u0026", "&", $tt);
    // $ttURL = str_replace("\/", "/", $ttURL);
    // $ttURL = str_replace("\\", "", $ttURL);
    // $ttURL = $ttURL. "&lang=ja";
    // $tt = explode('"', $ttURL);
    // $ttURL = $tt[1]. $tt[2];
    // echo $videoYT;

    # Method 2 - This method can get YT captions with $lang

    $sep1 = explode('baseUrl', $videoYT);
    $tt = '';


    foreach ($sep1 as &$el) {
      $isLang = 'lang=' . $lang;
      if (strpos($el, $isLang) !== false) {
        $tt = $el;
      }
    }

    $sep2 = explode(',', $tt);
    $sep3 = explode('"', $sep2[0]);
    $ttURL = $sep3[2];
    $ttURL = str_replace('u0026', '&', $ttURL);
    $ttURL = str_replace("\/", "/", $ttURL);
    $ttURL = str_replace("\\", "", $ttURL);


    # check if auto-gen
    $flag = file_get_contents($ttURL);
    if(strpos($flag, 'font') === false){
 
    # Get YT timedtext xml
    if(simplexml_load_file($ttURL)){
      $ttXML =  simplexml_load_file($ttURL);

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

      $id = 0;

      foreach ($ttXML->children() as $lyrics) {
        $sql_TB = "INSERT INTO lyricsNET (id, vid, lang, start, dur, lyric) VALUES ";
        if (DEBUG):
          echo $lyrics['start'] . "<br>";
          echo $lyrics['dur'] . "<br>";
          echo $lyrics . "<br>";
          echo $sql_TB . "<br>";
        endif;
        $sql_DATA = '("' . $id . '", "' . $videoID . '", "' . $lang . '", "' . $lyrics['start'] . '", "' . $lyrics['dur'] . '", "' . $lyrics . '")';
        $sql = $sql_TB . $sql_DATA;
        if ($conn->query($sql) !== FALSE) {
          // echo "The data created successfully. <br>";
        } else {
          # echo "Err: " . $sql . "<br>";
        }
        $id = $id + 1;

      }

      $conn->close();
    }
 }
    # echo "Done <br>";

  }

?>
