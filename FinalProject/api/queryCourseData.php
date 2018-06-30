<?php
        # HEADER
        # header('Content-Type: application/json; charset=utf-8');
	# DEBUG MODE
	define ('DEBUG', false);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
       include './config/db.php';

	# Attrb
	$dept = $_GET['dept'];
	$abbv = $_GET['abbv'];


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
        if ($dept != '') {
	  $sql = 'SELECT * FROM Courses WHERE c_dept = "' . $dept . '"' ;
	}
        if ($abbv != '') {
          $sql = 'SELECT * FROM Courses WHERE c_abbv = "' . $abbv . '"' ;
        }

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
		$dept = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
			$dept[] = array("id" => $row['id'], "dept" => $row['c_dept'], "lang" => $row['lang'], "abbv" => $row['c_abbv'], "name" => $row['c_name'], "teacher" => $row['c_teacher']);
		}
		echo json_encode($dept, utf-8);
	} else {
		echo "Err: 0 results. <br>";
		return false;
	}

	$conn->close();

?>
