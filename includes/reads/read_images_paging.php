<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once 'config/core.php';
include_once 'shared/utilities.php';
include_once 'config/dbclass.php';
include_once 'objects/images.php';


//utilities
$utilities = new Utilities();


// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize object
$images = new images($db);

//get keywords
$keywords=isset($_GET['name']) ? $_GET['name'] : '';

$stmt = $images->readPaging($from_record_num, $records_per_page, $keywords);
$num = $stmt->rowCount();

//check if more than 0 record found
if($num>0){
	$images_arr = array();
	$images_arr["records"]=array();
	$images_arr["paging"]=array();
	$count = 1;
	//retrieve table contents
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row 
		//this will make row['name'] to just $name 
		extract($row);
		
		$image_item=array(
			"id" => $image_id,
			"hash"=> $image_hash,
			"path" => $image_path,
			"file" => $image_file,
			"count" => $count
		);
		$count = $count+1;
		array_push($images_arr["records"],$image_item);
	}
	
	//include paging
	$total_rows=$images->count($keywords);
	$page_url="{$home_url}api/product/read_images_paging.php?";
	$paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
	$images_arr["paging"]=$paging;
	$images_arr["per_page"]=$records_per_page;
	
	
	//set response code - 200 OK
	http_response_code(200);
	
	//make it json format
	echo json_encode($images_arr);
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
	

