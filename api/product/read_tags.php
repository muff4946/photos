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

//query tags
$stmt = $tags ->read();
$num = $stmt ->rowCount();

//check if more than 0 found
if($num>0){
	//array
	$tags_arr = array();
	$tags_arr["records"]=array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		$tags_item=array(
			"tag_id" => $tag_id,
			"tag_name"=> $tag_name
		);
		
		array_push($tags_arr["records"],$tags_item);
	}
	
	//set response code - 200 OK
	http_response_code(200);
	
	//show products data in json format
	echo json_encode($tags_arr);
}
else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No products found.")
	);
}
?>
