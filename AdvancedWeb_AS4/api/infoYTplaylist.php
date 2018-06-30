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
//  include './lyricYT.php';

  function infoDLplaylist($listID = 'PL3FW7Lu3i5JvHM8ljYj-zLfQRF3EO8sYv') {
    $urlYT = 'http://www.youtube.com/playlist?list='. $listID;

    # Get Video HTML Tag

    $listYT = file_get_contents($urlYT);

    //if (strpos('subtitles_xlb', $listYT) === false) exit();
    // else {
    //     if (strpos('自動產生', $listYT) === false) exit();
    //     if (strpos('auto-generated', $listYT) === false) exit();
    // }


    $sep1 = explode('<tbody id="pl-load-more-destination">', $listYT);
    $sep2 = explode('</tbody>', $sep1[1]);

    $videoList = $sep2[0];
    $listSize = substr_count($videoList, '</tr>');

    $sep1 = explode('<title>', $listYT);
    $sep2 = explode('</title>', $sep1[1]);
    $listTitle = $sep2[0];

    # delete the first element (it's empty)
    $vidList = explode('<tr',$videoList);
    unset($vidList[0]);


    $vids = [];
    $vtitles =[];
    $vcount = 0;

    foreach($vidList as $video){
        # extract VID
        $start = strpos($video, 'data-video-id="') + 15;
        $length = strpos($video, '"', $start) - $start;
        $src = substr($video, $start, $length);
        $vids[$vcount] = $src;

        # extract VTITLE
        $start = strpos($video, 'data-title="') + 12;
        $length = strpos($video, '"', $start) - $start;
        $src = substr($video, $start, $length);
        $vtitles[$vcount] = $src;

        $vcount += 1;
    }

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

    ### store list info in playlistsNET

    ## Check Duplicate
    $sql = 'SELECT * FROM playlistsNET where playlistID = "' . $listID . '"';
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    if ($result !== FALSE) {
        $row_cnt = $result->num_rows;
    } else {
       // echo "Err: " . $sql . "<br>";
    }

    if($row_cnt !== 0) {
        $row = mysqli_fetch_assoc($result);

        if( $row['playlistID'] === $listID ) {
           // echo "found duplicate playist: " . $listID . '<br>';
        }
    }


    $sql_TB = "INSERT INTO playlistsNET (userID, playlistID, playlistTitle) VALUES ";
    $sql_DATA = '(1, "' . $listID . '", "' . $listTitle . '")';
    $sql = $sql_TB . $sql_DATA;

    $result = $conn->query($sql);

    if ($result !== FASLE) {
        # echo "The data created successfully. <br>";
    } else {
       // echo "Err: " . $sql . "<br>";
    }

    # Select cur playlist ID
    $sql = "SELECT * FROM playlistsNET ORDER BY pID DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $pID = $row['pID'];

    for($i = 0; $i < $listSize; $i++){
        lyricDL($vids[$i], 'en');
        ### store videos in videosNET

        ## Check Duplicate
        $sql = 'SELECT * FROM videosNET where vid = "' . $vids[$i] . '"';

        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

        if ($result !== FALSE) {
            # echo "The data created successfully. <br>";
        } else {
         //   echo "Err: " . $sql . "<br>";
        }
        $row = mysqli_fetch_assoc($result);

        if ($row['vid'] === $vids[$i]) {
            //exit();
           // echo "found duplicate video: " . $vids[$i] . '<br>';
           //continue;
        }

        ## select - LAST ID

        # $sql = "SELECT * FROM videosNET ORDER BY id DESC LIMIT 1";

        ## videosNET (id, vid, title) - id is auto INCR
        ### store videos in videosNET
        $sql_TB = "INSERT INTO videosNET (vid, title) VALUES ";
        $sql_DATA = '("' . $vids[$i] .  '", "' . $vtitles[$i] . '")';
        $sql = $sql_TB . $sql_DATA;

        $result = $conn->query($sql);

        if ($result !== FASLE) {
            //echo "The data created successfully. <br>";
        } else {
           // echo "Err: " . $sql . "<br>";
        }

        ### store videos in playlistsDATA
        $sql_TB = "INSERT INTO playlistsDATA (pID, vID, playlistID) VALUES ";
        $sql_DATA = '("' . $listID . '", "' . $vids[$i] . '", "'. $pID . '")';
        $sql = $sql_TB . $sql_DATA;
        //echo $sql, '<br>';
        $result = $conn->query($sql);

        if ($result !== FASLE) {
            //echo "The data created successfully. <br>";
        } else {
            //echo "Err: " . $sql . "<br>";
        }

    }
    $conn->close();

}

?>
