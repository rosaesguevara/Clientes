<?php 
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST, GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include("../../config/class.connection.php");
	include("../../class/class.tipoDocumento.php");

	$tipoDocumento = new tipoDocumento();

	$params = array();
	$response = array();
	
	$response = $tipoDocumento->list();

	if ($response["status"] == "success") {
		if ($response["total"] == 0) {
			$response["object"] = array();
		}
	} else { 
		$response = array("status"=>"error", "error" => "Tipo documento no disponible");
	}
	
	echo json_encode($response);
?>