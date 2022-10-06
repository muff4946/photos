<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/dbclass.php';
include_once '../objects/tag_links.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object 
$tag_links = new tag_links($db);

//query tag_links
$stmt = $tag_links ->read();
$num = $stmt ->rowCount();

//check if more than 0 found
if($num>0){
	//array
	$tag_links_arr = array();
	$tag_links_arr["records"]=array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		$tag_links_item=array(
			"link_id" => $link_id,
			"image_id"=> $image_id,
			"tag_id" => $tag_id
		);
		
		array_push($tag_links_arr["records"],$tag_links_item);
	}
	
	//set response code - 200 OK
	http_response_code(200);
	
	//show products data in json format
	echo json_encode($tag_links_arr);
}
else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No products found.")
	);
}
?>
