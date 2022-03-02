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
			$response["status"] = true;
	    	try {
	    		if (empty($params)) {
			    	$sql = 'SELECT DISTINCT c.idCliente, c.nombres, c.apellidos, GROUP_CONCAT(CONCAT(td.tipoDocumento, ": ", d.numeroDocumento) SEPARATOR "<br>") as documentos,
                    GROUP_CONCAT(CONCAT(dir.direccion, ", ", m.municipio, ", ", dep.departamento)SEPARATOR "<br>") as direcciones 
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
	    			$sql = 'SELECT DISTINCT c.idCliente, c.nombres, c.apellidos, GROUP_CONCAT(CONCAT(td.tipoDocumento, ": ", d.numeroDocumento) SEPARATOR "<br>") as documentos,
                    GROUP_CONCAT(CONCAT(dir.direccion, ", ", m.municipio, ", ", dep.departamento)SEPARATOR "<br>") as direcciones 
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
		    	$query->execute();

				$response["object"] = $query->fetchAll(PDO::FETCH_ASSOC);
				$response["total"] = $query->rowCount();
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