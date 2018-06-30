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
	<link rel="stylesheet" type="text/css" href="/FinalProject/src/style/edit.css">
	<!--===============================================================================================-->

</head>

<body>

	<nav class="navbar navbar">
		<div class="container-nav">
			<div class="navbar-header">
				<a class="navbar-brand">NTHU BOOK</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href "#">Buy Book</a>
					</li>
					<li>
						<a href "#">Sell Book</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-contact100">
	<form action='../../api/createBookData.php' method='get'>
		<div class="container">
			<div class="col-md-1 other">
				<img class="otherImg">
				<img class="otherImg">
				<img class="otherImg">
				<img class="otherImg">
				<img class="otherImg">
				<img class="otherImg">
			</div>

			<div class="col-md-5 img-block">

				<img class="img">

			</div>
			<div class="col-md-6 caption-block">

				<div class="book-name">
				</div>

				<div class="dept-name">
				</div>

				<div class="course-name">
				</div>

				<div class="teacher">
				</div>

				<div class="date">
					<!-- <h4>2018.05.05</h4> -->
				</div>

				<div class="price">
					NT $
				</div>

				<div class="new-old">
					<label style="margin-right: 15px">old</label>
				</div>

				<h4>Note</h4>
				<div class="note">
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn">
							<span>
								SAVE
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	</div>
    <script type="text/javascript" src="/FinalProject/src/scripts/edit.js"></script>
</body>

</html>
