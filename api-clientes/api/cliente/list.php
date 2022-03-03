<?php 
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST, GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include("../../config/class.connection.php");
	include("../../class/class.cliente.php");

	$cliente = new cliente();

	$params = $_GET;
	$response = array();

	if (isset($params['idCliente'])) {
		$response = $cliente->list($params);
	} else {
		$response = $cliente->list();
	}

	if (!empty($response)) {
		if ($response["status"]=="success") {
			if ($response["total"] == 0) {
				$response = array("status"=>"error", "error" => "Cliente no disponible");
			}
		}
	}
	
	echo json_encode($response);
?>