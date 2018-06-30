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
$sql = 'SELECT * FROM Books WHERE Books.u_id = '.$_GET['id'];
$result = $conn->query($sql);

$conn->close();
?>
