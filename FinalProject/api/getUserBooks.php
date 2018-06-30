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
	if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
  }
	if(isset($_GET['id']) && !empty($_GET['id'])) {
		$id = $_GET['id'];
	}

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
	# XXX
	$sql = 'SELECT * FROM Books WHERE u_id = ' . $id;
	$result = $conn->query($sql);

	if ($result !== false) {
		# echo "Query Courses from " . $dept . " successfully. <br>";
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	# Check Whether Data exists
	$books = array();
	if ($result->num_rows) {
		while ($row = mysqli_fetch_assoc($result)) {
			$books[] = array("u_id" => $row['u_id'], "id" => $row['b_id'], "name" => $row['b_name'], "imgURL" => $row['b_imgURL'], "dept" => $row['b_dept'], "courseID" => $row['b_courseID'],
											"level" => $row['b_level'], "price" => $row['b_price'], "note" => $row['b_note'], "status" => $row['b_status'], "date" => $row["b_date"]);
		}
	} else {
	}

	echo json_encode($books, utf-8);

	$conn->close();

?>
