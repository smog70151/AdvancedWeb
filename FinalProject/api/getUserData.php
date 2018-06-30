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
	// TODO Implement SQL
	$sql = 'SELECT * FROM Users WHERE id = "' . $id . '"' ;
	# echo $sql, '<br>';
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
		$user = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
			$user[] = array("id" => $row['id'], "name" => $row['name'], "pic" => $row['pic']);
		}
		echo json_encode($user, utf-8);
	} else {
		echo "Err: 0 results. <br>";
		return false;
	}

	$conn->close();

?>
