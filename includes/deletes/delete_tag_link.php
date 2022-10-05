<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../global-functions.php';
include_once '../db-connection.php';
include_once '../sql/images-sql.php';
include_once '../sql/tags-sql.php';
include_once '../sql/tag-links-sql.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize objects
$tags = new tags($db);
$taglinks = new tag_links($db);
$images = new images($db);

//get image id from url
$tagid= isset($_GET['tag']) ? $_GET['tag'] : '';
$imageid= isset($_GET['image']) ? $_GET['image'] : 'individual';

if($tagid != ''||$imageid=''){

	//get array of tag ids
	$stmt = $taglinks->deleteIt($tagid,$imageid);
	http_response_code(200);
	echo json_encode(
		array("message"=> $tagid . " removed from this image if found")
	);
	
}
else{
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No id or image given")
	);
}
?>