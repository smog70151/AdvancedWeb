<?php
	# DEBUG MODE
	define ('DEBUG', false);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
  include '../api/config/db.php';

	# DB - conn
	$hostname = DBHOST;
	$username = DBUSER;
	$password = DBPWD;
	$dbname   = DBNAME;

	$conn = new mysqli ($hostname, $username, $password, $dbname);
	if ($conn->connect_error) {
		die('Connect Error: ' . $conn->connect_error);
		return false;
	}
	$conn->set_charset("utf-8");
	mysqli_query($conn, "SET NAMES UTF8");

	# IDEA : Pagination
	$sql_cond = "WHERE Books.b_courseID = Courses.id AND Books.b_status = 0 ";
	$dept = '';
	if (isset($_GET['dept']) && !empty($_GET['dept'])) {
		$dept = $_GET['dept'];
		$dept = mysqli_real_escape_string($conn, $dept);
		$sql_cond = $sql_cond . "AND Books.b_dept = \"$dept\" ";
	}
	$search = '';
	if (isset($_GET['search']) && !empty($_GET['search'])) {
		$search = $_GET['search'];
		$search = mysqli_real_escape_string($conn, $search);
		$sql_cond = $sql_cond . "AND Books.b_name LIKE \"$search\"";
	}

	$sql = "SELECT COUNT(*) FROM Books, Courses " . $sql_cond;
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result);

	$numBooks = $row[0];
	$perPage  = 12;
	$totalPage = ceil($numBooks/$perPage);

	if (isset($_GET['curPage']) && is_numeric($_GET['curPage'])) {
		$curPage = (int) $_GET['curPage'];
		if ($curPage > $totalPage) {
			$curPage = $totalPage;
		} 
		if ($curPage < 1) {
			$curPage = 1;
		}
	} else {
		$curPage = 1;
	}
	//echo $curPage;
	
	$offset = ($curPage - 1) * $perPage;
	//echo $offset;
	# echo $sql_cond;

	// TODO Implement SQL
	$sql = "SELECT * FROM Books, Courses " . $sql_cond . "ORDER BY Books.b_date DESC LIMIT $offset, $perPage" ;
	
// echo $sql;
	$result_book = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<title>NTHU BOOK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="./imgs/book.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.9.0/bootstrap-social.min.css" integrity="sha256-02JtFTurpwBjQJ6q13iJe82/NF0RbZlJroDegK5g87Y=" crossorigin="anonymous">
	<!--  JS -->
	<!-- <script src="./scripts/index.js" charset="utf-8"></script> -->
	<!--  Title -->
	<link rel="shortcut icon" href="https://quickblox.com/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/FinalProject/src/form/vendor/select2/select2.min.css">
	<link rel="stylesheet" href="/FinalProject/src/style/css/style.css">
	<link rel="stylesheet" href="/FinalProject/src/style/booklist.css">
	<script src="https://unpkg.com/navigo@4.3.6/lib/navigo.min.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js" defer></script>
	<script src="/FinalProject/src/scripts/quickblox.min.js" defer></script>




</head>
    <body>
        <?php include 'ele/nav.php'; ?>
		<div class="search_bar container">
			<div class="row">

				<!-- select bar -->

				<div style="height: 45px; align-content: center;" class="searchDept col-md-4 col-sm-12">
					<div style="col-md-12">
						<select style="height: 45px;" class="selection-2" onchange="showBook(this)">
							<option value="" disabled selected> 使用科系搜尋 </option>
						</select>
					</div>
				</div>

				<!-- search bar -->

				<div class="search col-md-4" style="display: inline;">
					<input id="searchInput" class="col-md-12" type="text" name="search" placeholder="搜尋書名">
				</div>
				<div class="col-md-4">
					<button id="searchBtn" name="button" type="button" class="btn btn-default">搜尋</button>
				</div>

			</div>
			<div id="dropDownSelect1"></div>
			<script src="/FinalProject/src/form/vendor/select2/select2.min.js"></script>
			<script>
				$(".selection-2").select2({
					minimumResultsForSearch: 20,
					dropdownParent: $('#dropDownSelect1')
				});
			</script>
		</div>
		<div class="book_list container">
			<div class="row book_container">
				<?php
					//echo $sql;
					//echo $curPage;
					//echo $offset;
					if ($result_book->num_rows > 0) {
						while($row = $result_book->fetch_assoc()) {
							$url = explode(".jpg", $row['b_imgURL'])[0] . "b.jpg";
							echo "
								<div data-bookName = \"".htmlspecialchars($row['b_name'])."\" data-bookDept = \"".$row['b_dept']."\" class=\"book col-sm-6 col-md-3\">
									<div class=\"thumbnail\">
										<a href=\"./form/book.php?dept=".$row['b_dept']."&b_id=".$row['b_id']."&id=".$_GET['id']."\">
											<div class=\"book_img\">
												<img src=\"".$url."\">
											</div>
											<div class=\"book_info caption\">
												<div class=\"name\">".strip_tags($row['b_name'])."</div>
												<div class=\"tags_container\">
													<div class=\"tag sub_tag\">".$row['b_dept']."</div>
													<div class=\"tag pro_tag\">".$row['c_teacher']."</div>
												</div>
												<div class=\"price\">
													<p>NT$ ".$row['b_price']."</p>
												</div>
											</div>
										</a>
									</div>
								</div>
								";
						}
					}else {
						echo "<h1>無相關搜尋結果！Sorry, no related search results !</h1>";
					}
				?>
			</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
				<?php
					$id = $_GET['id'];
					$range = 1;
					$prevPage = $curPage - 1;
					if ($curPage >= 2 && $totalPage != 1) {
						echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$_SERVER['PHP_SELF']}?id=$id&curPage=1&dept=$dept&search=$search\"><<</a></li>";
						echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$_SERVER['PHP_SELF']}?id=$id&curPage=$prevPage&dept=$dept&search=$search\"><</a></li>";
					}

					for ($x = ($curPage - $range); $x < (($curPage + $range) + 1); $x++) {
				   	if (($x > 0) && ($x <= $totalPage)) {
						   if ($x == $curPage) {
								echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\">[ <b>$x</b> ]</a></li>";
							 // echo " <p style=\"font-size: 30px; border-bottom: 2px solid; padding: 0 3px; display: inline;\"> [<b>$x</b>] </p>";
						   } else {
								echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$_SERVER['PHP_SELF']}?id=$id&curPage=$x&dept=$dept&search=$search\">$x</a></li>";
						      //echo " <a style=\"font-size: 30px; border-bottom: 2px solid; padding: 0 3px;\" href='{$_SERVER['PHP_SELF']}?curPage=$x'>$x</a> ";
						   }
						}
						if($totalPage == 1 && $x == 1) {
							echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\">[ <b>$x</b> ]</a></li>";
						}
					}
					if ($curPage != $totalPage && $totalPage > 1 ) {
					   $nextPage = $curPage + 1;
					   echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$_SERVER['PHP_SELF']}?id=$id&curPage=$nextPage&dept=$dept&search=$search\">></a></li>";
					   echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$_SERVER['PHP_SELF']}?id=$id&curPage=$totalPage&dept=$dept&search=$search\">>></a></li>";
					   //echo " <a style=\"font-size: 30px; border-bottom: 2px solid; padding: 0 3px;\" href='{$_SERVER['PHP_SELF']}?curPage=$nextPage'>></a> ";
					   //echo " <a style=\"font-size: 30px; border-bottom: 2px solid; padding: 0 3px;\" href='{$_SERVER['PHP_SELF']}?curPage=$totalPage'>>></a> ";
					}
				 ?>
			 	</ul>
			</nav>
		</div>
		<script src="./scripts/booklist.js" charset="utf-8"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
	<?php $conn->close();
	 include './index.php';
	?>

</html>
