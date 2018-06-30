<?php
	// header('Access-Control-Allow-Origin: *');
	header('content-type:application/json;charset=utf8');

	# DEBUG MODE
  define ('DEBUG', true);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;

	/* Conn URL */
	// ini_set("allow_url_fopen", 1);
	/* Database Info */
	$servername = "localhost";
	$username = "root";
	$password = "s51595679";
	$dbname = "mysql";

	// Conn mySQL
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	}

	/* Pagination Info */
	$per_page = 12;
	$page_query = "SELECT COUNT(`id`) AS num FROM (`videoList`)";

	// Total Pages
	$result = mysqli_query($conn, $page_query);
	$row = mysqli_fetch_assoc($result);
	$pages_num = $row['num'];
	$pages = ceil($pages_num/$per_page);

 ?>
