<?php  

class municipio {

	function __construct() {
		// implementation
   	}

    function list(){
    	$response = array();
    	$connection = new connection();
    	$connect = $connection->connect(); 
    	if ($connect!=null) {
			$response["status"] = "success";
	    	try {
				$sql = 'SELECT m.idMunicipio, CONCAT(m.municipio,", ",d.departamento) as municipio 
				FROM municipio as m INNER JOIN departamento as d ON m.idDepartamento=d.idDepartamento';
				$query = $connect->prepare($sql);
		    	if ($query->execute()){
		    		$response["object"] = $query->fetchAll(PDO::FETCH_ASSOC);
					$response["total"] = $query->rowCount();
		    	} else {
		            $response = array("status"=>"error", "error"=>"No se pudo ejecutar la consulta a la base de datos");
		        }
			} catch(PDOException $exception) {
		    	$response = array("status"=>"error", "error"=>"Ocurrió el siguiente error: " . $exception->getMessage());
            } finally {
                $connection->disconnect();
            }
	    } else {
	    	$response = array("status"=>"error", "error"=>"No está conectado al servidor de bases de datos");
	    } 
	    return $response;
    }
}

?>