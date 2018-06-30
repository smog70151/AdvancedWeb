<?php
// header('Access-Control-Allow-Origin: *');
header('content-type:application/json;charset=utf8');
/* Conn URL */
ini_set("allow_url_fopen", 1);
/* Database Info */
$servername = "localhost";
$username = "root";
$password = "s51595679";
$dbname = "mysql";

/* Pagination Info */
$per_page = 12;
$page_query = "SELECT COUNT(`id`) FROM (`videoList`)";

// Conn mySQL
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// Total Pages
$pages = ceil(mysqli_query($conn, $page_query)/$per_page);

if (!isset($_GET['page']))
{
  // Default
  header("location: pagination.php?page=1");
}
else
{
  // Get the Page atrrb
  $page = $_GET['page'];
}

$start = (($page-1)*$per_page);

// SQL
$sql = "SELECT id, vid, title FROM videoList LIMIT $start, $per_page";
// Send SQL to DB
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    // Init the json Data
    $videoList = array();
    $cnt = 0;
    while($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      // echo $id. "<br>";
      $vid = $row['vid'];
      // echo $vid. "<br>";
      $title = $row['title'];
      // echo $title. "<br>";

      if ($row["vid"]="")
        break;

      $videoList[] = array("id" => $row["id"], "vid" => $vid, "title" => $row["title"]);

      // echo json_encode(array("id" => $row["id"], "vid" => $row["vid"], "title" => $row["title"]));
      $cnt = $cnt + 1;
    }


    echo json_encode($videoList);
    // var_dump(json_last_error());

    if (json_encode($videoList) === fasle) {
      echo "Wrong !";
    }

} else {
    echo "0 结果";
}

$conn->close();
?>
