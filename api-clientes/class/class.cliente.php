<?php 

class cliente{

	function __construct() {
		// implementation
   	}

    function list($params=array()){
    	$response = array();
    	$connection = new connection();
    	$connect = $connection->connect(); 
    	if ($connect!=null) {
			$response["status"] = "success";
	    	try {
	    		if (empty($params)) {
			    	$sql = 'SELECT DISTINCT c.idCliente, c.nombres, c.apellidos, 
                                    IFNULL(GROUP_CONCAT(CONCAT(td.tipoDocumento, ": ", d.numeroDocumento) SEPARATOR "<br>"), "") as documentos,
                                    IFNULL(GROUP_CONCAT(CONCAT(dir.direccion, ", ", m.municipio, ", ", dep.departamento)SEPARATOR "<br>"), "") as direcciones 
                                FROM cliente AS c 
                                LEFT JOIN documento as d ON c.idCliente=d.idCliente
                                LEFT JOIN tipodocumento as td ON d.idTipoDocumento=td.idTipoDocumento
                                LEFT JOIN direccion as dir ON c.idCliente=dir.idCliente
                                LEFT JOIN municipio as m ON dir.idMunicipio=m.idMunicipio
                                LEFT JOIN departamento as dep ON m.idDepartamento=dep.idDepartamento
                                GROUP BY c.idCliente
                                ORDER BY c.nombres ASC';
				    $query = $connect->prepare($sql);
	    		} else {
	    			$sql = 'SELECT DISTINCT c.idCliente, c.nombres, c.apellidos, 
                                    IFNULL(GROUP_CONCAT(CONCAT(td.tipoDocumento, ": ", d.numeroDocumento) SEPARATOR "<br>"), "") as documentos,
                                    IFNULL(GROUP_CONCAT(CONCAT(dir.direccion, ", ", m.municipio, ", ", dep.departamento)SEPARATOR "<br>"), "") as direcciones 
                                FROM cliente AS c 
                                LEFT JOIN documento as d ON c.idCliente=d.idCliente
                                LEFT JOIN tipodocumento as td ON d.idTipoDocumento=td.idTipoDocumento
                                LEFT JOIN direccion as dir ON c.idCliente=dir.idCliente
                                LEFT JOIN municipio as m ON dir.idMunicipio=m.idMunicipio
                                LEFT JOIN departamento as dep ON m.idDepartamento=dep.idDepartamento
                                WHERE c.idCliente=:idCliente
                                GROUP BY c.idCliente
                                ORDER BY c.nombres ASC';
				    $query = $connect->prepare($sql);
	    			$query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
	    		}
                if ($query->execute()){
                    $response["object"] = $query->fetchAll(PDO::FETCH_ASSOC);
                    $response["total"] = $query->rowCount();
                    $this->audit(1, $params);
                } else {
                    $response = array("status"=>"error", "error"=>"No se pudo ejecutar la consulta a la base de datos");
                }
			} catch(PDOException $exception) {
		    	$response = array("status"=>false, "error"=>"Ocurrió el siguiente error: " . $exception->getMessage());
            } finally {
                $connection->disconnect();
            }
	    } else {
	    	$response = array("status"=>false, "error"=>"No está conectado al servidor de bases de datos");
	    } 
	    return $response;
    }

    function save($params=array()){
        $response = array();
        $connection = new connection();
        $connect = $connection->connect(); 
        if (!empty($params)) {
            if ($connect!=null) {
                $response["status"] = "success";
                try {
                    $connect->beginTransaction();
                    if((isset($params["idCliente"])) && ($params["idCliente"]!="")) { 
                        $sql = "UPDATE cliente SET nombres=:nombres, apellidos=:apellidos WHERE idCliente=:idCliente";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":nombres", $params["nombres"], PDO::PARAM_STR);
                        $query->bindParam(":apellidos", $params["apellidos"], PDO::PARAM_STR);
                        $query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
                    } else {
                        $sql = "INSERT INTO cliente (nombres, apellidos) VALUES (:nombres, :apellidos)";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":nombres", $params["nombres"], PDO::PARAM_STR);
                        $query->bindParam(":apellidos", $params["apellidos"], PDO::PARAM_STR);
                    }
                    if ($query->execute()){
                        $idCliente=intval($connect->lastInsertId());
                        if((isset($params["idCliente"])) && ($params["idCliente"]!="")) { 
                            $response["insertId"] = $params['idCliente'];
                            $this->audit(3, $params);
                        } else {
                            $response["insertId"] = $idCliente;
                            $this->audit(2, $params);
                        }
                        $response["total"] = $query->rowCount();
                    } else {
                        $response = array("status"=>"error", "error"=>"No se pudo ejecutar la consulta a la base de datos");
                    }
                    $connect->commit();
                } catch(PDOException $exception) {
                    $connect->rollback();
                    $response = array("status"=>false, "error"=>"Ocurrió el siguiente error: " . $exception->getMessage());
                } finally {
                    $connection->disconnect();
                }
            } else {
                $response = array("status"=>false, "error"=>"No está conectado al servidor de bases de datos");
            }
        } else {
            $response = array("status"=>false, "error"=>"No está enviando ningún parámetro a la función");
        } 
        return $response;
    }

    function delete($params=array()){
        $response = array();
        $connection = new connection();
        $connect = $connection->connect(); 
        if (!empty($params)) {
            if ($connect!=null) {
                $response["status"] = "success";
                try {
                    $connect->beginTransaction();
                    $sql = "DELETE FROM cliente WHERE idCliente=:idCliente";
                    $query = $connect->prepare($sql);
                    $query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
                    if ($query->execute()){
                        $response["total"] = $query->rowCount();
                        $this->audit(4, $params);
                    } else {
                        $response = array("status"=>"error", "error"=>"No se pudo ejecutar la consulta a la base de datos");
                    }
                    $connect->commit();
                } catch(PDOException $exception) {
                    $connect->rollback();
                    $response = array("status"=>false, "error"=>"Ocurrió el siguiente error: " . $exception->getMessage());
                } finally {
                    $connection->disconnect();
                }
            } else {
                $response = array("status"=>false, "error"=>"No está conectado al servidor de bases de datos");
            }
        } else {
            $response = array("status"=>false, "error"=>"No está enviando ningún parámetro a la función");
        } 
        return $response;
    }

    function audit($type=1, $params=array()){
        $response = array();
        $connection = new connection();
        $connect = $connection->connect(); 
        if ($connect!=null) {
            $response["status"] = "success";
            try {
                switch ($type) {
                    case '1':
                    # SELECT
                        $params["accion"] = 'Se consultaron los registros de la tabla cliente';
                    break;
                    case '2':
                    # INSERT
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se inserto un registro en la tabla cliente: '.$params["datos"];
                    break;
                    case '3':
                    # UPDATE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se modifico un registro de la tabla cliente: '.$params["datos"];
                    break;
                    case '4':
                    # DELETE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se elimino un registro de la tabla cliente: '.$params["datos"];
                    break;
                    default:
                        $params["accion"]='';
                    break;
                }
                $sql = "INSERT INTO auditoria (accion, fecha) VALUES (:accion, NOW())";
                $query = $connect->prepare($sql);
                $query->bindParam(":accion", $params["accion"], PDO::PARAM_STR);
                if ($query->execute()){
                    $response["total"] = $query->rowCount();
                }
            } catch(PDOException $exception) {
                $response = array("status"=>false, "error"=>"Ocurrió el siguiente error: " . $exception->getMessage());
            } finally {
                $connection->disconnect();
            }
        } else {
            $response = array("status"=>false, "error"=>"No está conectado al servidor de bases de datos");
        } 
        return $response;
    }
}
?>