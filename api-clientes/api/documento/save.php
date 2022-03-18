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

    if (isset($params['numeroDocumento']) && isset($params['idCliente']) && isset($params['idTipoDocumento'])) {
        if ($params['numeroDocumento']!='' && $params['idCliente']!='' && $params['idTipoDocumento']!='') {
            $response = $documento->save($params);
            if ($response["status"]==true) {
                if ($response["insertId"]==0) {
                    $response = array(
                        "status"=>false, 
                        "msg" => "El documento no pudo ser ingresado"
                    );
                }
            }
        } else {
            $response = array(
                "status"=>false, 
                "msg" => "Llene los campos correctamente"
            );
        }
    } else {
        $response = array(
            "status"=>false, 
            "msg" => "No se pudo ingresar el direccion. Los datos están incompletos"
        );
    }

    echo json_encode($response);
?>