<?php 
    header("Access-Control-Allow-Origin: ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include("../../config/class.connection.php");
    include("../../class/class.direccion.php");

    $direccion = new direccion();

    $params = $_POST; 
    $response = array();

    if (isset($params['idDireccion'])) {
        if ($params['idDireccion']!='') {
            $response = $direccion->delete($params);
            if ($response["status"]==true) {
                if ($response["total"]==0) {
                    $response = array(
                        "status"=>false, 
                        "msg" => "La direccion no pudo ser eliminada"
                    );
                }
            }
        } else {
            $response = array(
                "status"=>false, 
                "msg" => "El idDireccion esta vacio"
            );
        }
    } else {
        $response = array(
            "status"=>false, 
            "msg" => "No se pudo eliminar el direccion. Los datos están incompletos"
        );
    }

    echo json_encode($response);
?>