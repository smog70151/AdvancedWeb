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


  function infoDL($videoID = 'tCXGJQYZ9JA') {
    
    # method 1
    // $urlYT = 'http://www.youtube.com/watch?v='. $videoID;

    // # Get Video HTML Tag

    // $videoYT = file_get_contents($urlYT);

    // if (strpos('subtitles_xlb', $videoYT) === false) return false;
    // else {
    //     if (strpos('自動產生', $videoYT) === false) return false;
    //     if (strpos('auto-generated', $videoYT) === false) return false;
    // }


    // print_r($videoYT);
    // $sep1 = explode('<title>', $videoYT);
    // $sep2 = explode('</title>', $sep1[1]);


    // $title = $sep2[0];

  # method 2
    $videoTitle = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$videoID."&key=AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0&fields=items(id,snippet(title),statistics)&part=snippet,statistics");
    // despite @ suppress, it will be false if it fails
    if ($videoTitle) {
      $json = json_decode($videoTitle, true);
      
      $title = $json['items'][0]['snippet']['title'];
    } else {
      return false;
    }

    # $img = "https://img.youtube.com/vi/" . $videoID . "/default.jpg";

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

    ## Check Duplicate

    $sql = 'SELECT * FROM videosNET where vid = "' . $videoID . '"';
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    if ($result !== FALSE) {
      # echo "The data created successfully. <br>";
    } else {
      # echo "Err: " . $sql . "<br>";
    }
    $row = mysqli_fetch_assoc($result);
    if ($row['vid'] !== $videoID) {
      //exit();
      //return ;
    

    ## select - LAST ID

    # $sql = "SELECT * FROM videosNET ORDER BY id DESC LIMIT 1";

    ## videosNET (id, vid, title) - id is auto INCR

      $sql_TB = "INSERT INTO videosNET (vid, title) VALUES ";
      $sql_DATA = '("' . $videoID .  '", "' . $title . '")';
      $sql = $sql_TB . $sql_DATA;
      //echo $title;
      $result = $conn->query($sql);

      if ($result !== FASLE) {
        echo "The data created successfully. <br>";
      } else {
        echo "Err: " . $sql . "<br>";
      }
    }
    $conn->close();

    return true;

  }
 

?>
