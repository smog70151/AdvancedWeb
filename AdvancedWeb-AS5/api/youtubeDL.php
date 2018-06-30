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
  if($urlYT != ""){
      if((strpos($urlYT, "v=")===false) && (strpos($urlYT, "list=")!==false)){
        $listID = explode("list=", $urlYT);
        $listID = $listID[1];
        infoDLplaylist($listID);
        //include '../src/playlist.php';
        include '../src/voicetube.php';
      } else {
        $videoID = explode("v=", $urlYT);
        if(strpos($videoID[1],'list=')){
            $videoID = explode("&index=", $videoID[1]);
            $videoID = $videoID[0];
        }else{
            $videoID = $videoID[1];
        }
        
        infoDL($videoID);
        lyricDL($videoID, $lang);
        include '../src/video.php';
        require("./lyricJSON.php");
        $lyricID = $videoID;
        $lyric_decode = json_encode($lyricJSON);
        echo "<script>
                window.onload = function () {
                 var mydata = ".$lyric_decode.";


                 var tbl = document.createElement('table');
                 var tbdy = document.createElement('tbody');

                 for (var cap in mydata) {

                     var tr = document.createElement('tr');
                     tbdy.appendChild(tr)
                     for (var i = 0; i < 2; i++) {
                         var td = document.createElement('td');
                         tr.appendChild(td);
                         if (i == 0) {
                             var ico = document.createElement('i');
                             td.appendChild(ico);
                             ico.setAttribute('class', 'fa fa-play-circle')
                         } else {
                             var p = document.createElement('p');
                             td.appendChild(p);
                             p.setAttribute('t', mydata[cap].start);
                             p.setAttribute('d', mydata[cap].dur);
                             p.innerHTML = mydata[cap].lyric;
                         }
                     }
                 }
                 tbl.appendChild(tbdy);
                 document.getElementsByClassName(\"caption\")[0].appendChild(tbl);
                 $('.col-md-5 p').click(function(event) {
                     player.loadVideoById({
                         videoId: v,
                         startSeconds: event.target.attributes[0].value / 1000,
                         endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value)) / 1000
                     });
                 })

                 init()

             }
             </script>";
      }
  } else {
    echo "<script>alert('請輸入 url'); location.href = 'http://140.114.212.79/AdvancedWeb-AS4/src/formDL.php';</script>";
  }



?>
