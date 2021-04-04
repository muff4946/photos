<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
//include_once '../config/core.php';	
include_once '../config/dbclass.php';
include_once '../objects/images.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();
  
// initialize object
$images = new images($db);

//get keywords
$keywords=isset($_GET['name']) ? $_GET['name'] : '';



//query products
$stmt = $images->search_by_name($keywords);
$num=$stmt->rowCount();

//check if more than 0 record found
if($num>0){
	
	$images_arr = array();
	$images_arr["records"]=array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		$image_item=array(
			"id" => $image_id,
			"hash"=> $image_hash,
			"path" => $image_path,
			"file" => $image_file
		);
		
		array_push($images_arr["records"],$image_item);
	}
	
	//set response code - 200 OK
	http_response_code(200);
	
	//show images data in json format
	echo json_encode($images_arr);
}
else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No images found.")
	);
}
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}


?>