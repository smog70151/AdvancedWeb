
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Books@NTHU</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/book.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="book.css">
	<!--===============================================================================================-->

</head>

<body>

	 <?php include '../ele/nav.php'; ?>

	<div class="container-contact100">
		<div class="container">
			<div class="col-md-5 img-block">

				<img class="img">

			</div>
			<div class="col-md-6 caption-block">

				<div class="book-name">
				</div>

				<div class="modify">
				<div>

				<div class="dept-name">
				</div>

				<div class="course-name">
				</div>

				<div class="teacher">
				</div>
				<?php 


				?>
				<div class="seller" style="font-size: 16px; padding-top: 20px;">賣家 Seller : <p style="display: inline;" id="seller_name" href="#" ></p></div>
				<div class="date">
					
					<!-- <h4>2018.05.05</h4> -->
				</div>

				<div class="price">
					<!-- <h1>NT$700</h1> -->
				</div>

				<div class="new-old">
					<div class="progress">
						<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="">
						</div>
					</div>
				</div>

				<div class="note">
					<h4>Note</h4>
					<div class="note-content">
						<p></p>
					</div>
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn">
							<span id="btntext">
								BUY
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
						<button id="modify"class="contact100-form-btn">
							<span>
								MODIFY
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="book.js"></script>
</body>

	<?php
	 include '../index.php';
	?>

</html>
