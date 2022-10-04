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

//get array of tags
$stmt = $tags->get_tag_types();

//make a new array
$tag_arr = array();
$tag_arr["tag_type"]=array();
//retrieve table contents
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	extract($row);
		
	$tag_type = $row["tag_type"];
		
	$tag_item=array(
		"type"=>$tag_type
	);
	array_push($tag_arr["tag_type"],$tag_item);
}
	
	http_response_code(200);
	
	echo json_encode($tag_arr);	

?>