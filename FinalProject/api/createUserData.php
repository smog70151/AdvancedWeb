<?php

  header('Content-type: text/html; charset=utf-8');
  header('Vary: Accept-Language');

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
    //function createUserData($id, $name, $email, $pic) {

      if(isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $pic = $_POST['pic_url'];
        $email = $_POST['email'];
        $id = mysqli_real_escape_string($conn, $id);
        $name = mysqli_real_escape_string($conn, $name);
        $pic = mysqli_real_escape_string($conn, $pic);
        $email = mysqli_real_escape_string($conn, $email);
      }

    mysqli_query($conn, "SET NAMES UTF8");

    ## Users (id, name, email, pic, reg_date)
		$pic = 'http://graph.facebook.com/' . $id . '/picture?type=square';
    $sql_TB = "INSERT INTO Users (id, name, email, pic) VALUES ";
    $sql_DATA = '("' . $id .  '", "' . $name . '", "' . $email . '", "' . $pic . '")';
    $sql = $sql_TB . $sql_DATA;

    $result = $conn->query($sql);

    if ($result !== FASLE) {
      # echo "The data created successfully. <br>";
    } else {
      echo "Err: " . $sql . "<br>";
      return false;
    }

    $conn->close();

    return true;

//  }

?>
