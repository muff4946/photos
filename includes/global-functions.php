<?php

// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//home page url
$home_url="https://photos.dbq-andersons.com";

function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}
?>