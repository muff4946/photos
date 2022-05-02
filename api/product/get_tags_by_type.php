<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/dbclass.php';
include_once '../objects/tags.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object 
$tags = new tags($db);

//get tag_type from url
$tagtype=isset($_GET['type']) ? $_GET['type'] : '';

if($tagtype !=''){
	//get array of tags
	if($tagtype=='other'){
		$stmt = $tags->get_tag_no_type();
	}
	else{
		$stmt = $tags->get_tag_by_type($tagtype);
	}
	//make a new array
	$tag_arr = array();
	$tag_arr["tags"]=array();
	//retrieve table contents
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		
		$tag_id = $row["tag_id"];
		$tag_names = $row["tag_names"];
		$tag_type = $row["tag_type"];
		
		$tag_item=array(
			"id"=>$tag_id,
			"names"=>$tag_names,
			"type"->$tag_type
		);
		array_push($tag_arr["tags"],$tag_item);
	}
	
	http_response_code(200);
	
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