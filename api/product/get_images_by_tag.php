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
$images = new images($db);

//get image id from url
$tagid= isset($_GET['tag']) ? $_GET['tag'] : '';

//get array of tag ids
$stmt = $taglinks->imagesByTag($tagid);
$num = $stmt->rowCount();

//go through array and get all of the tags associated with the tag ids
if($num>0){
	$image_arr = array();
	//return these
	$image_arr["images"]=array();
	$image_arr["tag_links"]=array();
	//retrieve table contents
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		$image_item=array(
			"link" => $link_id,
			"image"=> $image_id,
			"tag" => $tag_id
		);
		
		
		array_push($image_arr["tag_links"],$image_item);
	}
	
	//go through the array to get the tag names
	foreach($image_arr["tag_links"] as $link){
		$images_id = $link['image'];
		$stmt = $images->getImageById($images_id);
		$num = $stmt->rowCount();
		//if($num>0){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$image_item=array(
					"id" => $image_id,
					"hash"=> $image_hash,
					"path" => $image_path,
					"file" => $image_file
				);
				array_push($image_arr["images"],$image_item);
			}
		//}
		
	}
	
	
	
	
	
	//set response code - 200 OK
	http_response_code(200);

	//make it json format
	echo json_encode($image_arr);
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