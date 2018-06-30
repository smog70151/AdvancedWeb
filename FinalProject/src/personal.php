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
	<link rel="icon" type="image/png" href="/FinalProject/src/imgs/book.ico" />
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<!--===============================================================================================-->
    <!-- <link rel="stylesheet" href="/FinalProject/src/style/personal.css"> -->
	<link rel="stylesheet" href="/FinalProject/src/style/booklist.css">

</head>
    <body>
        <?php include 'ele/nav.php'; ?>

        <div class="selling container" style="margin-top: 65px;">
            <h2 class="col-md-12" style="margin: 20px 0 20px; font-size: 30px;">Selling</h2 >

        </div>
        <div class="sold container">
			<h2 class="col-md-12" style="margin: 20px 0 20px; font-size: 30px;">Sold</h2 >
        </div>
		<?php include './index.php'; ?>
		<script src="/FinalProject/src/scripts/personal.js" type="text/javascript"></script>
    </body>
</html>
