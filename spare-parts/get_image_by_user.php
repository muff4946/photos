<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/dbclass.php';
include_once '../objects/users.php';

// instantiate database and product object
$database = new DBClass();
$db = $database->getConnection();

//initialize objects
$users = new users($db);

$user_n = isset($_GET['user']) ? $_GET['user']:'';

$stmt = $users->getImage($user_n);
$num = $stmt->rowCount();

if($num>0){
	$num_arr = array();
	$num_arr["images"]=array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$row_item = array(
			"id"=> $user_id,
			"user"=> $user_name,
			"image"=> $image_number
		);
		
		array_push($num_arr["images"],$row_item);
	}
	
	//set response code - 200 OK
	http_response_code(200);

	//make it json format
	echo json_encode($num_arr);
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