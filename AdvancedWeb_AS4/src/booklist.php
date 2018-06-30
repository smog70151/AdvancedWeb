
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
	// TODO Implement SQL
	$sql = 'SELECT * FROM Books, Courses WHERE Books.b_courseID = Courses.id';
	$result_book = $conn->query($sql);

?>
<!-- book.php?dept=Computer Science?b_id=0 -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<title>NTHU BOOK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="./imgs/book.ico" />
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<!--===============================================================================================-->
	<link rel="stylesheet" href="./style/booklist.css">


</head>
    <body>
        <?php include 'ele/nav.php'; ?>
		<div class="search_bar container">
			<div class="search col-md-4">
				<input class="col-md-12" type="text" name="search" placeholder="搜尋書名">
			</div>
			<div class="selector-container col-md-1">
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						選擇系所
						<span class="caret"></span>
					</button>
					<ul class="subject_container dropdown-menu" aria-labelledby="dropdownMenu1">
						<?php
							// for($i = 0; $i < sizeof($dept); $i++){
							// 	echo "<li><button name=\"".$dept[$i]['dept']."\" onclick=\"showBook(this.name)\" class=\"btn btn-default dept\">".$dept[$i]['dept']."</button></li>";
							// }
						?>
						<div class="row">
							<div class="subject col-md-4">
								<h3>理學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">化學系</button></li>
								<li><button name="Mathematics" onclick="showBook(this.name)" class="btn btn-default dept">數學系應數組</button></li>
								<li><button name="Mathematics" onclick="showBook(this.name)" class="btn btn-default dept">數學系數學組</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">物理系物理組</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">物理系光電物理組</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">理學院學士班</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>工學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">化學工程學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">工業工程與工程管理學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">材料科學工程學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">動力機械工程系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">工學院學士班</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>人文社會學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">中國文學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">外國語文學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">人文社會學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">人社院學士班</button></li>
							</div>

							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="subject col-md-4">
								<h3>生命科學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">生命科學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">生命科學院學士班</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">醫學科學系</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>原子科學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">工程與系統科學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">原子科學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">生醫工程與環境科學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">原子科學院學士班</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>科技管理學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">計量財務金融學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">經濟學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">科管院學士班</button></li>
							</div>

							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="subject col-md-4">
								<h3>電機資訊學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">資訊工程學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">電機工程學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">電機資訊學院學士班</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>竹師教育學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">教育心理與諮商學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">幼兒教育學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">特殊教育學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">體育學</button></li>
								<li><button name="General Education" onclick="showBook(this.name)" class="btn btn-default dept">教育與學習科技學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">英語教學</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">環境與文化資源學</button></li>
							</div>
							<div class="subject col-md-4">
								<h3>藝術學院</h3>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">音樂學系</button></li>
								<li><button name="Computer Science" onclick="showBook(this.name)" class="btn btn-default dept">藝術與設計學</button></li>
							</div>

							<div class="clearfix"></div>
						</div>
					</ul>
				</div>
			</div>
			<button class="btn btn-default pull-right col-md-1 latest">最新</button>
		</div>
		<div class="book_list container">
			<div class="row book_container">
				<?php
					if ($result_book->num_rows > 0) {
						while($row = $result_book->fetch_assoc()) {
							echo "
								<div data-bookName = \"".$row['b_name']."\" data-bookDept = \"".$row['b_dept']."\" class=\"book col-sm-6 col-md-3\">
									<div class=\"thumbnail\">
										<a href=\"./form/book.php?dept=".$row['b_dept']."?b_id=".$row['b_id']."\">
											<div class=\"book_img\">
												<img src=\"".$row['b_imgURL']."\">
											</div>
											<div class=\"book_info caption\">
												<h3>".$row['b_name']."</h3>
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
					}
				?>
			</div>
		</div>
		<a class="chatbox-link" href="index.html"><img src="./svg/chat.svg" alt=""></a>
		<script src="./scripts/booklist.js" charset="utf-8"></script>
    </body>
	<?php $conn->close(); 
	 include './index.php';
	?>
	
</html>
