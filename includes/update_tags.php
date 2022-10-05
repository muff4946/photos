<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once 'global-functions.php';
include_once 'db-connection.php';
include_once 'sql/tags-sql.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize objects
$tags = new tags($db);

//get information from url
$tag_id= isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
$new_tag_names= isset($_GET['new_tag_names']) ? $_GET['new_tag_names'] : '';
$new_tag_type= isset($_GET['new_tag_type']) ? $_GET['new_tag_type'] : '';


if($tag_id != ''&&$new_tag_names != ''&&$new_tag_type != ''){

	//get array of tag ids
	$stmt = $tags->update($tag_id,$new_tag_names,$new_tag_type);
	http_response_code(200);
	echo json_encode(
		array("message"=> "Tag no. " . $tag_id . " is now " . $new_tag_names . " with a type of " . $new_tag_type)
	);
	
}
else{
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "Not enough variables provided")
	);
}
?>