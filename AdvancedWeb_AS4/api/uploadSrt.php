<title>File_Upload</title>
     <meta http-equiv="content-type" charset="UTF-8"/>


     <h1>檔案上傳</h1>
         <?php
            header('Content-type: text/html; charset=utf-8');
            header('Vary: Accept-Language');
 
              # DEBUG MODE
            define ('DEBUG', true);
            if (DEBUG):
                ini_set( "display_errors", "1" );
            endif;
              # Source php
            include 'config/db.php';
            //include 'youtubeDL.php';

            define('SRT_STATE_SUBNUMBER', 0);
            define('SRT_STATE_TIME',      1);
            define('SRT_STATE_TEXT',      2);
            define('SRT_STATE_BLANK',     3);

            $lines   = file($_FILES['upload-file']['tmp_name']);
            //echo $lines;
            $subs    = array();
            $state   = SRT_STATE_SUBNUMBER;
            $subNum  = 1;
            $subText = '';
            $subTime = '';

            $subs = array();
            $flag = false;
            foreach($lines as $line) {
                //echo "line: " .$line . " state: " . $state .  '<br>';
                switch($state) {
                    case SRT_STATE_SUBNUMBER:
                        $subNum = trim($line);
                        $state  = SRT_STATE_TIME;
                        break;

                    case SRT_STATE_TIME:
                        $subTime = trim($line);
                        $state   = SRT_STATE_TEXT;
                        break;

                    case SRT_STATE_TEXT:
                        if (trim($line) == '') {
                            $time = explode(' --> ', $subTime);
                            if($subText == '' && $flag){
                                $flag = false;
                                $state = SRT_STATE_TEXT;

                            }else {
                                $flag = true;
                                $state = SRT_STATE_SUBNUMBER;
                                $subs[] = array('number' => $subNum, 'startTime' => $time[0], 'stopTime' => $time[1], 'text' => $subText);
                                $subText     = '';
                            }



                        } else {

                            $subText .= $line;
                        }
                        break;
                }
            }

            if ($state == SRT_STATE_TEXT) {
                // if file was missing the trailing newlines, we'll be in this
                // state here.  Append the last read text and add the last sub.
                $sub = $subText;
                // $sub->text = $subText;
                $subs[] = $sub;
            }
            //print_r($subs);

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

            $vid = $_POST['id'];
            $lang = 'en';

            foreach($subs as $line) {
                //echo $id . '<br>';
                $id = (int)$line['number'];
                $start = timeP($line['startTime']);
                $end = timeP($line['stopTime']);
                $dur = $end - $start;
                $dur = (string)$dur;
                $text = $line['text'];
                $sql_TB = "INSERT INTO lyricsNET (id, vid, lang, start, dur, lyric) VALUES ";
                $sql_DATA = '("' . $id . '", "' . $vid . '", "' . $lang . '", "' . $start. '", "' . $dur . '", "' . $text . '")';
                $sql = $sql_TB . $sql_DATA;
                //echo $sql . '<br/>';
                if ($conn->query($sql) !== FALSE) {
                   // echo "store data successfully" . "<br>";
                } else {
                    //echo "Err: " . $sql . "<br>";
                }
            }
            $conn->close();


            function timeP($str) {
                //echo $str . '<br>';
                $parts = explode(':',$str);
                $hr = (int)$parts[0];
                $min = (int)$parts[1];
                $tmp = explode(',', $parts[2]);
                $sec = (int)$tmp[0];
                $msec = (int)$tmp[1];

                $time = $hr * 60 * 60 + $min * 60 + $sec;
                $formatted_time = (string)$time . '.' . $msec;
                return $formatted_time;
            }

            $transpage = "/AdvancedWeb-AS4/src/video.php?v=".$vid;
            header("Location: $transpage");
// Array ( [0] => Array ( [number] => 1 [startTime] => 00:00:00,000 [stopTime] => 00:00:02,050 [text] => Youtube subtitles download by mo.dbxdb.com )
//         [1] => Array ( [number] => 2 [startTime] => 00:00:02,050 [stopTime] => 00:00:05,236 [text] => Professor Amy Hungerford: In light of the )
//         [2] => Array ( [number] => 3 [startTime] => 00:00:05,236 [stopTime] => 00:00:07,923 [text] => fact that I have just sent you paper topics, )

        ?>