<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/dbclass.php';
include_once '../objects/images.php';

//get keywords
$perPage=isset($_GET['num']) ? $_GET['num'] : 50;

$records_per_page = $perPage;

http_response_code(200);

echo $records_per_page;

return $records_per_page;

?>
