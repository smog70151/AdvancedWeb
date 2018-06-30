<?php
	session_start();
	echo $_SESSION['facebook_id'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<title>NTHU BOOK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/book.ico" />
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<!--===============================================================================================-->
    <link rel="stylesheet" href="./style/personal.css">
    <link rel="stylesheet" href="./style/booklist.css">


</head>
    <body>
        <?php include 'ele/nav.php'; ?>
        <div class="card">
            <div class="head"></div>
            <h2 class="name">Jacky Soon</h2>
            <div class="status">
                <span>100 Books</span>
                <span>100 Nice Seller</span>
                <span>100 Bought</span>
            </div>
            <div class="about">
                <p>本來就是這樣，每個球迷心中都有一個自己影響最深最偉大的球員，這跳脫數據與榮耀，不用去執著跟人比較，他就是活在你們心中，有著不可取代的地位。</p>
            </div>
        </div>
        <div class="books container">
            <div data-bookName = "" data-bookDept = "" class="book col-sm-6 col-md-3">
                <div class="thumbnail">
                    <a href="#/">
                        <div class="book_img">
                            <img src="https://i.imgur.com/jLcifZe.png">
                        </div>
                        <div class="book_info caption">
                            <h3></h3>
                            <div class="tags_container">
                                <div class="tag sub_tag"></div>
                                <div class="tag pro_tag">蘇德宙斯</div>
                            </div>
                            <div class="price">
                                <p>NT$ 100</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
