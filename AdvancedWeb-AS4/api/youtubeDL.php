<?php

# DEBUG MODE
define ('DEBUG', false);
if (DEBUG):
    ini_set( "display_errors", "1" );
endif;

#Source php
require("./infoYT.php");
require("./lyricYT.php");
require("./infoYTplaylist.php");

# Get src
$urlYT = $_GET[urlYT];

if (DEBUG):
    echo $urlYT . "<br>";
endif;

# Default LANG
$lang = 'en';

# check whether list or video and set VALUE and get INFO
if((strpos($urlYT, "v=")!==false) && (strpos($urlYT, "list=")!==false)){
    $listID = explode("list=", $urlYT);
    $listID = $listID[1];
    infoDLplaylist($listID);
    header('location: http://140.114.212.79/AdvancedWeb-AS4/src/voicetube.php');
    // include '../src/playlist.php';
} else if((strpos($urlYT, "v=")!==false) && (strpos($urlYT, "list=")===false)){
    $videoID = explode("v=", $urlYT);
    if(strpos($videoID[1],'list=')){
        $videoID = explode("&index=", $videoID[1]);
        $videoID = $videoID[0];
    }else{
        $videoID = $videoID[1];
    }


    infoDL($videoID);
    lyricDL($videoID, $lang);
    header('location: http://140.114.212.79/AdvancedWeb-AS4/src/voicetube.php');
} else if((strpos($urlYT, "v=")===false) && (strpos($urlYT, "list=")!==false)){
    $listID = explode("list=", $urlYT);
    $listID = $listID[1];
    infoDLplaylist($listID);
    header('location: http://140.114.212.79/AdvancedWeb-AS4/src/voicetube.php');
    //include '../src/playlist.php';
} else {
    echo "<h1>網址不正確</h1>";
}

?>
