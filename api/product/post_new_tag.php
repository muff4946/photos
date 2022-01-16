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



//get image id from url
$tagid= isset($_GET['tag']) ? $_GET['tag'] : '';
$tagtype= isset($_GET['type']) ? $_GET['type'] : 'individual';

if($tagid != ''){

	//get array of tag ids
	$stmt = $tags->create($tagid,$tagtype);
	http_response_code(200);
	echo json_encode(
		array("message"=> $tagid . " added")
	);
	
}
else{
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No new id given")
	);
}
?>