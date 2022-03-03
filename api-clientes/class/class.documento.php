<?php 

class documento{

	function __construct() {
		// implementation
   	}

    function list($params=array()){
    	$response = array();
    	$connection = new connection();
    	$connect = $connection->connect(); 
    	if ($connect!=null) {
			$response["status"] = true;
	    	try {
	    		if (empty($params)) {
			    	$sql = 'SELECT d.idDocumento, d.numeroDocumento, d.idCliente, td.idTipoDocumento, td.tipodocumento
                                FROM documento AS d
                                INNER JOIN tipodocumento AS td ON d.idTipoDocumento=td.idTipoDocumento
                                ORDER BY d.numeroDocumento ASC';
				    $query = $connect->prepare($sql);
	    		} else {
	    			$sql = 'SELECT d.idDocumento, d.numeroDocumento, d.idCliente, td.idTipoDocumento, td.tipodocumento
                                FROM documento AS d
                                INNER JOIN tipodocumento AS td ON d.idTipoDocumento=td.idTipoDocumento
                                WHERE d.idDocumento=:idDocumento
                                ORDER BY d.numeroDocumento ASC';
				    $query = $connect->prepare($sql);
	    			$query->bindParam(":idDocumento", $params["idDocumento"], PDO::PARAM_INT);
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
                $response["status"] = true;
                try {
                    $connect->beginTransaction();
                    if((isset($params["idDocumento"])) && ($params["idDocumento"]!="")) { 
                        $sql = "UPDATE documento SET numeroDocumento=:numeroDocumento WHERE idDocumento=:idDocumento";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":numeroDocumento", $params["numeroDocumento"], PDO::PARAM_STR);
                        $query->bindParam(":idDocumento", $params["idDocumento"], PDO::PARAM_INT);
                    } else {
                        $sql = "INSERT INTO documento (numeroDocumento, idCliente, idTipoDocumento) VALUES (:numeroDocumento, :idCliente, :idTipoDocumento)";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":numeroDocumento", $params["numeroDocumento"], PDO::PARAM_STR);
                        $query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
                        $query->bindParam(":idTipoDocumento", $params["idTipoDocumento"], PDO::PARAM_INT);
                    }
                    if ($query->execute()){
                        $idDocumento=intval($connect->lastInsertId());
                        if((isset($params["idDocumento"])) && ($params["idDocumento"]!="")) { 
                            $response["insertId"] = $params['idDocumento'];
                            $this->audit(3, $params);
                        } else {
                            $response["insertId"] = $idDocumento;
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
                $response["status"] = true;
                try {
                    $connect->beginTransaction();
                    $sql = "DELETE FROM documento WHERE idDocumento=:idDocumento";
                    $query = $connect->prepare($sql);
                    $query->bindParam(":idDocumento", $params["idDocumento"], PDO::PARAM_INT);
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
            try {
                switch ($type) {
                    case '1':
                    # SELECT
                        $params["accion"] = 'Se consultaron los registros de la tabla documento';
                    break;
                    case '2':
                    # INSERT
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se inserto un registro en la tabla documento: '.$params["datos"];
                    break;
                    case '3':
                    # UPDATE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se modifico un registro de la tabla documento: '.$params["datos"];
                    break;
                    case '4':
                    # DELETE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se elimino un registro de la tabla documento: '.$params["datos"];
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