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

    if (isset($params['idCliente'])) {
        if ($params['idCliente']!='') {
            $response = $cliente->delete($params);
            if ($response["status"]==true) {
                if ($response["total"]==0) {
                    $response = array(
                        "status"=>false, 
                        "msg" => "El cliente no pudo ser eliminado"
                    );
                }
            }
        } else {
            $response = array(
                "status"=>false, 
                "msg" => "El idCliente esta vacio"
            );
        }
    } else {
        $response = array(
            "status"=>false, 
            "msg" => "No se pudo eliminar el cliente. Los datos están incompletos"
        );
    }

    echo json_encode($response);
?>