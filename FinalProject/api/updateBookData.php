<?php
	# DEBUG MODE
	define ('DEBUG', true);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
  include './config/db.php';

	# Attrb
	$sql = 'UPDATE Books SET ';
	$sql_stat = '';
	$sql_cond = '';

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

	if(isset($_GET['b_id']) && !empty($_GET['b_id'])) {
		$b_id = $_GET['b_id'];
		$b_id = mysqli_real_escape_string($conn, $b_id);
		$sql_stat = 'WHERE b_id = ' . $b_id;
	}

	if(isset($_GET['b_name']) && !empty($_GET['b_name'])) {
		$b_name = $_GET['b_name'];
		$b_name = mysqli_real_escape_string($conn, $b_name);
		$sql_cond = $sql_cond . 'b_name = "' . $b_name . '", ';
	}

	if(isset($_GET['b_imgURL']) && !empty($_GET['b_imgURL'])) {
		$b_imgURL = $_GET['b_imgURL'];
		$b_imgURL = mysqli_real_escape_string($conn, $b_imgURL);
		$sql_cond = $sql_cond . 'b_imgURL = "' . $b_imgURL . '", ';
	}

	if(isset($_GET['b_dept']) && !empty($_GET['b_dept'])) {
		$b_dept = $_GET['b_dept'];
		$b_dept = mysqli_real_escape_string($conn, $b_dept);
		$sql_cond = $sql_cond . 'b_dept = "' . $b_dept . '", ';
	}

	if(isset($_GET['b_courseID']) && !empty($_GET['b_courseID'])) {
		$b_courseID = (int) $_GET['b_courseID'];
		$b_courseID = mysqli_real_escape_string($conn, $b_courseID);
		$sql_cond = $sql_cond . 'b_courseID = ' . $b_courseID . ', ';
	}

	if(isset($_GET['b_level']) && !empty($_GET['b_level'])) {
		$b_level = (int) $_GET['b_level'];
		$b_level = mysqli_real_escape_string($conn, $b_level);
		$sql_cond = $sql_cond . 'b_level = ' . $b_level . ', ';
	}

	if(isset($_GET['b_price']) && !empty($_GET['b_price'])) {
		$b_price = (int) $_GET['b_price'];
		$b_price = mysqli_real_escape_string($conn, $b_price);
		$sql_cond = $sql_cond . 'b_price = ' . $b_price . ', ';
	}

	if(isset($_GET['b_note'])) {
		$b_note = $_GET['b_note'];
		$b_note = mysqli_real_escape_string($conn, $b_note);
		$sql_cond = $sql_cond . 'b_note = "' . $b_note . '", ';
	}

	if(isset($_GET['b_status'])) {
		$b_status = $_GET['b_status'];
		$b_status = mysqli_real_escape_string($conn, $b_status);
		$sql_cond = $sql_cond . 'b_status = ' . $b_status . ' ';
	}

	$sql = $sql . $sql_cond . $sql_stat;
	mysqli_query($conn, "SET NAMES UTF8");



	$result = $conn->query($sql);

	if ($result !== false) {
		# echo "Query Courses from " . $dept . " successfully. <br>";
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	$url = "/FinalProject/src/booklist.php";
	header("Location:$url");
	$conn->close();


?>
