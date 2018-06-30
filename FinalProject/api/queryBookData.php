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
	if(isset($_GET['dept']) && !empty($_GET['dept'])) {
      $dept = $_GET['dept'];
	  $sql = 'SELECT * FROM Books WHERE b_dept = "' . $dept . '"' ;
  }
	if(isset($_GET['b_id']) && !empty($_GET['b_id'])) {
		$bid = $_GET['b_id'];
		$sql = 'SELECT * FROM Books WHERE b_id = ' . $bid;
	}

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

	$result = $conn->query($sql);

	if ($result !== false) {
		# echo "Query Courses from " . $dept . " successfully. <br>";
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	# Check Whether Data exists
	// TODO Get the row num

	if ($result->num_rows) {
		$isExist = false;
		$dept = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
                        $isExist = true;
			$dept[] = array("b_id" => $row['b_id'], "seller" => $row['u_id'], "name" => $row['b_name'], "imgURL" => $row['b_imgURL'], "dept" => $row['b_dept'], "courseID" => $row['b_courseID'], "level" => $row['b_level'], "price" => $row['b_price'], "status" => $row['b_status'], "postTime" => $row['b_date'], "note" => $row['b_note']);
		}
                if ($isExist == true) {
		  echo json_encode($dept, utf-8);
                } else {
                  echo "No Data";
                }
	} else {
		echo "Err: 0 results. <br>";
		return false;
	}

	$conn->close();

?>
