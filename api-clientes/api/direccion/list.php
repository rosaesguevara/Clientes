<?php 
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST, GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include("../../config/class.connection.php");
	include("../../class/class.direccion.php");

	$direccion = new direccion();

	$params = $_GET;
	$response = array();

	if (empty($params)) {
		$response = $direccion->list();
	} else {
		$response = $direccion->list($params);
	}

	if (!empty($response)) {
		if ($response["status"] == true) {
			if ($response["total"] == 0) {
				$response["object"] = array();
			}
		} else { 
			$response = array(
				"status"=>false, 
				"msg" => "Direccion no disponible"
			);
		}
	}
	
	echo json_encode($response);
?>