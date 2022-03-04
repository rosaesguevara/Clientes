<?php 
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST, GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include("../../config/class.connection.php");
	include("../../class/class.municipio.php");

	$municipio = new municipio();

	$params = array();
	$response = array();
	
	$response = $municipio->list();
	if ($response["status"] == "success") {
		if ($response["total"] == 0) {
			$response["object"] = array();
		}
	} else { 
		$response = array("status"=>"error", "error" => "Municipio no disponible");
	}

	
	echo json_encode($response);
?>