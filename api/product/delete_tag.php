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

//initialize objects
$tags = new tags($db);
$images = new images($db);

//get image id from url
$tag_id= isset($_GET['tag_id']) ? $_GET['tag_id'] : '';

if($tag_id != ''){

	//delete tag from database
	$stmt = $taglinks->delete_tag($tag_id);
	http_response_code(200);
	echo json_encode(
		array("message"=> $tag_id . " removed from database if found")
	);
	
}
else{
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No tag id given")
	);
}
?>