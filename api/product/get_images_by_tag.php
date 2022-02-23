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
$numTags= isset($_GET['num']) ? $_GET['num'] : '';

//get array of tag ids
$stmt = $images->imagesByTags($tagid, $numTags);
$num = $stmt->rowCount();

//go through array and get all of the images that match these tag ids
if($num>0){
	$image_arr = array();
	//return these
	$image_arr["images"]=array();
	//retrieve table contents
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		//Dads work getting image and thumbnail path
		//copied from tagged-photo-list.php
		$db_image_path = $row["image_path"];
		$db_image_name = $row["image_file"];
		$web_image_path = str_replace ("\\", "/", $db_image_path);
		$web_image_path = str_replace ("D:/pictures", "https://photos.dbq-andersons.com/storage", $web_image_path);
		$web_thumb_path = str_replace ("storage", "thumbs", $web_image_path);
		$local_thumb_path = str_replace ("https://photos.dbq-andersons.com/storage", "/tools/webdocs/photos/thumbs", $web_image_path);
		
		$image_item=array(
			"id" => $image_id,
			"hash"=> $image_hash,
			"file" => $image_file,
			"path" => $image_path,
			"image" => $web_image_path,
			"thumb" => $web_thumb_path,
			"num" => $num
		);
		array_push($image_arr["images"],$image_item);
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