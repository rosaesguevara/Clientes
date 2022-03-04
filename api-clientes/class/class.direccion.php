<?php 

class direccion{

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
                if (isset($params['idCliente'])) {
                    $sql = 'SELECT d.idDireccion, d.direccion, m.idMunicipio, m.municipio, dep.departamento
                            FROM direccion AS d
                            INNER JOIN municipio AS m ON d.idMunicipio=m.idMunicipio
                            INNER JOIN departamento AS dep ON m.idDepartamento=dep.idDepartamento
                            WHERE d.idCliente=:idCliente
                            ORDER BY d.direccion ASC';
                    $query = $connect->prepare($sql);
                    $query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
                } elseif (isset($params['idDireccion'])) {
                    $sql = 'SELECT d.idDireccion, d.direccion, m.idMunicipio, m.municipio, dep.departamento
                            FROM direccion AS d
                            INNER JOIN municipio AS m ON d.idMunicipio=m.idMunicipio
                            INNER JOIN departamento AS dep ON m.idDepartamento=dep.idDepartamento
                            WHERE d.idDireccion=:idDireccion
                            ORDER BY d.direccion ASC';
                    $query = $connect->prepare($sql);
                    $query->bindParam(":idDireccion", $params["idDireccion"], PDO::PARAM_INT);
                } else {
                    $sql = 'SELECT d.idDireccion, d.direccion, m.idMunicipio, m.municipio, dep.departamento
                                FROM direccion AS d
                                INNER JOIN municipio AS m ON d.idMunicipio=m.idMunicipio
                                INNER JOIN departamento AS dep ON m.idDepartamento=dep.idDepartamento
                                ORDER BY d.direccion ASC';
                    $query = $connect->prepare($sql);
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
                    if((isset($params["idDireccion"])) && ($params["idDireccion"]!="")) { 
                        $sql = "UPDATE direccion SET direccion=:direccion WHERE idDireccion=:idDireccion";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":direccion", $params["direccion"], PDO::PARAM_STR);
                        $query->bindParam(":idDireccion", $params["idDireccion"], PDO::PARAM_INT);
                    } else {
                        $sql = "INSERT INTO direccion (direccion, idCliente, idMunicipio) VALUES (:direccion, :idCliente, :idMunicipio)";
                        $query = $connect->prepare($sql);
                        $query->bindParam(":direccion", $params["direccion"], PDO::PARAM_STR);
                        $query->bindParam(":idCliente", $params["idCliente"], PDO::PARAM_INT);
                        $query->bindParam(":idMunicipio", $params["idMunicipio"], PDO::PARAM_INT);
                    }
                    if ($query->execute()){
                        $idDireccion=intval($connect->lastInsertId());
                        if((isset($params["idDireccion"])) && ($params["idDireccion"]!="")) { 
                            $response["insertId"] = $params['idDireccion'];
                            $this->audit(3, $params);
                        } else {
                            $response["insertId"] = $idDireccion;
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
                    $sql = "DELETE FROM direccion WHERE idDireccion=:idDireccion";
                    $query = $connect->prepare($sql);
                    $query->bindParam(":idDireccion", $params["idDireccion"], PDO::PARAM_INT);
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
                        $params["accion"] = 'Se consultaron los registros de la tabla direccion';
                    break;
                    case '2':
                    # INSERT
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se inserto un registro en la tabla direccion: '.$params["datos"];
                    break;
                    case '3':
                    # UPDATE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se modifico un registro de la tabla direccion: '.$params["datos"];
                    break;
                    case '4':
                    # DELETE
                        $params["datos"] = $connection->array_to_string($params);
                        $params["accion"] = 'Se elimino un registro de la tabla direccion: '.$params["datos"];
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