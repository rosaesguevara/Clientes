<?php 
    header("Access-Control-Allow-Origin: ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include("../../config/class.connection.php");
    include("../../class/class.cliente.php");

    $cliente = new cliente();

    $params = $_POST; 
    $response = array();

    $not_exist = array();
    $param_list = array("idCliente");
    foreach ($param_list as $param) {
        if (!(isset($params[$param]))) {
            array_push($not_exist, $param);
        }
    }

    if (empty($not_exist)) {
        $response = $cliente->delete($params);
        if ($response["status"]=="success") {
            if ($response["total"]==0) {
                $response = array("status"=>"error", "error" => "El cliente no pudo ser eliminado");
            }
        }
    } else {
        $response = array("status"=>"error", "error" => "No se pudo eliminar el cliente. Los datos están incompletos");
    }

    echo json_encode($response);
?>