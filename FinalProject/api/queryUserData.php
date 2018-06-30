<?php
	# DEBUG MODE
	define ('DEBUG', true);
	if (DEBUG):
		ini_set( "display_errors", "1" );
	endif;

	# Source php
    include './config/db.php';

    $id = $_GET['id'];


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


    $sql = 'SELECT * FROM Users WHERE id = ' . $id;
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

		$profile = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
			$profile[] = array("id" => $row['id'], "name" => $row['name'], "email" => $row['email']);
		}
        echo json_encode($profile);

	} else {
		echo "Err: 0 results. <br>";
		return false;
	}

	$conn->close();

?>
