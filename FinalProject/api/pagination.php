<?php
	# Source php
	include './config/db.php';

	# DB - conn
	$hostname = DBHOST;
	$username = DBUSER;
	$password = DBPWD;
	$dbname   = DBNAME;

	$conn = new mysqli ($hostname, $username, $password, $dbname);
	$conn->set_charset("utf-8");
	mysqli_query($conn, "SET NAMES UTF8");

	if ($conn->connect_error) {
		die('Connect Error: ' . $conn->connect_error);
	}

	# TODO : GET TOTAL Number
	$sql = "SELECT COUNT(*) FROM Books";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result);

	$numBooks = $row[0];
	$perPage  = 12;
	$totalPage = ceil($numBooks/$perPage);

	if (isset($_GET['curPage']) && is_numeric($_GET['curPage'])) {
		$curPage = (int) $_GET['curPage'];
		$curPage = mysqli_real_escape_string($curPage);
		if ($curPage > $totalPage) {
			$curPage = $totalPage;
		} else if ($curPage < 1) {
			$curPage = 1;
		}
	} else {
		$curPage = 1;
	}

	$offset = ($curPage - 1) * $perPage;

	$sql = "SELECT * FROM Books LIMIT $offset, $perPage";
	$result = $conn->query($sql);
	$booksInfo = array();
	while ($book = mysqli_fetch_assoc($result)) {
		$booksInfo[] = $book;
	}

	echo json_encode($booksInfo);
	$conn->close();

 ?>
