<?php
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $data = file_get_contents('http://140.114.212.79/AdvancedWeb-AS4/src/pagination.php?page='.$page);
    }else{
        $data = file_get_contents('http://140.114.212.79/AdvancedWeb-AS4/src/pagination.php?page=1');
    }
    $json_a = json_decode($data, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>VoiceTube</title>
    <meta charset="utf-8">
    <meta name="theme-color" content="#4EA1B3">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BS3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Index - VoiceTube CSS -->
    <link rel="stylesheet" href="./styles/voicetube.css">
    <!-- Load Datas -->
    <!-- <script type="text/javascript" src="./datas/videoList.json"></script> -->
    <!-- <script type="text/javascript" src="./datas/sidebarFormat.json"></script>
    <script type="text/javascript" src="./datas/sidebar.json"></script> -->
    <!-- Load Scripts-->
    <script type="text/javascript" src="./scripts/voicetube.js"></script>

</head>

<body>
    <div id="player"></div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/AdvancedWeb-AS4/src/voicetube.php">
                    <img id="logo" src="https://cdn.voicetube.com/assets/img/vt_logo-with_icon-170111-white.png">
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="white">精選頻道
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">看BBC學英文</a>
                            </li>
                            <li>
                                <a href="#">CNN10</a>
                            </li>
                            <li>
                                <a href="#">校園版精選頻道</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="white">程度分級
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">初級：TOEIC 250-545</a>
                            </li>
                            <li>
                                <a href="#">中級：TOEIC 550-780</a>
                            </li>
                            <li>
                                <a href="#">高級：TOEIC 785-990</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="white">聽力口說
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">每日口說挑戰</a>
                            </li>
                            <li>
                                <a href="#">聽力測驗</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="white">社群
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">激勵牆</a>
                            </li>
                            <li>
                                <a href="#">翻譯社群</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="dropdown-toggle" href="/AdvancedWeb-AS4/src/formDL.php" id="white">匯入影片</a>
                    </li>
                    <li>
                        <a class="dropdown-toggle" href="#" id="white">| HERO課程
                            <button id="hot">Hot</button>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <span id="search">
                        <input type="text" id="search-bar">
                        <i class="fa fa-search" id="nav-search"></i>
                    </span>
                    <i class="fa fa-user"></i>
                    <i class="fa fa-flag"></i>
                    <i class="fa fa-envelope 20x"></i>
                    <i class="fa fa-check-square"></i>
                    <img id="navbarMember" src="https://cdn.voicetube.com/assets/img/default-avatar2.jpg">
                </ul>
            </div>
        </div>
    </nav>
    <div id="contain">
        <div class="container">
            <!-- APP Side Bar -->
            <!-- <div id="appSideBar"></div> -->
            <div class="col-md-8 video-list">
                <h1>英文學習最新影片</h1>
                <div class="col-md-12" id="post-data">
                        <?php
                            require('../api/config/db.php');
                            $mysqli = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
                            // $sql = "SELECT id, vid, title FROM videoList LIMIT 8";
                            // $page_query = "SELECT COUNT(`id`) AS total FROM (`videoList`)";
                            //$page_query = "SELECT count(*) AS total FROM videoList";
                            // $numOfVideos = mysqli_query($mysqli, $page_query);
                            //$numOfVideos = mysql_result($numOfVideos, 0);
                            // $a = mysql_fetch_assoc($numOfVideos);

                            // $result = mysql_query( "select count(id) as num_rows from videoList" );
                            //$result = $mysqli->query("select count(id) as num_rows from videoList");
                          
                            $sql = "SELECT MAX(id) AS row_num FROM videosNET";
                            $result = $mysqli->query($sql);
                            
                            if (mysqli_num_rows($result) != 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                  $total_row = $row['row_num']+1; 
                                  
                                }
                            }

                            //$total_row = 1267;
                            $per_page = 12;
                            $curData = $total_row - ($_GET['page']-1)*$per_page;
                            
                            $sql = "SELECT * FROM videosNET WHERE id < "  . $curData .  " ORDER BY id DESC LIMIT 12"; 
                           
                            // $sql = "SELECT * FROM videoList
                            // ORDER BY id DESC LIMIT 12"; 
                            $result = $mysqli->query($sql);
                            //echo $result;
                            if($result != FALSE) {
                                //echo "query successfully";
                            }else {
                                //echo "query failed";
                            }
                        ?>
                        <?php include('./data.php'); ?>
                </div>
                <div class="ajax-load text-center" style="display:none">
                    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More Videos</p>
                </div>

                <!-- pagination bar -->
                <div class="col-md-12">
                    <?php if(isset($_GET['page'])){ ?>
                        <?php if($_GET['page']>=2 && $_GET['page']<=29){ ?>
                            <form class="form-inline" style="display:inline-block;" aria-label="Toolbar with button groups" role="toolbar" method="get">
                                <!-- <div class="btn-group" role="group">
                                    <button class="btn  btn-default" type="submit" name="page" value="1" style="color: black;"> 第一頁 </button>
                                </div> -->
                                <div class="btn-group" role="group">
                                    <button class="btn  btn-default" type="submit" name="page" value="1" style="color: black;"> 第一頁 </button>
                                    <?php if($_GET['page']-3>0){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']-3) ?>" style="color: black;"> <?php echo ($_GET['page']-3) ?> </button>
                                    <?php } if($_GET['page']-2>0){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']-2) ?>" style="color: black;"> <?php echo ($_GET['page']-2) ?> </button>
                                    <?php } if($_GET['page']-1>0){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']-1) ?>" style="color: black;"> <?php echo ($_GET['page']-1) ?> </button>
                                    <?php } ?>
                                    <button class="btn  btn-default active" type="submit" name="page" value="<?php echo ($_GET['page']+0) ?>" style="color: black;"> <?php echo ($_GET['page']+0) ?> </button>
                                    <?php if($_GET['page']+1<31){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']+1) ?>" style="color: black;"> <?php echo ($_GET['page']+1) ?> </button>
                                    <?php } if($_GET['page']+2<31){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']+2) ?>" style="color: black;"> <?php echo ($_GET['page']+2) ?> </button>
                                    <?php } if($_GET['page']+3<31){ ?>
                                        <button class="btn  btn-default" type="submit" name="page" value="<?php echo ($_GET['page']+3) ?>" style="color: black;"> <?php echo ($_GET['page']+3) ?> </button>
                                    <?php } ?>
                                    <button class="btn  btn-default" type="submit" name="page" value="30" style="color: black;"> 最終頁 </button>
                                </div>
                                <!-- <div class="btn-group" role="group">
                                    <button class="btn  btn-default" type="submit" name="page" value="50" style="color: black;"> 最終頁 </button>
                                </div> -->
                            </form>
                        <?php }elseif($_GET['page']==30){ ?>
                            <form class="btn-group" style="display:inline-block;" method="get">
                                <button class="btn  btn-default" type="submit" name="page" value="1" style="color: black;"> 第一頁 </button>
                                <button class="btn btn-default" type="submit" name="page" value="25" style="color: black;"> 25 </button>
                                <button class="btn btn-default" type="submit" name="page" value="26" style="color: black;"> 26 </button>
                                <button class="btn btn-default" type="submit" name="page" value="27" style="color: black;"> 27 </button>
                                <button class="btn btn-default" type="submit" name="page" value="28" style="color: black;"> 28 </button>
                                <button class="btn btn-default" type="submit" name="page" value="29" style="color: black;"> 29 </button>
                                <button class="btn btn-default active" type="submit" name="page" value="30" style="color: black;"> 30 </button>
                            </form>
                        <?php }else{ ?>
                            <form class="btn-group" style="display:inline-block;" method="get">
                                <button class="btn btn-default active" type="submit" name="page" value="1" style="color: black;"> 1 </button>
                                <button class="btn btn-default" type="submit" name="page" value="2" style="color: black;"> 2 </button>
                                <button class="btn btn-default" type="submit" name="page" value="3" style="color: black;"> 3 </button>
                                <button class="btn btn-default" type="submit" name="page" value="4" style="color: black;"> 4 </button>
                                <button class="btn btn-default" type="submit" name="page" value="5" style="color: black;"> 5 </button>
                                <button class="btn btn-default" type="submit" name="page" value="6" style="color: black;"> 6 </button>
                                <button class="btn btn-default" type="submit" name="page" value="7" style="color: black;"> 7 </button>
                                <button class="btn  btn-default" type="submit" name="page" value="30" style="color: black;"> 最終頁 </button>
                            </form>
                        <?php } ?>
                    <?php }else{ ?>
                        <form class="btn-group" style="display:inline-block;" method="get">
                            <button class="btn btn-default" type="submit" name="page" value="1" style="color: black;"> 1 </button>
                            <button class="btn btn-default" type="submit" name="page" value="2" style="color: black;"> 2 </button>
                            <button class="btn btn-default" type="submit" name="page" value="3" style="color: black;"> 3 </button>
                            <button class="btn btn-default" type="submit" name="page" value="4" style="color: black;"> 4 </button>
                            <button class="btn btn-default" type="submit" name="page" value="5" style="color: black;"> 5 </button>
                            <button class="btn btn-default" type="submit" name="page" value="6" style="color: black;"> 6 </button>
                            <button class="btn btn-default" type="submit" name="page" value="7" style="color: black;"> 7 </button>
                            <button class="btn  btn-default" type="submit" name="page" value="30" style="color: black;"> 最終頁 </button>
                        </form>
                    <?php } ?>
                </div>

            </div>
            <!-- dynamic PC SideBar-->
            <!-- <div id="pcSideBar"></div> -->
        </div>
    </div>

    <!-- SideBar Menu -->
    <!-- <div class="top-pattern"></div>
    <div id="footer"></div>
    <div class="floatMenu">
        <button class="pointer" href="#about" id="sideBarMenu">其他資訊</button>
    </div> -->


</body>

</html>
