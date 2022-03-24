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

//query images
$stmt = $images->imageCount();

//retrieve contents
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//set the image_count variable
$raw_image_count = $row["image_count"];

$pretty_image_count = number_format($raw_image_count);

$image_count = array(
	"count"=>$pretty_image_count
);

//set response code - 200 OK
http_response_code(200);

//make it json format
echo json_encode($image_count);


?>