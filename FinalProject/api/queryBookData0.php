<?php
	# DEBUG MODE
	define ('DEBUG', false);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
  include './config/db.php';

	# Attrb
	// TODO Attrb Undo
	$dept = $_GET['dept']; 	
	//$price = $_GET['price'];


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

	## Set UTF-8 ENCODE

	$conn->set_charset("utf-8");

	mysqli_query($conn, "SET NAMES UTF8");
	// TODO Implement SQL
	$dept = $_REQUEST['dept'];
	$sql = 'SELECT * FROM Books, Courses WHERE Books.b_dept = "'.$dept.'" AND Books.b_courseID = Courses.id';
	# echo $sql, '<br>';
	$result = mysqli_query($conn, $sql);


	if ($result !== false) {
		while ($row = mysqli_fetch_array($result)) {
			echo "
				<div data-bookName = \"".$row['b_name']."\" data-bookDept = \"".$row['b_dept']."\" class=\"book col-sm-6 col-md-3\">
					<div class=\"thumbnail\">
						<a href=\"./form/book.php?dept=".$row['b_dept']."&b_id=".$row['b_id']."\">
							<div class=\"book_img\">
								<img src=\"".$row['b_imgURL']."\">
							</div>
							<div class=\"book_info caption\">
								<div class=\"name\">".$row['b_name']."</div>
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
		// echo  $bookInfo;
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	# Check Whether Data exists
	// TODO Get the row num


	$conn->close();

?>
