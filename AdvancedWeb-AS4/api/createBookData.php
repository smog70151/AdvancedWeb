<?php

  header('Content-type: text/html; charset=utf-8');
  header('Vary: Accept-Language');

  # DEBUG MODE
  define ('DEBUG', true);
  if (DEBUG):
    ini_set( "display_errors", "1" );
  endif;

  # Source php
  include './config/db.php';

  function createBookData($uID = 1, $name = 'admin', $imgURL = 'imgURL', $dept = 'cs', $courseID = 1, $level = 1, $price = 1, $note = 'no', $status = 0) {

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

    ## Books u_id, b_id, b_name, b_imgURL, b_dept, b_courseID, b_level, b_price, b_note, b_status, b_date

    $sql_TB = "INSERT INTO Books (u_id, b_name, b_imgURL, b_dept, b_courseID, b_level, b_price, b_note, b_status) VALUES ";
    $sql_DATA = '("' . $uID .  '", "' . $name . '", "' . $imgURL . '", "' . $dept . '", "' . $courseID . '", "' . $level . '", "' . $price . '", "' . $note . '", "' . $status . '")';
    $sql = $sql_TB . $sql_DATA;
    echo $sql;
    $result = $conn->query($sql);

    if ($result !== false) {
      echo "The book data created successfully. <br>";
    } else {
      echo "Err: " . $sql . "<br>";
      return false;
    }

    $conn->close();

    return true;

  }

  $name = $_GET['BookName'];
  $courseID = $_GET['CourseName'];
  $price = $_GET['price'];
  $imgURL = $_GET['imgURL'];
  $dept = $_GET['Department'];
  $note = $_GET['note'];
  $level = $_GET['level'];
  createBookData(1,$name,$imgURL,$dept,$courseID,$level,$price,$note,0);

?>
