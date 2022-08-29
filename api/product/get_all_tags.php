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
$stmt = $tags->get_all_tags_name_sort();

//make a new array
$tag_arr = array();
$tag_arr["all_tags"]=array();
//retrieve table contents
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	extract($row);
		
	$tag_id = $row["tag_id"];
	$tag_names = $row["tag_names"];
	$tag_type = $row["tag_type"];
	$tag_link_count = $row["tag_link_count"];
	$tag_initial = $tag_names[0];
		
	$tag_item=array(
		"id"=>$tag_id,
		"names"=>$tag_names,
		"type"=>$tag_type,
		"initial"=>$tag_initial,
		"tag_link_count"=>$tag_link_count
	);
	array_push($tag_arr["all_tags"],$tag_item);
}
	
	http_response_code(200);
	
	echo json_encode($tag_arr);	

?>