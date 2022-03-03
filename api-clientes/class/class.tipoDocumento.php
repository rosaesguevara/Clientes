<?php  

class tipoDocumento {

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
				$sql = 'SELECT idTipoDocumento, tipoDocumento FROM tipodocumento';
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