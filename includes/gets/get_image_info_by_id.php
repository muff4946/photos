<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../global-functions.php';
include_once '../db-connection.php';
include_once '../sql/images-sql.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object
$images = new images($db);

//get image id from url
$imageid= isset($_GET['image']) ? $_GET['image'] : '';

//query images
$stmt = $images->getImageById($imageid);

//retrieve contents
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//grab the rows
$image_id = $row["image_id"];
$image_hash = $row["image_hash"];
$image_path = $row["image_path"];
$image_file = $row["image_file"];
$web_image_path = str_replace ("\\", "/", $image_path);
$web_image_path = str_replace ("D:/pictures", "https://www.dbq-andersons.com/photos-fork/storage", $web_image_path);

$image_info = array(
	"id"=>$image_id,
	"hash"=>$image_hash,
	"path"=>$image_path,
	"file"=>$image_file,
	"webpath"=>$web_image_path
);

//set response code - 200 OK
http_response_code(200);

//make it json format
echo json_encode($image_info);


?>