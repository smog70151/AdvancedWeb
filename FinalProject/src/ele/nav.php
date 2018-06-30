<head>
    <link rel="stylesheet" href="/FinalProject/src/style/nav.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<nav class="navbar navbar-fixed-top">
    <div class="container" style="margin: 0 auto;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
              $id = $_GET['id'];
              echo "<a class=\"navbar-brand\" href=\"/FinalProject/src/booklist.php?id=$id\">Books@NTHU</a>"
             ?>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li>
                  <?php
                    $id = $_GET['id'];
                    echo "<a href=\"/FinalProject/src/booklist.php?id=$id\">Buy Book</a>"
                   ?>
                </li>
                <li>
                    <a id="sell" href="/FinalProject/src/form/form.php">Sell Book</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li id="img_li">
                    <img id="userPhoto">
                </li>
                <li>
                    <a id="personal" href="/FinalProject/src/personal.php">
                        <div id="userName"></div>
                    </a>
                </li>
                <li>
                   <?php
                    $id = $_GET['id'];
                    echo "<a id=\"personalPage\" href=\"/FinalProject/src/personal.php?id=$id\">Personal Page</a>"
                   ?>
                </li>
                <li>
                    <a id="logout" onclick="myFacebookLogout()">log out</a>
                </li>
            </ul>
        </div>
    </div>
    <script src="/FinalProject/src/scripts/nav.js" type="text/javascript"></script>
    <script src="/FinalProject/src/scripts/login.js" type="text/javascript"></script>
</nav>
