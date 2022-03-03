<?php 
    header("Access-Control-Allow-Origin: ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include("../../config/class.connection.php");
    include("../../class/class.cliente.php");

    $cliente = new cliente();

    # $params = json_decode(file_get_contents("php://input"), true); 
    $params = $_POST; 
    $response = array();

    $params_incomplete = array();
    $param_list = array("nombres", "apellidos");
    foreach ($param_list as $param) {
        if (!(isset($params[$param]))) {
            array_push($params_incomplete, $param);
        }
    }

    if (empty($params_incomplete)) {
        $response = $cliente->save($params);
        if ($response["status"]=="success") {
            if ($response["insertId"]==0) {
                $response = array("status"=>"error", "error" => "El cliente no pudo ser ingresado");
            }
        }
    } else {
        $response = array("status"=>"error", "error" => "No se pudo ingresar el cliente. Los datos están incompletos");
    }

    echo json_encode($response);
?>