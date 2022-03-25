<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/dbclass.php';
include_once '../objects/images.php';
include_once '../objects/tags.php';
include_once '../objects/tag_links.php';

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

$image_info = array(
	"id"=>$image_id,
	"hash"=>$image_hash,
	"path"=>$image_path,
	"file"=>$image_file
);

//set response code - 200 OK
http_response_code(200);

//make it json format
echo json_encode($image_info);


?>