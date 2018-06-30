<?php
	# DEBUG MODE
	define ('DEBUG', false);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
        include './config/db.php';

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
	$sql = "SELECT MIN(id) AS id, c_dept, c_abbv FROM Courses GROUP BY c_dept, c_abbv";
	$result = $conn->query($sql);

	if ($result !== false) {
		#echo "Query DEPT. successfully. <br>";
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	# Check Whether Data exists
	// TODO Get the row num


	if ($result->num_rows) {
		$dept = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
			$dept[] = array("id" => $row['id'], "dept" => $row['c_dept'], "abbv" => $row['c_abbv']);
		}
		echo json_encode($dept, utf-8);
	} else {
		echo "Err: 0 results. <br>";
		return false;
	}
	$conn->close();

?>
