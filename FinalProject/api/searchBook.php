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
// 	if(isset($_POST['id']) && !empty($_POST['id'])) {
//     $id = $_POST['id'];
//   }
// 	if(isset($_GET['id']) && !empty($_GET['id'])) {
// 		$id = $_GET['id'];
// 	}
    //$price = $_GET['price'];

    //$search = 'digita%';
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

    $search = $_GET['search'];
	$search = mysqli_real_escape_string($conn, $search);
	echo $search;

    // TODO Implement SQL
    $sql = 'SELECT * FROM Books WHERE b_name LIKE "' . $search;
    //echo $sql;

	$result = $conn->query($sql);

	if ($result !== false) {
	    //echo $result;
	} else {
		echo "Err: " . $sql . "<br>";
		return false;
	}

	// # Check Whether Data exists
	// // TODO Get the row num
    //echo $result->num_rows;
    $rows = $result->num_rows;
	if ($result->num_rows) {
		$books = array();
		// TODO Implement fetch row function
		while ($row = mysqli_fetch_assoc($result)) {
			$books[] = array("bookName" => $row['b_name'], "bookDept" => $row['b_dept'], "pic" => $row['b_imgURL'], "price" => $row['b_price'], "courseID" => $row['b_courseID' ], "teacher" => "", "bookID" => $row['b_id']);
		}
		//echo json_encode($books, utf-8);
	} else {
		echo "Sorry, we don't have the book 抱歉，無相關結果";
		return false;
    }

    for($i = 0; $i < $rows; $i = $i + 1){
        //print_r($books);
        $sql = 'SELECT * FROM Courses WHERE id = ' . $books[$i]['courseID'] . '';
        //echo $sql;
        $result1 = $conn->query($sql);

        if ($result1 !== false) {
            //echo $result;
        } else {
            echo "Err: " . $sql . "<br>";
            return false;
        }

        if ($result1->num_rows) {
            // $books = array();
            // TODO Implement fetch row function
            while ($row = mysqli_fetch_assoc($result1)) {
                $books[$i]['teacher'] = $row['c_teacher'];
            }
        } else {
            echo "Sorry, we don't have the book 抱歉，無相關結果";
            return false;
        }
        echo "
								<div data-bookName = \"".$books[$i]['bookName']."\" data-bookDept = \"".$books[$i]['bookDept']."\" class=\"book col-sm-6 col-md-3\">
									<div class=\"thumbnail\">
										<a href=\"./form/book.php?dept=".$books[$i]['bookDept']."&b_id=".$books[$i]['bookID']."\">
											<div class=\"book_img\">
												<img src=\"".$books[$i]['pic']."\">
											</div>
											<div class=\"book_info caption\">
												<div class=\"name\">".$books[$i]['bookName']."</div>
												<div class=\"tags_container\">
													<div class=\"tag sub_tag\">".$books[$i]['bookDept']."</div>
													<div class=\"tag pro_tag\">".$books[$i]['teacher']."</div>
												</div>
												<div class=\"price\">
													<p>NT$ ".$books[$i]['price']."</p>
												</div>
											</div>
										</a>
									</div>
								</div>
								";
    }
    //echo json_encode($books, utf-8);

	$conn->close();

?>
