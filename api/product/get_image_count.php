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



while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	extract($row);
		
	$image_count=array(
	  "count" => $COUNT(\*),
	);
	
}

?>

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