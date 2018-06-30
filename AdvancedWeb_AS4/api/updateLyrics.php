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



  function updateLyrics($vid, $id, $start, $end, $lyric, $lang = 'en') {
    
    
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
    $max = 0;
    $sql = 'SELECT * FROM lyricsNET WHERE vid = "' . $vid . '"';
    
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if($row['id'] > $max) {
            $max = $row['id'];
        }
    }
    
    echo $max;

    $dur = $end - $start;
    if($id <= $max) {
        $sql = 'UPDATE lyricsNET SET lang = "'. $lang . '" , start =  "' . $start . '" , dur = "' . $dur . '" , lyric = "' . $lyric . '" WHERE id = ' . $id . ' , vid = "' . $vid . '"';
        echo $sql;
    }else {
        $dur = $end - $start;
        $sql_TB = "INSERT INTO lyricsNET (id, vid, lang, start, dur, lyric) VALUES ";
        $sql_DATA = '("' . $id . '", "' . $vid . '", "' . $lang . '", "' . $start. '", "' . $dur . '", "' . $lyric . '")';
        $sql = $sql_TB . $sql_DATA;
        echo $sql;
    }

    $result = $conn->query($sql);

    if ($result !== FASLE) {
        echo "Access data successfully. <br>";
    } else {
        echo "Err: " . $sql . "<br>";
    }



    //echo $row['COUNT(*)'];
    // $lyricID;
    // # $videoID = 'AP1Scjdy_Kc';

    // $sql = 'SELECT * FROM lyricsNET WHERE vid = "' . $videoID . '"';

    // $result = $conn->query($sql);

    // if ($result !== FASLE) {
    //     echo "Access data successfully. <br>";
    // } else {
    //     echo "Err: " . $sql . "<br>";
    // }

    // ## PARSE and ENCODE DATA in JSON File

    // $lyricJSON = array();

    // if (mysqli_num_rows($result) != 0) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //     $id = $row['id'];
    //     $start = $row['start'];
    //     $dur = $row['dur'];
    //     $lyric = $row['lyric'];

    //     $lyricJSON[] = array("id" => $id, "start" => $start, "dur" => $dur, "lyric" => $lyric);
    //     }
    //     # return $lyricJSON;
        
    // } else {
    // #    echo "Err: No lyrics in DB ! <br>";
    // }         

  # echo "0 result <br>";
  }

  updateLyrics('_dNSCAr8tfw', 40, 10, 20, 'test');
?>
