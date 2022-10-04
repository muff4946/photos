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


//utilities
//$utilities = new Utilities();


// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object
$images = new images($db);
$tags = new tags($db);

//get keywords
$keywords=isset($_GET['keyword']) ? $_GET['keyword'] : '';
$type=isset($_GET['type']) ? $_GET['type'] : '';

$stmt = $tags->search_tags($keywords,$type);
$num = $stmt->rowCount();
//check if more than 0 record found
if($num>0){
	$tags_arr = array();
	$tags_arr["records"]=array();
	
	//retrieve table contents
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		$tag_item=array(
			"id"=>$tag_id,
			"name"=>$tag_names,
			"type"=>$tag_type
		);
		
		array_push($tags_arr["records"],$tag_item);
	}
	
	
	//set response code - 200 OK
	http_response_code(200);
	
	//make it json format
	echo json_encode($tags_arr);
}

else{
	
	//set response code - 404 Not found
	http_response_code(404);
	//tell the user products does not exist
	echo json_encode(
		array("message" => "No tags found.")
	);
}


?>
	

