<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../global-functions.php';
include_once '../db-connection.php';
include_once '../sql/tags-sql.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object
$tags = new tags($db);

//get tag id from url
$tag_id= isset($_GET['tag_id']) ? $_GET['tag_id'] : '';

if($tag_id != ''){

	//delete tag from database
	$stmt = $tags->delete_tag($tag_id);
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