<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta name="theme-color" content="#4EA1B3">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/AdvancedWeb-AS4/src/styles/video.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="./datas/videoSubtitle.json"></script> -->
    <meta charset="utf-8">
    <title></title>
</head>

<body>
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
    <div class="view-block">

        <div class="container">
            <div class="col container" id="listen-speak">
                <ul>
                    <li class="current">
                        <a href="">聽力</a>
                    </li>
                    <li class="record">
                        <a href="">口說</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container content-area">
            <div class="col-md-7 video-block">
                <div class="pull-left">
                    <button type="button" class="btn btn-primary btn-xs">中級</button>
                    <button type="button" class="btn btn-warning btn-xs">美國腔</button>
                    <div class="view-count">
                        <i class="fa fa-headphones"></i>
                        5335
                    </div>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-xs">
                        <i class="fa fa-thumbs-up"></i>
                        讚 0
                    </button>
                    <button type="button" class="btn btn-primary btn-xs">分享</button>
                    <button type="button" class="btn btn-basic btn-xs">
                        <i class="fa fa-heart"></i>
                        收藏
                    </button>
                </div>
                <div class="video-frame">
                    <div id="player"></div>
                    <div class="caption-block" id="video-down">
                        <h4>
                            <i class="fa fa-info-circle"></i> 開始影片後，點擊或框選字幕可以立即查詢單字</h4>
                    </div>
                    <div class="control-bar">
                        <div class="pull-left" id="again">
                            <img src="https://cdn.voicetube.com/assets/img/glyphicons_224_chevron-left.png" width="12" height="18" class="control-img">
                            <span>重複單句</span>
                            <img src="https://cdn.voicetube.com/assets/img/glyphicons_223_chevron-right.png" width="12" height="18" class="control-img">
                            <span id="red-text"> 英 中</span>
                        </div>
                        <div class="full-screen">
                            <i class="fa fa-film"></i>
                            <span>全螢幕</span>
                        </div>
                        <div class="repeat">
                            <span>影片重複</span>
                        </div>
                        <div class="share">
                            <span>嵌入分享</span>
                        </div>
                        <div class="speed">
                            <span>速度：慢</span>
                            <span id="red-text">一般</span>
                        </div>
                        <div class="adjust">
                            <i class="fa fa-search-plus"></i>
                            <i class="fa fa-search-minus"></i>
                            <i class="fa fa-keyboard-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 caption-block" id="right-caption">
                <div class="tags">
                    <div class="pull-left left">
                        <span class="dropdown">
                            <button class="btn btn-basic btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                選擇標記字庫
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">英檢初級</a>
                                </li>
                                <li>
                                    <a href="#">英檢中級</a>
                                </li>
                                <li>
                                    <a href="#">英檢高級</a>
                                </li>
                            </ul>
                        </span>
                    </div>

                    <div class="pull-left right">
                        <button id="btnReplyWrong" type="button" class="btn btn-basic btn-xs" onclick="editScript()">編輯字幕</button>
                        <script>
                            function editScript() {
                                url = new URL(location.href);
                                vid = url.searchParams.get("urlYT");
                                vid = new URL(vid);
                                v = vid.searchParams.get("v");
                                location.href = "/AdvancedWeb-AS4/src/addText.php?v=" + v;
                                console.log(v);
                            }
                        </script>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                        <i id="iconSearch" class="fa fa-search-plus"></i>
                        <i class="fa fa-search-minus"></i>
                        <i class="fa fa-print"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="caption">
                </div>
                <div class="myTab-pos">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#">單詞</a>
                        </li>
                        <li>
                            <a href="#">筆記</a>
                        </li>
                        <li>
                            <a href="#search-dic" data-toggle="tab">
                                <div class="input-append">
                                    <input class="input-medium" type="text" placeholder='搜尋單字' id="custom_dic">
                                    <i class="fa fa-search"></i>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="viewed_caption">
                            點擊即可立刻查字典，但你目前還沒有查詢過單字喔！
                        </div>
                        <div class="tab-pane" id="note-mode">
                            <input id='note-input' type="text" placeholder='這邊輸入筆記，確定之後按enter' />
                            <ul></ul>
                        </div>
                        <div class="tab-pane" id="search-dic">
                            <div id="mode_search_result">
                                <i class='icon-info-sign'></i>
                                提示：點選文章或是影片下面的字幕單字，可以直接快速翻譯喔！
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container footer">
            <h1 id="bigTitle"></h1>
            <div class="pull-left">
                <div class="author pull-left">
                    <a href="">Samule</a>
                    <span>發佈於 13 小時 前</span>
                </div>
                <div class="translator pull-left">
                    <a href="">Rong Chiang</a>
                    <span>翻譯</span>
                    <a href="">Evangeline Chung</a>
                    <span>審核</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <ul class="nav nav-tab">
                <li>
                    <a href="">影片學習單字重點</a>
                </li>
                <li>
                    <a href="">影片討論</a>
                </li>
                <li>
                    <a href="">問題回報</a>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>

    <script id="videoLyrics" type="text/javascript"></script>
    <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/video.js"></script>

</body>

</html>
