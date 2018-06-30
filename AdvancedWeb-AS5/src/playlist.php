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
    <link rel="stylesheet" href="/AdvancedWeb-AS4/src/styles/playlist.css">
    <!-- Load Scripts-->
    <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/playlist.js"></script>

</head>

<body>
    <div id="player"></div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/AdvancedWeb-AS4/src/formDL.php">
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
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="white">播放清單
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                            <li><a class="list"></a></li> 
                        </ul>
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
            <div class="col-md-8 video-list">
                <h1 id="playlistTitle"></h1>
                <div class="col-md-12" id="post-data">
                </div>
            </div>
        </div>
    </div>

</body>

</html>
