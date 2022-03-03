<?php 
    header("Access-Control-Allow-Origin: ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include("../../config/class.connection.php");
    include("../../class/class.documento.php");

    $documento = new documento();

    $params = $_POST; 
    $response = array();

    $not_exist = array();
    $param_list = array("idDocumento");
    foreach ($param_list as $param) {
        if (!(isset($params[$param]))) {
            array_push($not_exist, $param);
        }
    }

    if (empty($not_exist)) {
        $response = $documento->delete($params);
        if ($response["status"]=="success") {
            if ($response["total"]==0) {
                $response = array("status"=>"error", "error" => "El documento no pudo ser eliminado");
            }
        }
    } else {
        $response = array("status"=>"error", "error" => "No se pudo eliminar el documento. Los datos están incompletos");
    }

    echo json_encode($response);
?>