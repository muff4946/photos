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
$tags = new tags($db);

//get image id from url
$tagid= isset($_GET['tags']) ? $_GET['tags'] : '';

//query images
$stmt = $tags->get_tags_info_by_ids($tagid);

$num = $stmt->rowCount();
if ($num>0){
	$tag_arr = array();
	
	$tag_arr["tags"]=array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
		extract ($row);
		
		$tag_id = $row["tag_id"];
		$tag_names = $row["tag_names"];
		$tag_type = $row["tag_type"];


		$tag_info = array(
			"id"=>$tag_id,
			"names"=>$tag_names,
			"type"=>$tag_type,
		);
		array_push ($tag_arr["tags"],$tag_info);
	}

	//set response code - 200 OK
	http_response_code(200);

	//make it json format
	echo json_encode($tag_arr);
}
else{
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No products found.")
	);

}

?>