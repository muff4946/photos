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

//get use from url
$use= isset($_GET['use']) ? $_GET['use'] : '';
//get image id from url
$imageid= isset($_GET['image']) ? $_GET['image'] : '';


//get array of tag ids
if($use == "edit"){
	$stmt = $taglinks->tagsByImage4Edit($imageid);
} else{
	$stmt = $taglinks->tagsByImage4View($imageid);
}

$num = $stmt->rowCount();

//go through array and get all of the tags associated with the tag ids
if($num>0){
	$tag_arr = array();
	//return these
	$tag_arr["tags"]=array();
	$tag_arr["tag_links"]=array();
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
		
		
		array_push($tag_arr["tag_links"],$image_item);
	}
	
	//go through the array to get the tag names
	foreach($tag_arr["tag_links"] as $link){
		$tags_id = $link['tag'];
		$stmt = $tags->get_tag($tags_id);
		$num = $stmt->rowCount();
		//if($num>0){
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$tag_item=array(
					"id"=>$tag_id,
					"name"=>$tag_names,
					"type"=>$tag_type
				);
				array_push($tag_arr["tags"],$tag_item);
			}
		//}
		
	}
	
	//set response code - 200 OK
	http_response_code(200);

	//make it json format
	echo json_encode($tag_arr);
}
else{
	//set response code - 404 Not found
	http_response_code(201);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No products found.")
	);
}


?>