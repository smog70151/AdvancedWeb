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
	<link rel="stylesheet" type="text/css" href="css/imgur.min.css" >
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<!--===============================================================================================-->

</head>

<body>

	<?php include '../ele/nav.php'; ?>
	<div class="container-contact100">
		<div class="wrap-contact100" style="width:850px;">
			<form class="contact100-form validate-form" action='../../api/createBookData.php' method='get'>
				<span class="contact100-form-title">
					Book Info
				</span>

				<div class="wrap-input100 validate-input" data-validate="Name is required">
					<span class="label-input100">Book Name</span>
					<input class="input100" type="text" name="BookName" placeholder="Enter the book name (required)" required="required">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Name is required">
					<span class="label-input100">Book Picture (限一張)</span>
					<button type="button" id="imgRe" style="border: 1px solid gray; border-radius: 5px; padding: 2px;">re-upload</button>
					<input id="imgInput" type="text" name="imgURL" style="visibility: hidden;" required="required">
					<div class="dropzone"><div class="overflow"></div></div>

				</div>

				<div class="wrap-input100 input100-select">
					<span class="label-input100">Department</span>
					<div>
						<select required class="selection-2" name="Department" id="Dept" onchange="changeDept(this)">
							<option value=""> --- </option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 input100-select">
					<span class="label-input100">Course Name / Professor</span>
					<div>
						<select required class="selection-2" name="CourseName" id="Course" value="">
							<option value=""> --- </option>
						</select>
					</div>
					<span class="focus-input100"></span>
				</div>
				<div class="wrap-input100 input100-select">
					<span class="label-input100">Quality</span>
					<div style="margin-top: 15px;">
						<label style="margin-right: 15px">old</label>
						<?php for($i = 1; $i <=10; $i++){ ?>
							<div class="radio_selection">
								<input type="radio" name="level" required="required" value="<?php echo $i ?>">
								<?php echo $i; ?>
							</div>
						<?php } ?>

						<label style="margin-left: 15px">new</label>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Price is required">
					<span class="label-input100">Price</span>
					<input class="input100" pattern="^[0-9]+$" type="number" name="price" placeholder="Enter the price (required)" required="required" min="1">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Message is required">
					<span class="label-input100">Note</span>
					<textarea class="input100" name="note" placeholder="Your message here..."></textarea>
					<span class="focus-input100"></span>
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" onclick="submit">
							<span>
								Submit
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</div>

				<input type="text" name="id" style="display: none;" required="required" value="<?php echo $_GET['id'] ?>">

			</form>

		</div>
	</div>



	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>

	<!-- upload img to imgur -->
	<script src="./js/imgur.min.js"></script>
	<script>
		var callback = function (res) {
			if (res.success === true) {
				// console.log(res.data.link);
				var div = document.getElementsByClassName('dropzone');
				var img_num = div[0].childElementCount - 3;


				if (img_num < 1) {
					var img = document.createElement('img');
					div[0].appendChild(img);
					img.src = res.data.link;
					img.setAttribute("class", "bookImg")

					var imgInput = document.getElementById('imgInput');

					imgInput.value = res.data.link;
				} else {
					var child = document.getElementsByClassName("bookImg");
					div[0].removeChild(child[0]);

					var img = document.createElement('img');
					div[0].appendChild(img);
					img.src = res.data.link;
					img.setAttribute("class", "bookImg")

					var imgInput = document.getElementById('imgInput');

					imgInput.value = res.data.link;
				}

				// console.log(img_num);
				// if(img_num >= 2) {
				// 	$('.overflow').css("visibility", "visible");
				// 	$('.overflow').text("已上傳" + img_num + "張圖片")
				// }

			}
		};

		new Imgur({
			clientid: 'cc86a8de0e7c459',
			callback: callback
		});

		var reBtn = document.getElementById('imgRe');
		reBtn.addEventListener('click', function() {
			var div = document.getElementsByClassName('dropzone');
			var child = document.getElementsByClassName("bookImg");
			div[0].removeChild(child[0]);
		});

	</script>
	<script type="text/javascript" src="/FinalProject/src/scripts/form.js"></script>
	<?php include '../index.php'; ?>
</body>

</html>
