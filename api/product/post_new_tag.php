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
$taglinks = new tag_links($db);


//get tag type and names from URL
$tag_type= isset($_GET['tag_type']) ? $_GET['tag_type'] : '';
$tag_names= isset($_GET['tag_names']) ? $_GET['tag_names'] : '';

print $tag_type;
print $tag_names;
//print $tags;

$stmt = $tags->get_highest_tag_id();

$OUTPUT = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($OUTPUT);

exit ();
?>


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